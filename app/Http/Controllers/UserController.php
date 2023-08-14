<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /* 
    Función: Muestra la vista Index con todos los usuarios creados.
             Cuenta con una paginación de 6 usuarios por página.
    */
    public function index()
    {
        $users = User::paginate(6);

        return view('users.index', ['users' => $users]);
    }

    /*
    Función: Muestra la vista Create para crear un nuevo usuario. 
    */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /* 
    Función: Valida los datos para la creación de un nuevo usuario.
             Valida que solamente el dominio de correo de BENMAC pueda ser utilizado.
    */
    public function store(Request $request)
    {
        $request->validate([
            'matricula' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users'),
                function ($attribute, $value, $fail) {
                    $allowedDomain = 'benmac.edu.mx';

                    if (strpos($value, '@') !== false) {
                        [$user, $domain] = explode('@', $value);

                        if ($domain !== $allowedDomain) {
                            $fail('El dominio del correo electrónico debe ser @' . $allowedDomain);
                        }
                    } else {
                        $fail('El formato del correo electrónico es inválido.');
                    }
                },
            ],

            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'matricula' => $request->matricula,
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'licenciatura' => 'Personal Administrativo',
            'tipo_usuario' => '5'
        ]);

        $role = $request->input('role');
        $user->syncRoles($role);

        return redirect()->route('users.index')->with('success', 'Nuevo Usuario Creado Correctamente.');
    }

    /*
    Función: Muestra la vista Edit para editar los datos de un usuario. 
    */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /* 
    Función: Valida y actualiza los datos de un usuario.
             Actualiza el nuevo rol del usuario.            
    */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'licenciatura' => ['required', 'string', 'max:255'],
            'tipo_usuario' => ['required', 'string', 'max:255']
        ]);

        $role = Role::findById($request->input('tipo_usuario'));

        $user->syncRoles($role); // Actualiza El Rol Del Usuario

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'Usuario Actualizado Correctamente.');
    }

    /*
    Función: Elimina al usuario.
    */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario Eliminado Correctamente.');
    }

    /*
    Función: Muestra la vista Show para cargar saldo a un usuario.
    */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}