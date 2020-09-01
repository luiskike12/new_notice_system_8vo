<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Alumno;
use App\Matricula;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax())return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            //se crea un array de todo lo que devuelva el metodo
            $alumnos = Alumno::join('matriculas','matriculas.id','=','alumnos.id_matricula')
            ->join('carreras','carreras.id','=','matriculas.id_carrera')
            ->select('alumnos.id_matricula','alumnos.password','carreras.nombre as nombre_carrera',
            DB::raw('CASE carreras.tipo_modalidad WHEN 1 THEN "Escolarizado" WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
            'matriculas.matricula as matricula_alumno',
            'matriculas.nombre as nombre_alumno','alumnos.correo','alumnos.grado',
            'alumnos.turno','alumnos.condicion')
            ->orderBy('matriculas.id', 'desc')->paginate(3);

        }
        else{
            $alumnos = Alumno::join('matriculas','matriculas.id','=','alumnos.id_matricula')
            ->join('carreras','carreras.id','=','matriculas.id_carrera')
            ->select('alumnos.id_matricula','alumnos.password','carreras.nombre as nombre_carrera',
            DB::raw('CASE carreras.tipo_modalidad WHEN 1 THEN "Escolarizado" WHEN 2 THEN "Semiescolarizado" END AS modalidad_carrera'),
            'matriculas.matricula as matricula_alumno',
            'matriculas.nombre as nombre_alumno','alumnos.correo','alumnos.grado',
            'alumnos.turno','alumnos.condicion')
            ->where('alumnos.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('matriculas.id', 'desc')->paginate(3);
        }
        
        return[
            'pagination' => [
                'total'         => $alumnos->total(),
                'current_page'  => $alumnos->currentPage(),
                'per_page'      => $alumnos->perPage(),
                'last_page'     => $alumnos->lastPage(),
                'from'          => $alumnos->firstItem(),
                'to'            => $alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
    }

    public function registrar(Request $request)
    {
        try{
            DB::beginTransaction();

            $alumno = new Alumno();
            $alumno->id_matricula = $request->id_matricula;
            $alumno->password = bcrypt($request->password);
            $alumno->correo = $request->correo;
            $alumno->grado = $request->grado;
            $alumno->turno = $request->turno;
            $alumno->save();

            $existe = DB::table('matriculas')
            ->where('id', '=', $request->id_matricula)
            ->update(['condicion' => 1]);

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

    }

    public function actualizar(Request $request)
    {
        $esVacio = $request->password;   
        try{
            DB::beginTransaction();
            
            $alumno = Alumno::findOrFail($request->id_matricula);
            if($esVacio!=''){
                $alumno->password = bcrypt($request->password);
            }
            $alumno->correo = $request->correo;
            $alumno->grado = $request->grado;
            $alumno->turno = $request->turno;
            $alumno->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

    public function listarTurnos(Request $request){        
        $id_alumno = $request->id_alumno;
        $turnos = DB::select('SELECT c.turno_matutino, c.turno_vespertino, c.turno_nocturno, c.turno_mixto
        FROM alumnos a INNER JOIN (matriculas m INNER JOIN carreras c ON m.id_carrera = c.id) 
        ON a.id_matricula = m.id WHERE a.id_matricula = :id_alumno',['id_alumno'=>$id_alumno]);

        return ['turnos'=>$turnos];
    }

    public function confirmarMatricula(Request $request){      
        $matricula = $request->matricula;
        $alumno = DB::select('SELECT m.id, c.turno_matutino, c.turno_vespertino, c.turno_nocturno, c.turno_mixto
        FROM matriculas m INNER JOIN carreras c ON m.id_carrera = c.id
        WHERE m.matricula = :matricula_alumno AND m.switch = :activo AND m.condicion = :NoRegistrado',
        ['matricula_alumno'=>$matricula, 'activo'=>1,'NoRegistrado'=>0]);

        return ['elementos_alumno'=>$alumno];
    }

}
