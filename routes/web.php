<?php

use Illuminate\Support\Facades\Auth;
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

/*
    Rutas de la clase Auth en caso de necesitarse
--------------------------------------------------------------------
    Auth::routes(); => (vendor/laravel/ui/src/AuthRouteMethods.php)
---------------------------------------------------------------------
*/

//Rutas cuando no esta autenticado
Route::group(['middleware' => ['guest']], function(){
    //Se muestra cuando solo se es invitado 
    Route::get('/', 'Auth\LoginController@showLoginForm');
    
    // Auth::routes();
    //Acceso al sistema
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    //Restablecer contraseña
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    //Confirmar contraseña
    Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

    //Verificar Email
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});


//Rutas cuando esta autenticado
Route::group(['middleware' => ['auth']], function(){
//Grupo de roles con su grupo de rutas a las que puede acceder al estar autenticado

    //Cerrar sesión cualquier rol de usuario
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    
    //ver el contenido dependiendo su rol
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');
    
    //Rutas que puede usar el rol Administrador
    Route::group(['middleware' => ['Administrador']], function(){
        
        //Ruta del Dashboard de graficos y tarjeta de datos del usuario
        Route::get('/dashboard', 'DashboardController');
        
        //Rutas del controlador Users
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@registrar');
        Route::put('/user/actualizar', 'UserController@actualizar');
        Route::get('/user/verificarUsuarioEmail_guardar', 'UserController@verificarUsuarioEmail_guardar');
        Route::get('/user/verificarUsuarioEmail_actualizar', 'UserController@verificarUsuarioEmail_actualizar');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        //Rutas del Controlador Roles
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //Rutas del controlador Alumnos
        Route::get('/alumno', 'AlumnoController@index');
        Route::post('/alumno/loginApp', 'AlumnoController@loginApp');
        Route::post('/alumno/registrar', 'AlumnoController@registrar');
        Route::put('/alumno/actualizar', 'AlumnoController@actualizar');
        Route::delete('/alumno/eliminar', 'AlumnoController@eliminar');
        Route::get('/alumno/listarTurnos', 'AlumnoController@listarTurnos');
        Route::get('/alumno/confirmar_matricula', 'AlumnoController@confirmarMatricula');
        
        //Rutas del controlador Matriculas
        Route::get('/matricula', 'MatriculaController@index');
        Route::post('/matricula/registrar', 'MatriculaController@registrar');
        Route::put('/matricula/actualizar', 'MatriculaController@actualizar');
        Route::delete('/matricula/eliminar', 'MatriculaController@eliminar');
        Route::put('/matricula/desactivar', 'MatriculaController@desactivar');
        Route::put('/matricula/activar', 'MatriculaController@activar');

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

        //Rutas del controlador Avisos
        Route::get('/aviso', 'AvisoController@index');
        Route::post('/aviso/guardar_aviso', 'AvisoController@guardar_aviso');
        Route::post('/aviso/guardar_y_enviar_aviso', 'AvisoController@guardar_y_enviar_aviso');
        Route::put('/aviso/reenviar_aviso', 'AvisoController@reenviar_aviso');
        Route::post('/aviso/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
        Route::post('/aviso/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');
        Route::post('/aviso/actualizar_aviso', 'AvisoController@actualizar_aviso');
        Route::delete('/aviso/eliminar_aviso', 'AvisoController@eliminar_aviso');

        //Rutas del controlador Perfil del usuario
        Route::get('/perfil', 'PerfilController@index');
        Route::post('/perfil/guardarImagen', 'PerfilController@guardarImagen');
        Route::get('/perfil/confirmarIdentidad', 'PerfilController@confirmarIdentidad');
        Route::put('/perfil/actualizarNombre', 'PerfilController@actualizarNombre');
        Route::get('/perfil/validarUsuario', 'PerfilController@validarUsuario');
        Route::put('/perfil/actualizarUsuario', 'PerfilController@actualizarUsuario');
        Route::get('/perfil/validarEmail', 'PerfilController@validarEmail');
        Route::put('/perfil/actualizarEmail', 'PerfilController@actualizarEmail');
        Route::put('/perfil/actualizarPassword', 'PerfilController@actualizarPassword');
    });


    //Rutas que puede usar el rol Coordinador
    Route::group(['middleware' => ['Coordinador']], function(){
        
        //Ruta del Dashboard de graficos y tarjeta de datos del usuario
        Route::get('/dashboard', 'DashboardController');
        
        //Rutas del controlador Users
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@registrar');
        Route::put('/user/actualizar', 'UserController@actualizar');
        Route::get('/user/verificarUsuarioEmail_guardar', 'UserController@verificarUsuarioEmail_guardar');
        Route::get('/user/verificarUsuarioEmail_actualizar', 'UserController@verificarUsuarioEmail_actualizar');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        //Rutas del Controlador Roles
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //Rutas del controlador Alumnos
        Route::get('/alumno', 'AlumnoController@index');
        Route::post('/alumno/loginApp', 'AlumnoController@loginApp');
        Route::post('/alumno/registrar', 'AlumnoController@registrar');
        Route::put('/alumno/actualizar', 'AlumnoController@actualizar');
        Route::delete('/alumno/eliminar', 'AlumnoController@eliminar');
        Route::get('/alumno/listarTurnos', 'AlumnoController@listarTurnos');
        Route::get('/alumno/confirmar_matricula', 'AlumnoController@confirmarMatricula');

        //Rutas del controlador Matriculas
        Route::get('/matricula', 'MatriculaController@index');
        Route::post('/matricula/registrar', 'MatriculaController@registrar');
        Route::put('/matricula/actualizar', 'MatriculaController@actualizar');
        Route::delete('/matricula/eliminar', 'MatriculaController@eliminar');
        Route::put('/matricula/desactivar', 'MatriculaController@desactivar');
        Route::put('/matricula/activar', 'MatriculaController@activar');
        
        //Rutas del controlador Avisos
        Route::get('/aviso', 'AvisoController@index');
        Route::post('/aviso/guardar_aviso', 'AvisoController@guardar_aviso');
        Route::post('/aviso/guardar_y_enviar_aviso', 'AvisoController@guardar_y_enviar_aviso');
        Route::put('/aviso/reenviar_aviso', 'AvisoController@reenviar_aviso');
        Route::post('/aviso/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
        Route::post('/aviso/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');
        Route::post('/aviso/actualizar_aviso', 'AvisoController@actualizar_aviso');
        Route::delete('/aviso/eliminar_aviso', 'AvisoController@eliminar_aviso');

        //Rutas del controlador Perfil del usuario
        Route::get('/perfil', 'PerfilController@index');
        Route::post('/perfil/guardarImagen', 'PerfilController@guardarImagen');
        Route::get('/perfil/confirmarIdentidad', 'PerfilController@confirmarIdentidad');
        Route::put('/perfil/actualizarNombre', 'PerfilController@actualizarNombre');
        Route::get('/perfil/validarUsuario', 'PerfilController@validarUsuario');
        Route::put('/perfil/actualizarUsuario', 'PerfilController@actualizarUsuario');
        Route::get('/perfil/validarEmail', 'PerfilController@validarEmail');
        Route::put('/perfil/actualizarEmail', 'PerfilController@actualizarEmail');
        Route::put('/perfil/actualizarPassword', 'PerfilController@actualizarPassword');
    });


    //Rutas que puede usar el rol Asistente
    Route::group(['middleware' => ['Asistente']], function(){
        
        //Ruta del Dashboard de graficos y tarjeta de datos del usuario
        Route::get('/dashboard', 'DashboardController');
        
        //Rutas del controlador Alumnos
        Route::get('/alumno', 'AlumnoController@index');
        Route::post('/alumno/loginApp', 'AlumnoController@loginApp');
        Route::post('/alumno/registrar', 'AlumnoController@registrar');
        Route::put('/alumno/actualizar', 'AlumnoController@actualizar');
        Route::delete('/alumno/eliminar', 'AlumnoController@eliminar');
        Route::get('/alumno/listarTurnos', 'AlumnoController@listarTurnos');
        Route::get('/alumno/confirmar_matricula', 'AlumnoController@confirmarMatricula');
        
        //Rutas del controlador Matriculas
        Route::get('/matricula', 'MatriculaController@index');
        Route::post('/matricula/registrar', 'MatriculaController@registrar');
        Route::put('/matricula/actualizar', 'MatriculaController@actualizar');
        Route::delete('/matricula/eliminar', 'MatriculaController@eliminar');
        Route::put('/matricula/desactivar', 'MatriculaController@desactivar');
        Route::put('/matricula/activar', 'MatriculaController@activar');
        
        //Rutas del controlador Avisos
        Route::get('/aviso', 'AvisoController@index');
        Route::post('/aviso/guardar_aviso', 'AvisoController@guardar_aviso');
        Route::post('/aviso/guardar_y_enviar_aviso', 'AvisoController@guardar_y_enviar_aviso');
        Route::put('/aviso/reenviar_aviso', 'AvisoController@reenviar_aviso');
        Route::post('/aviso/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
        Route::post('/aviso/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');
        Route::post('/aviso/actualizar_aviso', 'AvisoController@actualizar_aviso');
        Route::delete('/aviso/eliminar_aviso', 'AvisoController@eliminar_aviso');
        
        //Rutas del controlador Perfil del usuario
        Route::get('/perfil', 'PerfilController@index');
        Route::post('/perfil/guardarImagen', 'PerfilController@guardarImagen');
        Route::get('/perfil/confirmarIdentidad', 'PerfilController@confirmarIdentidad');
        Route::put('/perfil/actualizarNombre', 'PerfilController@actualizarNombre');
        Route::get('/perfil/validarUsuario', 'PerfilController@validarUsuario');
        Route::put('/perfil/actualizarUsuario', 'PerfilController@actualizarUsuario');
        Route::get('/perfil/validarEmail', 'PerfilController@validarEmail');
        Route::put('/perfil/actualizarEmail', 'PerfilController@actualizarEmail');
        Route::put('/perfil/actualizarPassword', 'PerfilController@actualizarPassword');
    });


    //Rutas que puede usar el rol Docente
    Route::group(['middleware' => ['Docente']], function(){
        
        //Ruta del Dashboard de graficos y tarjeta de datos del usuario
        Route::get('/dashboard', 'DashboardController');
        
        //Ruta controlador Carrera
        Route::get('/carrera/selectCarrera', 'CarreraController@selectCarrera');

        //Rutas del controlador Alumnos (solo puede ver los alumnos registrados)
        Route::get('/alumno', 'AlumnoController@index');
        
        //Rutas del controlador Avisos
        Route::get('/aviso', 'AvisoController@index');
        Route::post('/aviso/guardar_aviso', 'AvisoController@guardar_aviso');
        Route::post('/aviso/guardar_y_enviar_aviso', 'AvisoController@guardar_y_enviar_aviso');
        Route::put('/aviso/reenviar_aviso', 'AvisoController@reenviar_aviso');
        Route::post('/aviso/TraerAvisosAlumnos', 'AvisoController@traerAvisosAlumnos');
        Route::post('/aviso/TraerAvisosAlumnosFiltros', 'AvisoController@traerAvisosAlumnosFiltros');
        Route::post('/aviso/actualizar_aviso', 'AvisoController@actualizar_aviso');
        Route::delete('/aviso/eliminar_aviso', 'AvisoController@eliminar_aviso');
        
        //Rutas del controlador Perfil del usuario
        Route::get('/perfil', 'PerfilController@index');
        Route::post('/perfil/guardarImagen', 'PerfilController@guardarImagen');
        Route::get('/perfil/confirmarIdentidad', 'PerfilController@confirmarIdentidad');
        Route::put('/perfil/actualizarNombre', 'PerfilController@actualizarNombre');
        Route::get('/perfil/validarUsuario', 'PerfilController@validarUsuario');
        Route::put('/perfil/actualizarUsuario', 'PerfilController@actualizarUsuario');
        Route::get('/perfil/validarEmail', 'PerfilController@validarEmail');
        Route::put('/perfil/actualizarEmail', 'PerfilController@actualizarEmail');
        Route::put('/perfil/actualizarPassword', 'PerfilController@actualizarPassword');
    });

});


// Route::get('/home', 'HomeController@index')->name('home');
