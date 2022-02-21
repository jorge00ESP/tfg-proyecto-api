<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials=$request->validate([
            'email' => 'nullable',
            'nombre'=> 'nullable',
            'password' => 'required'
        ]);

        if(Auth::check()){
            return response()->json([
                'success' => false,
                'mensaje' => 'Ya hay un usuario logueado',
                'data'    => null
            ], 400);
        }

        $datosLogin['password']=$credentials['password'];

        if($credentials['email']==null){
            $datosLogin['nombre']=$credentials['nombre'];
        }

        if($credentials['nombre']==null){
            $datosLogin['email']=$credentials['email'];
        }

        if(Auth::attempt($datosLogin)){
            $user=Auth::user();
            return response()->json([
                'success' => true,
                'mensaje' => 'SESION INICIADA',
                'data'    => [
                    $user,
                    $user->createToken('loginController')->accessToken
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'mensaje' => 'No se ha podido loguear',
            'data'    => null
        ], 400);
    }

    public function logout(){
        $user=Auth::user();

        if($user==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No se ha logeado ningun usuario',
                'data'    => null
            ]);
        }

        Auth::logout();

        return response()->json([
            'success' => true,
            'mensaje' => 'El usuario ha cerrado la sesion',
            'data'    => $user
        ]);
    }

    public function getData(){
        $user=Auth::user();

        dd($user);

        return response()->json([
            'success' => true,
            'mensaje' => 'DATOS DE USUARIO',
            'data'    => $user
        ]);
    }
}
