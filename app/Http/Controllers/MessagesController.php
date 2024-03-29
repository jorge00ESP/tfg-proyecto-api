<?php

namespace App\Http\Controllers;

use App\Models\Messages;
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
            'id_user_emisor'=>'required|integer',
            'id_user_receptor'=>'required|integer'
        ]);

        $emisor=User::find($data['id_user_emisor']);

        if($emisor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario emisor',
                'data'    => null
            ], 400);
        }

        $receptor=User::find($data['id_user_receptor']);

        if($receptor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario receptor',
                'data'    => null
            ], 400);
        }

        DB::table('messages')->insert($data);

        return response()->json([
            'success' => true,
            'mensaje' => 'Mensaje creado con exito',
            'data'    => $data
        ], 200);
    }

    public function get(Request $request){
        $data=$request->only(['id_user_emisor', 'id_user_receptor']);

        $emisor=User::find($data['id_user_emisor']);

        if($emisor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario emisor',
                'data'    => null
            ], 400);
        }

        $receptor=User::find($data['id_user_receptor']);

        if($receptor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario receptor',
                'data'    => null
            ], 400);
        }

        //dd($emisor);

        return response()->json([
            'success' => true,
            'mensaje' => 'mensajes',
            'data' =>  Messages::where('id_user_emisor',$emisor['id'])->where('id_user_receptor', $receptor['id'])->get()
        ], 200);
    }

    public function look(Request $request){
        $data=$request->only(['id_user_emisor', 'id_user_receptor']);

        $emisor=User::find($data['id_user_emisor']);

        if($emisor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario emisor',
                'data'    => null
            ], 400);
        }

        $receptor=User::find($data['id_user_receptor']);

        if($receptor==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe el usuario receptor',
                'data'    => null
            ], 400);
        }

        Messages::where('id_user_emisor',$emisor['id'])
            ->where('id_user_receptor', $receptor['id'])
            ->where('leido', false)
            ->update([
                'leido'=>true
            ]);

        //dd($mensajes);

        return response()->json([
            'success' => true,
            'mensaje' => 'Leidos',
            'data'=> null
        ]);
    }
}
