<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    //Route::post('logout', 'App\Http\Controllers\AuthController@logout');


    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        Route::post('usuarios', 'App\Http\Controllers\AuthController@usuario');

        /* Servicios Recursos Humanos*/

        Route::get('listPersonal', 'App\Http\Controllers\AuthController@listPersonal');
        //Route::get('listPersonalDet', 'App\Http\Controllers\AuthController@index');
        Route::get('listCargos', 'App\Http\Controllers\AuthController@listCargos');
        Route::get('listReparticion', 'App\Http\Controllers\AuthController@listReparticion');

    });
});


