<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        $request->validate([
            'nombre' => 'nullable|string|max:20',
            'precio'=> 'nullable|numeric',
            'cantidad'=> 'nullable|integer',
            'descripcion'=>'nullable|string|max:100',
            'id_categoria'=>'nullable|integer'
        ]);

        $nombre=$data['nombre'];
        $precio=$data['precio'];
        $cantidad=$data['cantidad'];
        $descripcion=$data['descripcion'];
        $id_categoria=$data['id_categoria'];

        $data=[];

        if(!empty($id_categoria)){
            $categoria=Category::find($id_categoria);
            if($categoria==null){
                return response()->json([
                    'success' => false,
                    'mensaje' => 'La categoria no existe',
                    'data'    => null,
                ], 400);
            }

            $data['id_categoria']=$categoria['id'];
        }

        if(!empty($nombre)){
            $data['nombre']=$nombre;
        }

        if(!empty($precio)){
            $data['precio']=$precio;
        }

        if(!empty($cantidad)){
            $data['cantidad']=$cantidad;
        }

        if(!empty($descripcion)){
            $data['descripcion']=$descripcion;
        }

        Product::where('id', $id)->update($data);

        $producto=Product::find($id);

        return response()->json($producto, 200);
    }

    public function category($id){
        $product=Product::find($id);

        if($product==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta categoria',
                'data'    => null
            ]);
        }

        return $product->category;
    }
}
