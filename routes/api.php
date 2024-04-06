<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteItalianoController;
use App\Http\Controllers\flujo1Controller;
use App\Http\Controllers\flujo2Controller;
use App\Http\Controllers\flujo3Controller;
use App\Http\Controllers\formalizarMatrimonio12Controller;
use App\Http\Controllers\formasPagosController;
use App\Http\Controllers\llegadaDocs11Controller;
use App\Http\Controllers\MatrimonioController;
use App\Http\Controllers\observacionesController;
use App\Http\Controllers\prepararDocs21Controller;
use App\Http\Controllers\prepararDocs31Controller;
use App\Http\Controllers\retirarDocs13Controller;
use App\Http\Controllers\traduccion14Controller;
use App\Models\formalizar_Matrim12;
use App\Models\Matrimonio;
use App\Models\preparar_Doc21;
use App\Models\preparar_Docs31;
use App\Models\retirar_Doc13;
use App\Models\traduccion14;

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
Route::prefix('auth')->group(function () {
    Route::post('login',[AuthController::class, 'login']);
    Route::post('register',[AuthController::class, 'register']);
    Route::get('getClient',[ClienteController::class, 'getCliente']);
    Route::get('getAllClient',[ClienteController::class, 'getAllCliente']);

});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('update',[AuthController::class, 'updatePassword']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::get('getUser',[AuthController::class, 'getUser']);

    // Clientes
    Route::post('createClient',[ClienteController::class, 'create']);
    Route::get('getClient',[ClienteController::class, 'getCliente']);
    Route::get('getClientByID',[ClienteController::class, 'getClienteById']);
    Route::delete('deleteClient',[ClienteController::class, 'destroy']);
    Route::put('modificarClient',[ClienteController::class, 'modificar']);
    Route::get('getClient',[ClienteController::class, 'getCliente']);
    Route::get('getAllClient',[ClienteController::class, 'getAllCliente']);

    // Clientes italianos
    Route::post('createClientItalian',[ClienteItalianoController::class, 'create']);
    Route::put('modificarClientItalian',[ClienteItalianoController::class, 'modificar']);
    Route::get('getClientItalian',[ClienteItalianoController::class, 'getClienteItaliano']);
    Route::get('getClientItalianById',[ClienteItalianoController::class, 'getClienteItalianoById']);
    // Route::delete('deleteClientItalian',[ClienteItalianoController::class, 'destroy']);

    // Matrimonio
    Route::post('createMatrimonio',[MatrimonioController::class, 'create']);
    Route::get('getMatrimonio',[MatrimonioController::class, 'getMatrimonio']);
    Route::delete('deleteMatrimonio',[MatrimonioController::class, 'destroy']);
    Route::put('modificarMatrimonio',[MatrimonioController::class, 'modificar']);

    // formas de pago
    Route::get('getFormaPago',[formasPagosController::class, 'getFormaPago']);




    // flujo1(Primer paso)
    Route::get('getFlujo1',[flujo1Controller::class, 'getFlujo1']);



     // flujo2(segundo paso)
     Route::get('getFlujo2',[flujo2Controller::class, 'getFlujo2']);



     // flujo3(tercer paso)
     Route::get('getFlujo3',[flujo3Controller::class, 'getFlujo3']);



    //  formalizar matrimonio
    Route::get('getformalizar12',[formalizarMatrimonio12Controller::class, 'getFormalizar']);


    // llegada de documentos correspondiente al paso 1 del flujo 1
    Route::get('getllegadaDeDocs11',[llegadaDocs11Controller::class, 'getllegadaDoc']);

    // preparar documentos correspondiente al paso 1 del flujo 2
    Route::get('getPrepararDoc21',[prepararDocs21Controller::class, 'getPreparar']);


    // preparar documentos correspondiente al paso 1 del flujo 3
    Route::get('getPrepararDoc31',[prepararDocs31Controller::class, 'getPreparar']);


    //retirar documentos correspondiente al paso 3 del flujo 1
    Route::get('getRetirar13',[retirarDocs13Controller::class, 'getRetirar']);


    // traduccion del paso 4 del flujo 1
    Route::get('getTraduccion',[traduccion14Controller::class, 'getTraduccion']);


    // observaciones
    Route::get('getObservaciones',[observacionesController::class, 'getObservaciones']);

});



