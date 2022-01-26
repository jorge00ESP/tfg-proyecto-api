<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['nombre', 'precio', 'cantidad', 'descripcion', 'id_categoria']);

        $request->validate([
            'nombre' => 'required|string|max:20',
            'precio'=> 'required|numeric',
            'cantidad'=> 'required|integer',
            'descripcion'=>'nullable|string|max:100',
            'id_categoria'=>'nullable|integer'
        ]);

        try{
            DB::table('products')->insert($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Producto creado con exito',
                'data'    => $data
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'mensaje' => 'El producto no ha sido creado',
                'data'    => null,
            ], 500);
        }
    }

    public function get($id){
        $product=Product::find($id);

        if($product==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este producto',
                'data'    => null
            ], 400);
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Producto recogido',
            'data'    => $product
        ], 200);
    }

    public function getAll(){
        return response()->json([
            'success' => true,
            'mensaje' => 'Todos los productos',
            'data'    => Product::all()
        ], 200);
    }

    public function delete($id){
        $product=Product::find($id);

        if($product==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este producto',
                'data'    => null
            ], 400);
        }

        DB::table('products')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'mensaje' => 'Producto borrado con exito',
            'data'    => $product
        ], 200);
    }

    public function update(Request $request, $id){
        $data=$request->only(['nombre', 'precio', 'cantidad', 'descripcion', 'id_categoria']);

        $validation = $request->validate([
            'nombre' => 'required|string|max:20',
            'precio'=> 'required|numeric',
            'cantidad'=> 'required|integer',
            'descripcion'=>'nullable|string|max:100',
            'id_categoria'=>'nullable|integer'
        ]);

        if (!$validation){
            return response()->json(null, 403);
        }

        //dd($validation);

       /* $user=User::find($id);

        if($user==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este usuario',
                'data'    => null
            ]);
        }*/

        $nombre=$data['nombre'];
        $apellido=$data['apellido'];
        $password=$data['password'];
        $email=$data['email'];
        $id_rol=$data['id_rol'];

        $data=[];

        if(!empty($id_rol)){
            if($id_rol<1 || $id_rol>4){
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No existe este rol',
                    'data'    => null
                ]);
            }else{
                $data['id_rol']=$id_rol;
            }
        }

        if(!empty($nombre)){
            $data['nombre']=$nombre;
        }

        if(!empty($apellido)){
            $data['apellido']=$apellido;
        }

        if(!empty($password)){
            $data['password']=$password;
        }

        if(!empty($email)){
            $data['email']=$email;
        }

        User::where('id', $id)->update($data);

        $user=User::find($id);

        return response()->json($user, 200);
    }
}
