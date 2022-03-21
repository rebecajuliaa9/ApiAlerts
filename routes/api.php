<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\UserController;

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


//para criar um alerta o usuario deve estar logado
Route::apiResource('/alerts',   AlertController::class)->middleware('auth:sanctum');


//grupo de rotas com o prefix auth 
Route::prefix('auth')->group(function(){
    Route::post('/login',            [UserController::class,'login']);
    //para a rota de logout preciso de um usuario logado
    Route::post('/logout',           [UserController::class,'logout'])->middleware('auth:sanctum');
    Route::post('/create',           [UserController::class, 'store']);
});

