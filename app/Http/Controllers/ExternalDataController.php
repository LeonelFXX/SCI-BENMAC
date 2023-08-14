<?php

namespace App\Http\Controllers;

use App\Models\ExternalPA;
use App\Models\ExternalStudents;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Spatie\Permission\Models\Role;

class ExternalDataController extends Controller
{
    /*
    Función:
    */
    public function mostrarVistaMatricula()
    {
        return view('matricula');
    }

    /*
    Función:
    */
    public function validarMatricula(Request $request)
    {
        $errors = new MessageBag();

        $matricula = $request->input('matricula');

        $usuario = User::where('matricula', $matricula)->first();
        $estudiante = ExternalStudents::where('matricula', $matricula)->first();

        if ($usuario) {
            $errors = ['matricula' => 'La matrícula que ingresaste ya se encuentra registrada.'];
            return redirect()->back()->withErrors($errors);
        }

        if ($estudiante) {
            return view('auth.register', ['estudiante' => $estudiante]);
        }

        $errors = ['matricula' => 'La matrícula que ingresaste no se encuentra en los registros.'];
        return redirect()->back()->withErrors($errors);
    }

    /*
    Función:
    */
    public function mostrarVistaClave()
    {
        return view('clave');
    }

    /*
    Función:
    */
    public function validarClave(Request $request)
    {
        $errors = new MessageBag();

        $clave = $request->input('matricula');

        $usuario = User::where('matricula', $clave)->first();
        $personal_administrativo = ExternalPA::where('clave_administrativa', $clave)->first();

        if ($usuario) {
            $errors = ['matricula' => 'La clave que ingresaste ya se encuentra registrada.'];
            return redirect()->back()->withErrors($errors);
        }

        if ($personal_administrativo) {
            $roles = Role::all();
            
            return view('users.create', [
                'personal_administrativo' => $personal_administrativo,
                'roles' => $roles
            ]);
        }

        $errors = ['matricula' => 'La clave que ingresaste no se encuentra en los registros.'];
        return redirect()->back()->withErrors($errors);
    }
}