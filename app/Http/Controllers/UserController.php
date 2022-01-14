<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function deleteUser($id) {

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

        $validation = $request->validate([
            'nombre' => 'required|string|max:32',
            'apellido' =>  'string|max:32',
            'password'=> 'string|max:255',
            'email'=> 'email:rfc,dns|max:255',
            'id_rol'=>'numeric|digits:1'
        ]);

        if (!$validation){
            return response()->json(null, 403);
        }

        dd($validation);

        $data=$request->only(['nombre', 'apellido', 'password', 'email', 'id_rol']);

        $user=User::find($id);

        if($user==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este usuario',
                'data'    => null
            ]);
        }



        $nombre=$data['nombre'];
        $apellido=$data['apellido'];
        $password=$data['password'];
        $email=$data['email'];
        $id_rol=$data['id_rol'];

        if($id_rol<1 || $id_rol>4){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este rol',
                'data'    => null
            ]);
        }

        return response()->json($user, 200);

    }
}
