<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BairrosController;
use App\Http\Controllers\CidadesController;
use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\EstadosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post("login", "login");
});

Route::controller(AuthController::class)->middleware("auth:sanctum")->group(function(){
    Route::post("logout", "logout");
});

//Rotas referente ao cadastro de bairros
Route::prefix('bairros')->middleware("auth:sanctum")->group(function () {
    Route::get('/', [BairrosController::class, 'index']);
    Route::get('/{id}', [BairrosController::class, 'show']);
    Route::post('/', [BairrosController::class, 'create']);
    Route::put('/{id}', [BairrosController::class, 'update']);
    Route::delete('/{id}', [BairrosController::class, 'destroy']);
});

//Rotas referente ao cadastro de cidades
Route::prefix('cidades')->middleware("auth:sanctum")->group(function () {
    Route::get('/', [CidadesController::class, 'index']);
    Route::get('/{id}', [CidadesController::class, 'show']);
    Route::post('/', [CidadesController::class, 'create']);
    Route::put('/{id}', [CidadesController::class, 'update']);
    Route::delete('/{id}', [CidadesController::class, 'destroy']);
});

//Rotas referente ao cadastro de estados(UF)
Route::prefix('estados')->middleware("auth:sanctum")->group(function () {
    Route::get('/', [EstadosController::class, 'index']);
    Route::get('/{id}', [EstadosController::class, 'show']);
    Route::post('/', [EstadosController::class, 'create']);
    Route::put('/{id}', [EstadosController::class, 'update']);
    Route::delete('/{id}', [EstadosController::class, 'destroy']);
});

//Rotas referente ao cadastro de enderecos com o respecito CEP
Route::prefix('enderecos')->middleware("auth:sanctum")->group(function () {
    Route::get('/', [EnderecosController::class, 'index']);
    Route::get('/{id}', [EnderecosController::class, 'show']);
    Route::post('/', [EnderecosController::class, 'create']);
    Route::put('/{id}', [EnderecosController::class, 'update']);
    Route::delete('/{id}', [EnderecosController::class, 'destroy']);
    Route::get('/buscaPorCep/{cep}', [EnderecosController::class, 'buscaPorCep']);
    Route::post('/buscaPorEndereco', [EnderecosController::class, 'buscaPorEndereco']);
    
});