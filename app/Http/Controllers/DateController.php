<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Date;
use App\Models\User;

class DateController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['id_trabajador', 'id_cliente', 'hora', 'fecha', 'descripcion']);

        $request->validate([
            'id_trabajador' => 'required|numeric|digits:1',
            'id_cliente' =>  'required|numeric|digits:1',
            'hora'=> 'required|date_format:H:i',
            'fecha'=> 'required|date|date_format:Y/m/d',
            'descripcion'=>'nullable|string|max:255'
        ]);

        try{
            DB::table('dates')->insert($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Cita creada con exito',
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

    public function delete($id){
        $date = DB::table('dates')->where('id', $id)->first();
        if ($date === null) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Cita no encontrado',
                'data'    => null
            ], 404);
        }

        DB::table('dates')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Cita borrado correctamente',
            'data'    => $date
        ]);
    }

    public function getAll(){
        return Date::all()->toJson();
    }

    public function get($id){
            return Date::find($id);
    }

    public function getDateUsers($id){
        $user=User::find($id);

        if($user==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este usuario',
                'data'    => null
            ]);
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Citas recogidas',
            'data' =>  Date::where('id_trabajador',$id)->orWhere('id_cliente',$id)->get()
        ], 200);
    }
}
