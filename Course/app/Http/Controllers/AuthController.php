<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function index()
    {
        return  view('auth.login');
    }


    public function accueil()
    {
        //dd(Auth::user());
        return  view('auth.accueil');
        //dd(Auth::user()->getAuthIdentifier());
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    public function pageRegistre()
    {
        return view('auth.registre');
    }

    public function registre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4|confirmed:password_confirmation',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => 'equipe'
            ]);
            Auth::login($user);
            return redirect()->intended('liste-etape');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            if(Auth::user()->role == 'admin'){
                return redirect()->intended('classement');
            }elseif(Auth::user()->role == 'equipe'){
                return redirect()->intended('liste-etape');
            }

        }
    return to_route('auth.login')->withErrors([
        'email' => 'Adresse mail ou mot de passe incorrect',
    ])->onlyInput('email');
    }
}
