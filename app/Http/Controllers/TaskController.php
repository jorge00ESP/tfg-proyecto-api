<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['asunto', 'descripcion', 'hora', 'fecha', 'id_usuario']);

        $request->validate([
            'asunto' => 'required|string|max:20',
            'descripcion'=>'nullable|string|max:255',
            'hora'=> 'required|date_format:H:i',
            'fecha'=> 'required|date|date_format:Y/m/d',
            'id_usuario'=>'required|integer'
        ]);

        $user=User::find($data['id_usuario']);

        if($user==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este usuario',
                'data'    => null
            ]);
        }

        DB::table('tasks')->insert($data);

        return response()->json([
            'success' => true,
            'mensaje' => 'Tarea creado con exito',
            'data'    => $data
        ], 200);
    }

    public function getAll(){
        return Task::all()->toJson();
    }

    public function get($id){
        $task=Task::find($id);

        if($task==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta tarea',
                'data'    => null
            ]);
        }

        return $task->toJson();
    }

    public function delete($id){
        $task = DB::table('tasks')->where('id', $id)->first();

        if ($task === null) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Usuario no encontrado',
                'data'    => null
            ], 404);
        }

        DB::table('tasks')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Tarea borrado correctamente',
            'data'    => $task
        ]);
    }

    public function update(Request $request, $id){

        $data=$request->only(['asunto', 'descripcion', 'hora', 'fecha', 'id_usuario']);

        $request->validate([
            'asunto' => 'nullable|string|max:20',
            'descripcion'=>'nullable|string|max:255',
            'hora'=> 'nullable|date_format:H:i',
            'fecha'=> 'nullable|date|date_format:Y/m/d',
            'id_usuario'=>'nullable|integer'
        ]);


        $task=Task::find($id);

        if($task==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta tarea',
                'data'    => null
            ]);
        }

        $asunto=$data['asunto'];
        $descripcion=$data['descripcion'];
        $hora=$data['hora'];
        $fecha=$data['fecha'];
        $id_usuario=$data['id_usuario'];

        $data=[];

        if(!empty($id_usuario)){
            $user=User::find($id_usuario);

            if($user==null){
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No existe este usuario',
                    'data'    => null
                ]);
            }

            $data['id_usuario']=$id_usuario;
        }

        if(!empty($asunto)){
            $data['asunto']=$asunto;
        }

        if(!empty($descripcion)){
            $data['descripcion']=$descripcion;
        }

        if(!empty($hora)){
            $data['hora']=$hora;
        }

        if(!empty($fecha)){
            $data['fecha']=$fecha;
        }

        Task::where('id', $id)->update($data);

        $task=Task::find($id);

        return response()->json($task, 200);

    }

    public function user($id){
        $task=Task::find($id);

        if($task==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta tarea',
                'data'    => null
            ]);
        }

        return $task->user;
    }

}
