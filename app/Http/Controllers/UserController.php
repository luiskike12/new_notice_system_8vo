<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {   
        if(!$request->ajax())return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            //se crea un array de todo lo que devuelva el metodo
            $users = User::join('carreras', 'users.id_carrera', '=', 'carreras.id')
            ->join('roles', 'users.id_rol', '=', 'roles.id')
            ->select('users.id', 'users.id_carrera', 'users.id_rol', 'users.usuario', 
            'users.password', 'users.name as nombre', 'users.email as correo', 'users.condicion', 
            'carreras.tipo_modalidad', 'carreras.nombre as nombre_carrera', 'roles.nombre as nombre_rol')
            ->orderBy('users.id', 'desc')->paginate(5);
        }
        else{
            if($criterio=='tipo_modalidad'){
                $users = User::join('carreras', 'users.id_carrera', '=', 'carreras.id')
                ->join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id', 'users.id_carrera', 'users.id_rol', 'users.usuario', 
                'users.password', 'users.name as nombre', 'users.email as correo', 'users.condicion', 
                'carreras.tipo_modalidad', 'carreras.nombre as nombre_carrera', 'roles.nombre as nombre_rol')
                ->where('carreras.'.$criterio, 'like', '%'.$buscar.'%')
                ->orderBy('users.id', 'desc')->paginate(5);
            }else{
                $users = User::join('carreras', 'users.id_carrera', '=', 'carreras.id')
                ->join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id', 'users.id_carrera', 'users.id_rol', 'users.usuario', 
                'users.password', 'users.name as nombre', 'users.email as correo', 'users.condicion', 
                'carreras.tipo_modalidad', 'carreras.nombre as nombre_carrera', 'roles.nombre as nombre_rol')
                ->where('users.'.$criterio, 'like', '%'.$buscar.'%')
                ->orderBy('users.id', 'desc')->paginate(5);
            }
        }
        
        return[
            'pagination' => [
                'total'         => $users->total(),
                'current_page'  => $users->currentPage(),
                'per_page'      => $users->perPage(),
                'last_page'     => $users->lastPage(),
                'from'          => $users->firstItem(),
                'to'            => $users->lastItem(),
            ],
            'users' => $users
        ];
    }

    public function registrar(Request $request)
    {
        try{
            DB::beginTransaction();

            $user = new User();
            $user->id_carrera = $request->id_carrera;
            $user->id_rol = $request->id_rol;
            $user->name = $request->nombre;
            $user->email = $request->correo;
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->avatar = 'img/avatars/avatar.png';
            $user->condicion = '1';
            $user->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

    }

    public function actualizar(Request $request)
    {
        try{
            DB::beginTransaction();

            //para filtrar el id del usuario
            $user = User::findOrFail($request->id);
            $user->id_carrera = $request->id_carrera;
            $user->id_rol = $request->id_rol;
            $user->name = $request->nombre;
            $user->email = $request->correo;
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function verificarUsuarioEmail_guardar(Request $request){
        
        try{
            DB::beginTransaction();

            $respuestaUsuario = '';
            $respuestaEmail = '';
            
            $usuario = User::where('usuario','=',$request->usuario)->first();
            if($usuario === null){
                $respuestaUsuario = '';
            }else{
                $respuestaUsuario = 'El usuario "'.$request->usuario.'" ya existe';
            }

            $email = User::where('email','=',$request->email)->first();
            if($email === null){
                $respuestaEmail = '';
            }else{
                $respuestaEmail = 'Este correo ya esta en uso';
            }

            return ['respuestaUsuario' => $respuestaUsuario,'respuestaEmail' => $respuestaEmail];

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function verificarUsuarioEmail_actualizar(Request $request){

        try{
            DB::beginTransaction();

            $respuestaUsuario = '';
            $respuestaEmail = '';
            
            $usuario = User::select('id')->where('usuario','=',$request->usuario)->first();

            if($usuario['id'] == $request->id_usuario){
                $respuestaUsuario = '';
            }else{
                $respuestaUsuario = 'El usuario "'.$request->usuario.'" ya existe';
            }

            $email = User::select('id')->where('email','=',$request->email)->first();
 
            if($email['id'] == $request->id_usuario){
                $respuestaEmail = '';
            }else{
                $respuestaEmail = 'Este correo ya esta en uso';
            }

            return ['respuestaUsuario' => $respuestaUsuario,'respuestaEmail' => $respuestaEmail];

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }


    public function activar(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }

}
