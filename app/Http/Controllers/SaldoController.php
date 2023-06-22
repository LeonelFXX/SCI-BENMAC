<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\MessageBag;

class SaldoController extends Controller
{

    /*
    Función: Cargar saldo a un usuario.
    */
    public function cargarSaldo(Request $request, $id)
    {
        $errors = new MessageBag(); // Nueva Instancia De La Libreria De Errores 

        $cantidad = $request->input('cantidad');

        $usuario = User::find($id); // Se Busca Al Usuario Por Su ID

        // Si Encuentra Al Usuario...
        if ($usuario) {
            if (is_numeric($cantidad) && $cantidad >= 0) { // Valida Que La Cantidad Sea Un Valor Númerico Y Que Sea Positivo

                $usuario->saldo += $cantidad; // Incrementa El Saldo

                $usuario->save();

                return redirect()->route('users.index')->with('success', 'Se Agrego El Saldo Correctamente.');
            } else {
                $errors->add('Error', 'Lo que ingresaste no es un valor númerico o es un número negativo');

                return redirect()->back()->withErrors($errors);
            }
        }
    }

    /*
    Función: Cargar saldo desde un modal.
    */
    public function cargarSaldoModal(Request $request)
    {
        $errors = new MessageBag();

        $matricula = $request->input('matricula');
        $cantidad = $request->input('cantidad');

        $usuario = User::where('matricula', $matricula)->first();

        if ($usuario) {
            if (is_numeric($cantidad) && $cantidad >= 0) { // Valida Que La Cantidad Sea Un Valor Númerico Y Que Sea Positivo
                $usuario->saldo += $cantidad;

                $usuario->save();

                return redirect()->route('users.index')->with('success', 'Se Agrego El Saldo Correctamente.');
            }
            $errors->add('Error', 'Lo que ingresaste no es un valor númerico o es un número negativo');

            return redirect()->back()->withErrors($errors);
        } else {
            $errors->add('Error', 'La matrícula que ingresaste no se encuentra en los registros.');

            return redirect()->back()->withErrors($errors);
        }
    }

    /*
    Función: Quitar saldo desde un modal.
    */
    public function quitarSaldoModal(Request $request)
    {
        $errors = new MessageBag();

        $matricula = $request->input('matricula');
        $cantidad = $request->input('cantidad');

        $usuario = User::where('matricula', $matricula)->first();

        if ($usuario) {
            if (is_numeric($cantidad) && $cantidad >= 0) { // Valida Que La Cantidad Sea Un Valor Númerico Y Que Sea Positivo
                if ($cantidad > $usuario->saldo || $usuario->saldo == 0) {
                    $errors->add('Error', 'No se pudo completar la transacción.');

                    return redirect()->back()->withErrors($errors);
                } else {
                    $usuario->saldo -= $cantidad;

                    $usuario->save();

                    return redirect()->route('users.index')->with('success', 'Se Quito El Saldo Correctamente.');
                }
            }
            $errors->add('Error', 'Lo que ingresaste no es un valor númerico o es un número negativo');

            return redirect()->back()->withErrors($errors);
        } else {
            $errors->add('Error', 'La matrícula que ingresaste no se encuentra en los registros.');

            return redirect()->back()->withErrors($errors);
        }
    }
}