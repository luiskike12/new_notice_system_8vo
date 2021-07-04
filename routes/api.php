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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/confirmar_matricula', 'AlumnoController@confirmarMatricula');
Route::post('/registrar', 'AlumnoController@registrar');
Route::post('/loginApp', 'AlumnoController@loginApp');
Route::put('/actualizar', 'AlumnoController@actualizar_app');
Route::post('/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
Route::post('/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');
Route::post('//verificarAviso', 'AvisoController@verificarAviso');