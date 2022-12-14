<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
            'name' => ['required', 'string', 'max:255', 'not_regex:/[@$!%*#?&]/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[A-Z]/', 'min:8', 'confirmed', 'max:20'],
            ],
            [
                'required'  => 'Te falto ingresar el/la :attribute.',
                'string'    => ':attribute debe tener texto.',
                'name.not_regex' => 'El :attribute es invalido',
                'password.regex' => 'La contraseña debe contener letras, números y al menos una letra mayúscula',
                'min'       => 'La :attribute debe tener minimo :min caracteres.',
                'max'       => 'El :attribute debe tener maximo :max caracteres.',
                'email'     => 'Parece que no es un :attribute de :attribute valido .',
                'unique'    => 'El :attribute no es unico.',
                'confirmed' => 'La :attribute no se confirmo correctamente.'
            ],
            [
                'name'     => 'nombre de usuario',
                'email'    => 'correo eletronico',
                'password' => 'contraseña'
            ]
        );

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 2,
            'password' => Hash::make($data['password']),
        ]);
    }
}
