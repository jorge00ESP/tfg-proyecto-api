<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class LineController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['invoice_id', 'product_id', 'cantidad']);

        $request->validate([
            'invoice_id'=>'required|integer',
            'product_id'=>'required|integer',
            'cantidad' => 'required|integer'
        ]);

        $factura=Invoice::find($data['invoice_id']);
        $producto=Product::find($data['product_id']);

        if($factura==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta factura',
                'data'    => null
            ], 400);
        }

        if($producto==null) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe este producto',
                'data' => null
            ], 400);
        }

        DB::table('lines')->insert($data);

        return response()->json([
            'success' => true,
            'mensaje' => 'Linea creada con exito',
            'data'    => $data
        ], 200);
    }
}
