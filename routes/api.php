<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IdUserNumeric;
use App\Http\Controllers\DateController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MessagesController;
use App\Http\Middleware\Sesion;
use App\Http\Controllers\ErrorController;

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

Route::get('error',[ErrorController::class, 'sesion'])->name('sesion_error');

Route::prefix('user')->group(function (){
    Route::middleware(Sesion::class)->group(function (){
        Route::get('', [UserController::class, 'getAll']);
        Route::post('create', [UserController::class, 'create']);

        Route::prefix('{id}')->group(function (){
            Route::middleware(IdUserNumeric::class)->group(function (){
                Route::get('', [UserController::class, 'get']);
                Route::delete('delete', [UserController::class, 'delete']);
                Route::patch('update', [UserController::class, 'update']);
                Route::get('rol', [UserController::class, 'rol']);
                Route::get('tasks', [UserController::class, 'task']);
            });
        });
    });

});

Route::prefix('rol')->group(function (){
    Route::middleware(Sesion::class)->group(function (){
        Route::prefix('{id}')->group(function (){
            Route::middleware(IdUserNumeric::class)->group(function (){
                Route::get('users',[RoleController::class, 'users']);
            });
        });
    });
});

Route::prefix('date')->group(function (){
    Route::middleware(Sesion::class)->group(function (){
        Route::get('', [DateController::class, 'getAll']);
        Route::post('create', [DateController::class, 'create']);

        Route::prefix('{id}')->group(function (){
            Route::middleware(IdUserNumeric::class)->group(function (){
                Route::get('', [DateController::class, 'get']);
                Route::delete('delete', [DateController::class, 'delete']);
                Route::get('getDatesUser', [DateController::class, 'getDateUsers']);
            });
        });
    });
});

Route::prefix('task')->group(function (){
    Route::middleware(Sesion::class)->group(function (){
        Route::post('create', [TaskController::class, 'create']);
        Route::get('', [TaskController::class, 'getAll']);

        Route::prefix('{id}')->group(function (){
            Route::middleware(IdUserNumeric::class)->group(function (){
                Route::get('', [TaskController::class, 'get']);
                Route::delete('delete', [TaskController::class, 'delete']);
                Route::patch('update', [TaskController::class, 'update']);
                Route::get('user', [TaskController::class, 'user']);
            });
        });
    });
});

Route::prefix('message')->group(function (){
    Route::post('create', [MessagesController::class, 'create']);
});

Route::prefix('login')->group(function (){
    Route::post('', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
});
