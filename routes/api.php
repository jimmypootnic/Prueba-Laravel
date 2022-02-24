<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TwContactosCorporativosController;
use App\Http\Controllers\TwContratosCorporativosController;
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
