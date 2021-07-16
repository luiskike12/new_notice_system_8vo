<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    
    public function index(Request $request){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $id_usuario = Auth::user()->id;
        
        //Datos del usuario a mostrar en el dashboard
        $datosUsuario = User::join('carreras', 'users.id_carrera', '=', 'carreras.id')
        ->join('roles', 'users.id_rol', '=', 'roles.id')
        ->select('roles.nombre as nombre_rol','users.usuario', 'users.email', 'users.name as nombre', 
        'users.avatar', 'carreras.nombre as nombre_carrera',
        DB::raw('CASE carreras.tipo_modalidad
        WHEN 1 THEN "Escolarizado"
        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
        DB::raw('CASE carreras.tipo_plan 
        when 6 then "S"
        when 4 then "C" end as tipo_plan'))
        ->where('users.id', '=', $id_usuario)->get();
        
        $out->writeln("Perfil: ".$datosUsuario);
        return ['datosUsuario' => $datosUsuario];
    }

    public function rolUsuario(Request $request){

        $rol = Auth::user()->id_rol;

        return ['rolUsuario'=>$rol];
    }

    public function guardarImagen(Request $request){

        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;

            $ruta_avatar = '';

            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);

            if($request->hasFile('avatar')){
                if(strcmp($request->avatar, 'img/avatars/avatar.png')===0){
                    $ruta_avatar = 'img/avatars/avatar.png';
                }else{
                    if(strcmp($user->avatar, $request->avatar)===0){
                        $ruta_avatar = $user->avatar;
                    }else{
                        $url_avatar = 'public/'.$user->avatar;
                        if(strcmp($user->avatar, 'img/avatars/avatar.png')!==0){
                            Storage::delete($url_avatar);
                        }
                        $ruta_avatar = Storage::disk('public')->put('avatars', $request->file('avatar'));
                    }
                }
            }else{
                if($request->avatar===''){
                    $ruta_avatar = 'img/avatars/avatar.png';
                }
            }
            
            $user->avatar = $ruta_avatar;
            $user->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function confirmarIdentidad(Request $request){        
        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;

            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);

            if (Hash::check($request->passwordActual, $user->password)){
                return ['identidad'=>true];
            }

            return ['identidad'=>false];
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function actualizarNombre(Request $request){
        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;
            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);
            $user->name = $request->nombre;
            $user->save();

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function validarUsuario(Request $request){
        try{
            DB::beginTransaction();
            
            $id_usuario = Auth::user()->id;

            $usuario = User::select('id')->where('usuario','=',$request->usuario)->first();
            if($usuario['id'] == $id_usuario){
                $respuestaUsuario = '';
            }else{
                $respuestaUsuario = 'El usuario "'.$request->usuario.'" ya existe';
            }
            
            return ['respuestaUsuario' => $respuestaUsuario];
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function actualizarUsuario(Request $request){
        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;
            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);
            $user->usuario = $request->usuario;
            $user->save();
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function validarEmail(Request $request){
        try{
            DB::beginTransaction();
            
            $id_usuario = Auth::user()->id;

            $email = User::select('id')->where('email','=',$request->email)->first();
            if($email['id'] == $id_usuario){
                $respuestaEmail = '';
            }else{
                $respuestaEmail = 'Este correo ya esta en uso';
            }
            
            return ['respuestaEmail' => $respuestaEmail];
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function actualizarEmail(Request $request){
        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;
            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);
            $user->email = $request->email;
            $user->save();
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function actualizarPassword(Request $request){
        try{
            DB::beginTransaction();

            $id_usuario = Auth::user()->id;
            //para filtrar el id del usuario
            $user = User::findOrFail($id_usuario);
            $user->password = bcrypt($request->nuevoPassword);
            $user->save();
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

}
