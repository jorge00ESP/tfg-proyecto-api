<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function sesion(){
        return response()->json([
            'success' => false,
            'message' => 'No has iniciado sesion',
            'data' => null
        ], 400);
    }
}
