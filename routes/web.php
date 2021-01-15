<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/main', function () {
    return view('contenido/contenido');
})->name('main');


//Rutas del controlador Carrera
Route::get('/carrera', 'CarreraController@index');
Route::post('/carrera/registrar', 'CarreraController@registrar');
Route::put('/carrera/actualizar', 'CarreraController@actualizar');
Route::put('/carrera/desactivar_matutino', 'CarreraController@desactivar_matutino');
Route::put('/carrera/activar_matutino', 'CarreraController@activar_matutino');
Route::put('/carrera/desactivar_vespertino', 'CarreraController@desactivar_vespertino');
Route::put('/carrera/activar_vespertino', 'CarreraController@activar_vespertino');
Route::put('/carrera/desactivar_nocturno', 'CarreraController@desactivar_nocturno');
Route::put('/carrera/activar_nocturno', 'CarreraController@activar_nocturno');
Route::put('/carrera/desactivar_turno_mixto', 'CarreraController@desactivar_turno_mixto');
Route::put('/carrera/activar_turno_mixto', 'CarreraController@activar_turno_mixto');
Route::get('/carrera/selectCarrera', 'CarreraController@selectCarrera');

//Rutas del Controlador Roles
Route::get('/rol', 'RolController@index');
Route::get('/rol/selectRol', 'RolController@selectRol');

//Rutas del controlador Users
Route::get('/user', 'UserController@index');
Route::post('/user/registrar', 'UserController@registrar');
Route::put('/user/actualizar', 'UserController@actualizar');
Route::put('/user/desactivar', 'UserController@desactivar');
Route::put('/user/activar', 'UserController@activar');

//Rutas del controlador Matriculas
Route::get('/matricula', 'MatriculaController@index');
Route::post('/matricula/registrar', 'MatriculaController@registrar');
Route::put('/matricula/actualizar', 'MatriculaController@actualizar');
Route::delete('/matricula/eliminar', 'MatriculaController@eliminar');
Route::put('/matricula/desactivar', 'MatriculaController@desactivar');
Route::put('/matricula/activar', 'MatriculaController@activar');

//Rutas del controlador Alumnos
Route::get('/alumno', 'AlumnoController@index');
Route::post('/alumno/loginApp', 'AlumnoController@loginApp');
Route::post('/alumno/registrar', 'AlumnoController@registrar');
Route::put('/alumno/actualizar', 'AlumnoController@actualizar');
Route::delete('/alumno/eliminar', 'AlumnoController@eliminar');
Route::get('/alumno/listarTurnos', 'AlumnoController@listarTurnos');
Route::get('/alumno/confirmar_matricula', 'AlumnoController@confirmarMatricula');

//Rutas del controlador Avisos
Route::get('/aviso', 'AvisoController@index');
Route::post('/aviso/guardar_aviso', 'AvisoController@guardar_aviso');
Route::post('/aviso/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
Route::post('/aviso/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');

// Auth::routes();
//Acceso al sistema
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Route::get('/home', 'HomeController@index')->name('home');
