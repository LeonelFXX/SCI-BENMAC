<?php

namespace App\Http\Controllers;

use App\Models\Binding;
use App\Models\Price;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class BindingController extends Controller
{
    /*
    Función: Muestra la vista con las solicitudes para engargolados.
    */
    public function mostrarVistaSolicitudes()
    {
        // Carga El Número De Solicitudes Pendientes
        $solicitudes = DB::table('bindings')
            ->where('estado', '=', 'Pendiente')
            ->count();

        // Carga El Número De Engargolados Realizados
        $realizados = DB::table('bindings')
            ->where('estado', '=', 'Realizado')
            ->count();

        // Carga Los Datos De Las Solicitudes
        $query = DB::table('bindings')
            ->select(
                'bindings.id',
                'bindings.estado',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'users.licenciatura'
            )
            ->join('users', 'users.id', '=', 'bindings.user_id')
            ->where('bindings.estado', 'Pendiente');

        $datos_solicitudes = $query->get();

        return view('bindings.solicitudes', compact('solicitudes', 'realizados', 'datos_solicitudes'));
    }

    /*
    Función: Muestra los engargolados realizados.
    */
    public function mostrarVistaEngargolados()
    {
        // Carga El Número De Solicitudes Pendientes
        $solicitudes = DB::table('bindings')
            ->where('estado', '=', 'Pendiente')
            ->count();

        // Carga El Número De Engargolados Realizados
        $realizados = DB::table('bindings')
            ->where('estado', '=', 'Realizado')
            ->count();

        // Carga Los Datos De Los Engargolados Realizados
        $query = DB::table('bindings')
            ->select(
                'bindings.id',
                'bindings.estado',
                'bindings.encargado',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'users.licenciatura'
            )
            ->join('users', 'users.id', '=', 'bindings.user_id')
            ->where('bindings.estado', 'Realizado');

        $datos_engargolados = $query->paginate(10);

        return view('bindings.engargolados', compact('solicitudes', 'realizados', 'datos_engargolados'));
    }

    /*
    Función: Crea solicitud para engargolado.
    */
    public function crearSolicitud()
    {
        $usuario = Auth::user();

        $price = Price::find(1);

        if ($price->engargolado > $usuario->saldo) {
            $errors = new MessageBag();

            $errors->add('Error', 'No cuentas con el saldo suficiente para continuar con el proceso de engargolado.');

            return redirect()->back()->withErrors($errors);
        } else {
            DB::beginTransaction();

            try {
                // Decrementa El Saldo Del Usuario Por El Coste Del Engargolado
                $usuario->saldo -= $price->engargolado;
                $usuario->save();

                // Crea La Solicitud De Engargolado
                $solicitud = new Binding();
                $solicitud->user_id = $usuario->id;
                $solicitud->coste_engargolado = $price->engargolado;
                $solicitud->estado = "Pendiente";
                $solicitud->encargado = null;
                $solicitud->save();

                DB::commit();

                return redirect()->route('home')->with('success', 'Se ha solicitado un engargolado.');
            } catch (\Exception $e) {
                DB::rollBack();

                return $e->getMessage();
            }
        }
    }

    /*
    Función: Actualizar el estado de la solicitud de engargolado.
    */
    public function controlarSolicitudes($id)
    {
        $engargolado = Binding::find($id);

        $nombre = Auth::user()->name;
        $ap = Auth::user()->apellido_paterno;
        $am = Auth::user()->apellido_materno;
        $encargado = $nombre . " " . $ap . " " . $am;

        if ($engargolado) {
            $engargolado->estado = "Realizado";
            $engargolado->encargado = $encargado;
            $engargolado->save();

            return redirect()->back()->with('success', 'Se ha completado el engargolado correctamente.');
        }
    }

    /*
    Función: Mostrar todas las solicitudes de engargolado.
    */
    public function mostrarSolicitudesPendientes()
    {
        $id = Auth::user()->id;

        // Mostrar Solicitudes Pendientes
        $query = DB::table('users')
            ->select('bindings.id', 'bindings.coste_engargolado', 'bindings.fecha_engargolado', 'bindings.estado')
            ->join('bindings', 'users.id', '=', 'bindings.user_id')
            ->where('users.id', '=', $id)
            ->where('bindings.estado', '=', 'Pendiente');

        $historial_pendientes = $query->paginate(4);

        return view('usuario-solicitudes', compact('historial_pendientes'));
    }

    /*
    Función: Elimina la solicitud de engargolado.
    */
    public function rollbackSolicitud($id)
    {
        DB::beginTransaction();

        try {
            $solicitud = Binding::find($id);

            if ($solicitud && $solicitud->estado === 'Pendiente') {
                $userId = $solicitud->user_id;
                $costeEngargolado = $solicitud->coste_engargolado;
            }

            $usuario = User::find($userId);

            $usuario->saldo += $costeEngargolado;
            $usuario->save();

            $solicitud->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Transacción Deshecha Correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}