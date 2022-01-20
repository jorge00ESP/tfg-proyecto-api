<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['mensaje', 'fecha', 'hora', 'leido', 'id_user_emisor', 'id_user_receptor']);

        $request->validate([
           'mensaje'=>'required|string|max:50',
            'hora'=> 'required|date_format:H:i',
            'fecha'=> 'required|date|date_format:Y/m/d',
            'leido'=>'required|boolean',
            'id_user_emisor'=>'nullable|integer',
            'id_user_receptor'=>'nullable|integer'
        ]);

        $emisor=User::find($data['id_user_emisor']);

        if($emisor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario emisor',
                'data'    => null
            ]);
        }

        $receptor=User::find($data['id_user_receptor']);

        if($receptor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario receptor',
                'data'    => null
            ]);
        }

        DB::table('messages')->insert($data);

        return response()->json([
            'success' => true,
            'mensaje' => 'Mensaje creado con exito',
            'data'    => $data
        ], 200);
    }
}
