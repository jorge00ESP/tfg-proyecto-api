<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IdUserNumeric;
use App\Http\Controllers\DateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function (){
    Route::get('', [UserController::class, 'getAll']);
    Route::post('newUser', [UserController::class, 'createUser']);

    Route::prefix('{id}')->group(function (){
        Route::middleware(IdUserNumeric::class)->group(function (){
            Route::get('', [UserController::class, 'get']);
            Route::get('rol', [UserController::class, 'getRolUser']);
            Route::delete('deleteUser', [UserController::class, 'deleteUser']);
            Route::patch('updateUser', [UserController::class, 'updateUser']);
        });
    });
});

Route::prefix('date')->group(function (){
    Route::get('', [DateController::class, 'getAll']);
    Route::post('newDate', [DateController::class, 'createDate']);

    Route::prefix('{id}')->group(function (){
        Route::middleware(IdUserNumeric::class)->group(function (){
            Route::get('', [DateController::class, 'get']);
            Route::delete('deleteDate', [DateController::class, 'deleteDate']);
        });
    });
});
