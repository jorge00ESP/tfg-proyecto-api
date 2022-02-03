<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function create(Request $request){
        $data=$request->only(['hora', 'fecha', 'id_empresa']);

        $request->validate([
            'hora'=> 'required|date_format:H:i',
            'fecha'=> 'required|date|date_format:Y/m/d',
            'id_empresa'=>'required|integer'
        ]);

        try{
            DB::table('invoices')->insert($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Factura creada con exito',
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

    public function get($id){
        $invoice=Invoice::find($id);

        if($invoice==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta factura',
                'data'    => null
            ], 400);
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Empresa recogida',
            'data'    => $invoice
        ], 200);
    }

    public function empresa($id){
        $factura=Invoice::find($id);

        if($factura==null){
            return response()->json([
                'success' => false,
                'mensaje' => 'No existe esta factura',
                'data'    => null
            ]);
        }

        return $factura->empresa;
    }

}
