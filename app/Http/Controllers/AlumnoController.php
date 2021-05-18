<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Alumno;
use App\Matricula;
use Illuminate\Support\Facades\Hash;

class AlumnoController extends Controller
{
    public function loginApp(Request $request)
    {
        try{
            $alumno = DB::select('SELECT * FROM alumnos WHERE correo = :a_correo',['a_correo'=>$request->correo]);
            
            // if dont exist
            if(count($alumno) == 0){
                return [
                    'resp' => false,
                    'msg' => 'Correo no registrado'
                ];
            }
            // password validation
            if(Hash::check($request->password, $alumno[0]->password)){
                $matricula = DB::select('SELECT * FROM matriculas WHERE id = :a_id_matricula',['a_id_matricula'=>$alumno[0]->id_matricula]);
                $carrera = DB::select('SELECT * FROM carreras WHERE id = :a_id_carrera',['a_id_carrera'=>$matricula[0]->id_carrera]);
                return [
                    'resp' => true,
                    'data' => [
                        'alumno' => [
                            'correo' => $alumno[0]->correo,
                            'grado' => $alumno[0]->grado,
                            'turno' => $alumno[0]->turno
                        ],
                        'matricula' => [
                            'id' => $matricula[0]->id,
                            'matricula' => $matricula[0]->matricula,
                            'nombre' => $matricula[0]->nombre
                        ],
                        'carrera' => $carrera[0]
                    ]
                ];
            } else {
                return [
                    'resp' => false,
                    'msg' => 'Contraseña incorrecta'
                ];
            }
        } catch (Exception $e){
            DB::rollBack();
        }
    }

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
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $esVacio = $request->password;
        try{
            DB::beginTransaction();
            
            $alumno = Alumno::findOrFail($request->id_matricula);
            
            if($request->device == true){
                if(is_null($request->id_dispositivo)){
                    $alumno->id_dispositivo = null;
                } else {
                    $alumno->id_dispositivo = $request->id_dispositivo;
                }
            } else {
                if($esVacio!=''){
                    $alumno->password = bcrypt($request->password);
                }
                $alumno->correo = $request->correo;
                $alumno->grado = $request->grado;
                $alumno->turno = $request->turno;
            }
            $alumno->save();

            DB::commit();
        }catch (Exception $e){
            $out->writeln("-------------- DOUH!! --------------");
            $out->writeln($e);
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
        $alumno = DB::select('SELECT m.id, m.nombre AS nombre_alumno,
        c.turno_matutino, c.turno_vespertino, c.turno_nocturno, c.turno_mixto, c.num_grados, c.nombre
        FROM matriculas m INNER JOIN carreras c ON m.id_carrera = c.id
        WHERE m.matricula = :matricula_alumno AND m.switch = :activo AND m.condicion = :NoRegistrado',
        ['matricula_alumno'=>$matricula, 'activo'=>1,'NoRegistrado'=>0]);
        
        return ['elementos_alumno'=>$alumno];
    }

    public function eliminar(Request $request){
        try{
            DB::beginTransaction();

            $id_matricula = $request->id_alumno;

            DB::table('alumnos')
            ->where('id_matricula', '=', $id_matricula)
            ->delete();

            $se_cumplio = DB::table('matriculas')
            ->where('id', '=', $id_matricula)
            ->update(['condicion' => 0]);

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
    }

}
