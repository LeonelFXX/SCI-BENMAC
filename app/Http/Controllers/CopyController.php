<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Copy;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class CopyController extends Controller
{
    /*
    Función: Configura la solicitud de copias.
    */
    public function solicitarCopias(Request $request)
    {
        $errors = new MessageBag;

        $price = Price::find(1);

        $usuario = Auth::user();

        $request->validate([
            'color' => ['required', 'numeric', 'min:0'],
            'blanco_y_negro' => ['required', 'numeric', 'min:0']
        ]);

        $hojas_color = $request->color;
        $hojas_byn = $request->blanco_y_negro;

        $total_hojas = $hojas_color + $hojas_byn;

        $coste_hojas_color = $hojas_color * $price->color;
        $coste_hojas_byn = $hojas_byn * $price->blanco_y_negro;

        $total_coste = $coste_hojas_color + $coste_hojas_byn;

        if ($total_coste > $usuario->saldo) {
            $errors->add('Error', 'No cuentas con el saldo suficiente para continuar con la solicitud de copias.');

            return redirect()->back()->withErrors($errors);
        } else {
            DB::beginTransaction();

            try {
                // Descuenta El Coste
                $usuario->saldo -= $total_coste;
                $usuario->save();

                // Crea La Solicitud
                $solicitud = new Copy();
                $solicitud->user_id = $usuario->id;
                $solicitud->numero_copias = $total_hojas;
                $solicitud->color = $hojas_color;
                $solicitud->blanco_y_negro = $hojas_byn;
                $solicitud->coste_copias = $total_coste;
                $solicitud->encargado = null;
                $solicitud->save();

                DB::commit();
                return redirect()->back()->with('success', 'Tu solicitud ha sido enviada a revisión. Puedes ver los detalles en "Solicitudes De Copias" en tu perfil.');
            } catch (\Exception $e) {
                DB::rollBack();

                return $e->getMessage();
            }
        }
    }

    /*
    Fnción: Cancela la solicitud de copias.
    */
    public function rollbackCopia($id)
    {
        DB::beginTransaction();

        try {
            $solicitud = Copy::find($id);
            $usuario = User::find($solicitud->user_id);

            $usuario->saldo += $solicitud->coste_copias;
            $usuario->save();

            $solicitud->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
        return redirect()->route('home')->with('success', 'Solicitud Deshecha Correctamente.');
    }

    /*
    Función: Mostrar el panel de solicitudes de copias
    */
    public function mostrarPanelSolicitudesCopias()
    {
        $id = Auth::user()->id;

        $resultados = DB::table('users')
            ->join('copies', 'users.id', '=', 'copies.user_id')
            ->select('copies.id', 'copies.color', 'copies.blanco_y_negro', 'copies.numero_copias', 'copies.estado', 'copies.fecha_copias', 'copies.coste_copias')
            ->where('copies.user_id', '=', $id)
            ->where('copies.estado', '=', 'Pendiente')
            ->paginate(4);

        return view('panel-solicitudes-copias', compact('resultados'));
    }

    /*
    Función: Muestra la vista con las solicitudes para copias.
    */
    public function mostrarVistaSolicitudesCopias()
    {
        $solicitudes = DB::table('copies')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $realizados = DB::table('copies')
            ->where('estado', '=', 'Realizado')
            ->count();

        $solicitud = DB::table('copies')
            ->select(
                'copies.id',
                'copies.estado',
                'copies.numero_copias',
                'copies.color',
                'copies.blanco_y_negro',
                'copies.fecha_copias',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'users.licenciatura'
            )
            ->join('users', 'users.id', '=', 'copies.user_id')
            ->where('copies.estado', 'Pendiente');

        $resultados = $solicitud->paginate(4);

        return view('copies.solicitudes-copias', compact('solicitudes', 'realizados', 'resultados'));
    }

    /*
    Función: Muestra las copias que han sido realizadas.
    */
    public function mostrarVistaCopiasRealizadas()
    {
        $solicitudes = DB::table('copies')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $realizados = DB::table('copies')
            ->where('estado', '=', 'Realizado')
            ->count();

        $solicitud = DB::table('copies')
            ->select(
                'copies.id',
                'copies.estado',
                'copies.numero_copias',
                'copies.color',
                'copies.blanco_y_negro',
                'copies.fecha_copias',
                'copies.encargado',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'users.licenciatura'
            )
            ->join('users', 'users.id', '=', 'copies.user_id')
            ->where('copies.estado', 'Realizado');

        $resultados = $solicitud->paginate(7);

        return view('copies.copias-realizadas', compact('solicitudes', 'realizados', 'resultados'));
    }

    /*
    Función: Actualizar el estado de la solicitud de copiado.
    */
    public function controlarSolicitudCopia($id)
    {
        $solicitud = Copy::find($id);

        $nombre = Auth::user()->name;
        $ap = Auth::user()->apellido_paterno;
        $am = Auth::user()->apellido_materno;
        $encargado = $nombre . " " . $ap . " " . $am;

        if ($solicitud) {
            $solicitud->estado = "Realizado";
            $solicitud->encargado = $encargado;
            $solicitud->save();

            return redirect()->back()->with('success', 'Se ha completado el copiado correctamente.');
        }
    }
}