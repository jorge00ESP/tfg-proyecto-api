<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAll(){
        return User::all()->toJson();
    }

    public function get($id){
        return User::find($id);
    }

    public function createUser(Request $request){
        $data=$request->only(['nombre', 'apellido', 'password', 'email', 'id_rol']);

        $request->validate([
            'nombre' => 'required|string|max:32',
            'apellido' =>  'required|string|max:32',
            'password'=> 'required|max:255',
            'email'=> 'required|email:rfc,dns|max:255',
            'id_rol'=>'required|integer|digits_between:0,3'
        ]);

        try{
            DB::table('users')->insert($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Usuario creado con exito',
                'data'    => $data
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage(),
                'data'    => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function deleteUser(Request $request, $id) {

        $user = DB::table('users')->where('id', $id)->first();
        if ($user === null) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Usuario no encontrado',
                'data'    => null
            ], 404);
        }

        DB::table('users')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Usuario borrado correctamente',
            'data'    => $user
        ]);

    }

    public function getRolUser($id){
        $user = User::find($id);
        if($user === null) return 'El usuario no EXISTE';

        //DB::connection()->enableQueryLog();

        $rol = $user->role;
       // dd(DB::getQueryLog());
        if($rol === null) return 'ROL no encontrado';

        return $user->role->toJson();
    }

    public function updateUser(Request $request, $id){
        $data=$request->only(['nombre', 'apellido', 'password', 'email', 'id_rol']);

        if($data['id_rol']<2 || $data['id_rol']>5){
            return response()->json([
                'success' => true,
                'mensaje' => 'No existe este rol',
                'data'    => null
            ]);
        }
    }
}
