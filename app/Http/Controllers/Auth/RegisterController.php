<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
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
                // Valida Únicamente El Registro De Correos Con El Dominio BENMAC
                Rule::unique('users'),
                function ($attribute, $value, $fail) {
                    $allowedDomain = 'benmac.edu.mx'; // Dominio BENMAC
        
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

            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
            'licenciatura' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        return User::create([
            'matricula' => ($data['matricula']),
            'name' => ($data['name']),
            'apellido_paterno' => ($data['apellido_paterno']),
            'apellido_materno' => ($data['apellido_materno']),
            'telefono' => ($data['telefono']),
            'email' => ($data['email']),
            'password' => Hash::make($data['password']),
            'licenciatura' => ($data['licenciatura'])
        ]);
    }
}