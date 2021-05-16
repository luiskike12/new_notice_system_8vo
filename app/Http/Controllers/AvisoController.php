<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Aviso;
use OneSignal;

class AvisoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax())return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
            ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
            DB::raw('CASE avisos.turno 
            WHEN 0 THEN "General"
            WHEN 1 THEN "Matutino"
            WHEN 2 THEN "Vespertino"
            WHEN 3 THEN "Nocturno" 
            WHEN 4 THEN "Mixto" END AS turno'),
            DB::raw('CASE avisos.grado 
            WHEN 0 THEN "General" ELSE avisos.grado END AS grado'),
            'avisos.titulo','avisos.contenido',
            'avisos.documento as url_documento','avisos.general')
            ->orderBy('avisos.id', 'desc')->paginate(3);
        }
        else{
            $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
            ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
            DB::raw('CASE avisos.turno 
            WHEN 0 THEN "General"
            WHEN 1 THEN "Matutino"
            WHEN 2 THEN "Vespertino"
            WHEN 3 THEN "Nocturno" 
            WHEN 4 THEN "Mixto" END AS turno'),
            DB::raw('CASE avisos.grado 
            WHEN 0 THEN "General" ELSE avisos.grado END AS grado'),
            'avisos.titulo','avisos.contenido',
            'avisos.documento as url_documento','avisos.general')
            ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('avisos.id', 'desc')->paginate(3);
        }
        
        return[
            'pagination' => [
                'total'         => $avisos->total(),
                'current_page'  => $avisos->currentPage(),
                'per_page'      => $avisos->perPage(),
                'last_page'     => $avisos->lastPage(),
                'from'          => $avisos->firstItem(),
                'to'            => $avisos->lastItem(),
            ],
            'avisos' => $avisos
        ];
    }

    public function traerAvisosAlumnosFiltros(Request $request)
    {
        try{
            $string1 = 'SELECT a.id_carrera, a.turno, a.grado, a.general, a.created_at, a.titulo, a.contenido, a.documento, c.nombre as nombre_carrera FROM avisos a INNER JOIN carreras c ON c.id = a.id_carrera WHERE a.id_carrera = :a_carrera';
            $string2 = '';
            $string3 = '';
            $string4 = '';
            $string5 = '';
            $enableFilters = 1;

            // dinamic query
            if($request->turno != 0){
                $string2 = 'AND a.turno = :a_turno';
                $enableFilters = 2;
            }
            if($request->grado != 0){
                $string3 = 'AND a.grado = :a_grado';
                $enableFilters = 3;
            }
            if($request->filter_date){
                $string4 = 'AND a.created_at BETWEEN :a_start AND :a_end';
            }
            $string5 = 'ORDER BY a.created_at DESC';
            $finalQuery = DB::raw("$string1 $string2 $string3 $string4 $string5");
            
            // do search
            if($enableFilters == 1){
                if($request->filter_date){
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera,
                        'a_start'=>$request->start,
                        'a_end'=>$request->end
                    ]);
                    return ['avisos' => $resultados];
                } else {
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera
                    ]);
                    return ['avisos' => $resultados];
                }
            } else if($enableFilters == 2) {
                if($request->filter_date){
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                        'a_start'=>$request->start,
                        'a_end'=>$request->end
                    ]);
                    return ['avisos' => $resultados];
                } else {
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                    ]);
                    return ['avisos' => $resultados];
                }
            } else {
                if($request->filter_date){
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                        'a_grado'=>$request->grado,
                        'a_start'=>$request->start,
                        'a_end'=>$request->end
                    ]);
                    return ['avisos' => $resultados];
                } else {
                    $resultados = DB::select($finalQuery, [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                        'a_grado'=>$request->grado,
                    ]);
                    return ['avisos' => $resultados];
                }
            }
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function traerAvisosAlumnos(Request $request)
    {
        try{
            $resultados = DB::select('SELECT
                a.id_carrera, a.turno, a.grado, a.general, a.created_at, a.titulo, a.contenido,
                a.documento, c.nombre as nombre_carrera
                FROM avisos a INNER JOIN carreras c ON c.id = a.id_carrera
                WHERE (a.id_carrera = :a_carrera OR a.id_carrera = 0) AND
                (a.turno = :a_turno OR a.turno = 0) AND
                (a.grado = :a_grado OR a.grado = 0) OR
                a.general = 1
                ORDER BY a.created_at DESC',
                [
                    'a_carrera'=>$request->carrera,
                    'a_turno'=>$request->turno,
                    'a_grado'=>$request->grado
                ]);
            
            return ['avisos' => $resultados];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardar_aviso(Request $request){
        //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $ruta_documento = null;
        
        try{
            DB::beginTransaction();
            
            if ($request->hasFile('documento')){
                //$nombre = $file->getClientOriginalName();//nombre del archivo
                //$ruta_documento = $request->documento->store('upload-documents','public');
                $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento'));
            }
            
            $aviso = new Aviso();
            $aviso->id_carrera = $request->id_carrera;
            $aviso->turno = $request->turno;
            $aviso->grado = $request->grado;
            $aviso->titulo = $request->titulo;
            $aviso->contenido = $request->contenido;
            $aviso->documento = $ruta_documento;
            $aviso->general = $request->general;
            $aviso->save();

            // query notification
            if($aviso->id_carrera == 1){
                // todas las carreras
                $finalQuery = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE a.condicion = 1 AND a.id_dispositivo <>""';
                $resultados = DB::select($finalQuery);
                
                foreach($resultados as $usuario){
                    OneSignal::sendNotificationToUser(
                        $request->titulo, 
                        $userId = $usuario->id_dispositivo,
                        $url = null, 
                        $data = ["aviso" => $aviso], 
                        $buttons = null, 
                        $schedule = null
                    );
                }
            } else {
                // especificos usuarios
                $string1 = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE m.id_carrera = :a_carrera AND a.id_dispositivo <>""';
                $string2 = '';
                $string3 = '';

                // dinamic query
                if($aviso->turno != 0){
                    $string2 = 'AND a.turno = :a_turno';
                }
                if($aviso->grado != 0){
                    $string3 = 'AND a.grado = :a_grado';
                }
                $string4 = 'AND a.condicion = 1';
                $finalQuery = DB::raw("$string1 $string2 $string3 $string4");
                $resultados = DB::select($finalQuery, [
                    'a_carrera' => $aviso->id_carrera,
                    'a_turno' => $aviso->turno,
                    'a_grado' => $aviso->grado
                ]);

                foreach($resultados as $usuario){
                    OneSignal::sendNotificationToUser(
                        $request->titulo, 
                        $userId = $usuario->id_dispositivo,
                        $url = null, 
                        $data = ["aviso" => $aviso], 
                        $buttons = null, 
                        $schedule = null
                    );
                }
            }
            
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            //$out->writeln("-------------- DOUH!! --------------");
            //$out->writeln($e);
        }

    }
}
