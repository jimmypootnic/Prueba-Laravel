<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TwContactosCorporativosController;
use App\Http\Controllers\TwContratosCorporativosController;
use App\Http\Controllers\TwCorporativosController;
use App\Http\Controllers\TwDocumentosController;
use App\Http\Controllers\TwDocumentosCorporativosController;
use App\Http\Controllers\TwEmpresasCorporativosController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/
/*
 Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'users', 'middleware' => [Cors::class]], function () {
    Route::post('registro', [UserController::class,'register'] );
    Route::post('login', [UserController::class,'login'] );
    Route::post('resetPassword', [ForgotPasswordController::class,'forgot']);
});

Route::group(['prefix' => 'users', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::post('logout', [UserController::class,'logout'] );
    Route::put('/{id}', [UserController::class,'update'] );
    Route::get('user', [UserController::class,'userInfo'] );
});

Route::group(['prefix' => 'TwContactosCorporativos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwContactosCorporativosController::class,'getAll'] );
    Route::get('/{id}', [TwContactosCorporativosController::class,'getById'] );
    Route::post('/', [TwContactosCorporativosController::class,'create'] );
    Route::put('/{id}', [TwContactosCorporativosController::class,'update'] );
    Route::delete('/{id}', [TwContactosCorporativosController::class,'delete'] );
});

Route::group(['prefix' => 'TwContratosCorporativos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwContratosCorporativosController::class,'getAll'] );
    Route::get('/{id}', [TwContratosCorporativosController::class,'getById'] );
    Route::post('/', [TwContratosCorporativosController::class,'create'] );
    Route::put('/{id}', [TwContratosCorporativosController::class,'update'] );
    Route::delete('/{id}', [TwContratosCorporativosController::class,'delete'] );
});

Route::group(['prefix' => 'TwCorporativos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwCorporativosController::class,'getAll'] );
    Route::get('/{id}', [TwCorporativosController::class,'getById'] );
    Route::post('/', [TwCorporativosController::class,'create'] );
    Route::put('/{id}', [TwCorporativosController::class,'update'] );
    Route::delete('/{id}', [TwCorporativosController::class,'delete'] );
});

Route::group(['prefix' => 'TwDocumentos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwDocumentosController::class,'getAll'] );
    Route::get('/{id}', [TwDocumentosController::class,'getById'] );
    Route::post('/', [TwDocumentosController::class,'create'] );
    Route::put('/{id}', [TwDocumentosController::class,'update'] );
    Route::delete('/{id}', [TwDocumentosController::class,'delete'] );
});

Route::group(['prefix' => 'TwDocumentosCorporativos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwDocumentosCorporativosController::class,'getAll'] );
    Route::get('/{id}', [TwDocumentosCorporativosController::class,'getById'] );
    Route::post('/', [TwDocumentosCorporativosController::class,'create'] );
    Route::put('/{id}', [TwDocumentosCorporativosController::class,'update'] );
    Route::delete('/{id}', [TwDocumentosCorporativosController::class,'delete'] );
});

Route::group(['prefix' => 'TwEmpresasCorporativos', 'middleware' => ['auth:api',Cors::class]], function () {
    Route::get('/', [TwEmpresasCorporativosController::class,'getAll'] );
    Route::get('/{id}', [TwEmpresasCorporativosController::class,'getById'] );
    Route::post('/', [TwEmpresasCorporativosController::class,'create'] );
    Route::put('/{id}', [TwEmpresasCorporativosController::class,'update'] );
    Route::delete('/{id}', [TwEmpresasCorporativosController::class,'delete'] );
});



