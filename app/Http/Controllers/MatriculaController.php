<?php

namespace App\Http\Controllers;

use Exception;
use App\Alumno;
use App\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $rol = Auth::user()->id_rol;
        $carrera_usuario = Auth::user()->id_carrera;

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        //Rol Administrador
        if($rol == 1){
            if($buscar==''){
                //se crea un array de todo lo que devuelva el metodo
                $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                DB::raw('CASE carreras.tipo_modalidad 
                WHEN 1 THEN "Escolarizado" 
                WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                ->orderBy('matriculas.id', 'desc')->paginate(5);
            }
            else{
                if($criterio=='tipo_modalidad'){
                    $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                    ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad 
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                    'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                    ->where('carreras.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('matriculas.id', 'desc')->paginate(5);
                }else{
                    $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                    ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad 
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                    'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                    ->where('matriculas.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('matriculas.id', 'desc')->paginate(5);
                }   
            }
        }

        //Rol Coordinador y Asistente
        if($rol == 2 || $rol == 3){
            if($buscar==''){
                //se crea un array de todo lo que devuelva el metodo
                $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                DB::raw('CASE carreras.tipo_modalidad 
                WHEN 1 THEN "Escolarizado" 
                WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                ->where('matriculas.id_carrera','=',$carrera_usuario)
                ->orderBy('matriculas.id', 'desc')->paginate(5);
            }
            else{
                if($criterio=='tipo_modalidad'){
                    $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                    ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad 
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                    'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                    ->where('matriculas.id_carrera','=',$carrera_usuario)
                    ->where('carreras.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('matriculas.id', 'desc')->paginate(5);
                }else{
                    $matriculas = Matricula::join('carreras','carreras.id','=','matriculas.id_carrera')
                    ->select('matriculas.id','matriculas.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad 
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
                    'matriculas.switch','matriculas.matricula','matriculas.nombre','matriculas.condicion')
                    ->where('matriculas.id_carrera','=',$carrera_usuario)
                    ->where('matriculas.'.$criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('matriculas.id', 'desc')->paginate(5);
                }   
            }
        }

        return[
            'pagination' => [
                'total'         => $matriculas->total(),
                'current_page'  => $matriculas->currentPage(),
                'per_page'      => $matriculas->perPage(),
                'last_page'     => $matriculas->lastPage(),
                'from'          => $matriculas->firstItem(),
                'to'            => $matriculas->lastItem(),
            ],
            'matriculas' => $matriculas
        ];
    }

    public function registrar(Request $request)
    {
        try{
            DB::beginTransaction();

            $matricula = new Matricula();
            $matricula->id_carrera = $request->id_carrera;
            // $matricula->num_lista = $request->num_lista;
            $matricula->matricula = $request->matricula;
            $matricula->nombre = $request->nombre;
            $matricula->condicion = '0';
            $matricula->save();

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
            $matricula = Matricula::findOrFail($request->id);
            $matricula->id_carrera = $request->id_carrera;
            // $matricula->num_lista = $request->num_lista;
            $matricula->matricula = $request->matricula;
            $matricula->nombre = $request->nombre;
            $matricula->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        $id = $request->id;
        $matricula = Matricula::findOrFail($request->id);
        $matricula->switch = '0';
        $matricula->save();        

        $existe = DB::table('alumnos')
        ->where('id_matricula', '=', $id)
        ->update(['condicion' => 0]);

    }

    public function activar(Request $request)
    {
        $id = $request->id;
        $matricula = Matricula::findOrFail($request->id);
        $matricula->switch = '1';
        $matricula->save();

        $existe = DB::table('alumnos')
        ->where('id_matricula', '=', $id)
        ->update(['condicion' => 1]);

    }

    public function eliminar(Request $request){

        try{
            DB::beginTransaction();

            $matricula = $request->id;

            $datos_eliminados = Matricula::find($matricula);
            $datos_eliminados->delete();
            
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

    }

}
