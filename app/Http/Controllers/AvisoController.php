<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Aviso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use OneSignal;

class AvisoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax())return redirect('/');
        
        $id_usuario = Auth::user()->id;
        $rol = Auth::user()->id_rol;
        $carrera_usuario = Auth::user()->id_carrera;

        $criterio = $request->criterio;
        $buscar = $request->buscar;
        $criterio2 = $request->criterio2;
        $buscar2 = $request->buscar2;
        $criterio3 = $request->criterio3;
        $buscar3 = $request->buscar3;
        
        //Busqueda para el Rol Coordinador y Asistente
        if($rol == 1 || $rol == 4){
            if($buscar==''){
                $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                DB::raw('CASE carreras.tipo_modalidad
                WHEN 0 THEN "General"
                WHEN 1 THEN "Escolarizado"
                WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                ->where('avisos.id_usuario','=',$id_usuario)
                ->orderBy('avisos.id', 'desc')->paginate(5);
            }
            else{
                if($criterio === 'tipo_modalidad'){
                    $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                    ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad
                    WHEN 0 THEN "General"
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                    'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                    'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                    ->where('carreras.'.$criterio, 'like', '%'.$buscar.'%')
                    ->where('avisos.id_usuario','=',$id_usuario)
                    ->orderBy('avisos.id', 'desc')->paginate(5);
                }else{
                    if($criterio2 === 'grado' && $criterio3 === 'turno'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_usuario','=',$id_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio2, 'like', '%'.$buscar2.'%')
                        ->where('avisos.'.$criterio3, 'like', '%'.$buscar3.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else if($criterio2 === 'grado'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_usuario','=',$id_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio2, 'like', '%'.$buscar2.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else if($criterio3 === 'turno'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_usuario','=',$id_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio3, 'like', '%'.$buscar3.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else{
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_usuario','=',$id_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                }
            }
        }

        if($rol == 2 || $rol == 3){
            if($buscar==''){
                $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                DB::raw('CASE carreras.tipo_modalidad
                WHEN 0 THEN "General"
                WHEN 1 THEN "Escolarizado" 
                WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                ->where('avisos.id_carrera','=',$carrera_usuario)
                ->orderBy('avisos.id', 'desc')->paginate(5);
            }
            else{
                if($criterio === 'tipo_modalidad'){
                    $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                    ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                    DB::raw('CASE carreras.tipo_modalidad
                    WHEN 0 THEN "General"
                    WHEN 1 THEN "Escolarizado" 
                    WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                    'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                    'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                    ->where('carreras.'.$criterio, 'like', '%'.$buscar.'%')
                    ->where('avisos.id_carrera','=',$carrera_usuario)
                    ->orderBy('avisos.id', 'desc')->paginate(5);
                }else{
                    if($criterio2 === 'grado' && $criterio3 === 'turno'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_carrera','=',$carrera_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio2, 'like', '%'.$buscar2.'%')
                        ->where('avisos.'.$criterio3, 'like', '%'.$buscar3.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else if($criterio2 === 'grado'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_carrera','=',$carrera_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio2, 'like', '%'.$buscar2.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else if($criterio3 === 'turno'){
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_carrera','=',$carrera_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->where('avisos.'.$criterio3, 'like', '%'.$buscar3.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                    else{
                        $avisos = Aviso::join('carreras','carreras.id','=','avisos.id_carrera')
                        ->select('avisos.id','avisos.id_carrera','carreras.nombre as nombre_carrera',
                        DB::raw('CASE carreras.tipo_modalidad
                        WHEN 0 THEN "General"
                        WHEN 1 THEN "Escolarizado" 
                        WHEN 2 THEN "Semiescolarizado" END AS tipo_modalidad'),
                        'avisos.titulo','avisos.contenido','avisos.documento as url_documento',
                        'avisos.general','avisos.turno','avisos.grado','avisos.estado')
                        ->where('avisos.id_carrera','=',$carrera_usuario)
                        ->where('avisos.'.$criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('avisos.id', 'desc')->paginate(5);
                    }
                }
            }
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
            $string1 = 'SELECT a.id, a.id_carrera, a.turno, a.grado, a.general, a.created_at, a.titulo, a.contenido, a.documento, c.nombre as nombre_carrera FROM avisos a INNER JOIN carreras c ON c.id = a.id_carrera WHERE a.id_carrera = :a_carrera';
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

    public function verificarAviso(Request $request)
    {
        try{
            $resultado = DB::select('SELECT
                a.id, a.id_carrera, a.turno, a.grado, a.general, a.created_at, a.titulo,
                a.contenido, a.documento FROM avisos a 
                WHERE a.id = :a_id AND
                (a.id_carrera = :a_carrera OR a.id_carrera = 1  OR a.id_carrera = 2) AND
                (a.turno = :a_turno OR a.turno = 0) AND
                (a.grado = :a_grado OR a.grado = 0)
                ORDER BY a.created_at DESC',
                [
                    'a_id'=>$request->id,
                    'a_carrera'=>$request->carrera,
                    'a_turno'=>$request->turno,
                    'a_grado'=>$request->grado
                ]);
            
            return ['aviso' => $resultado];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function traerAvisosAlumnos(Request $request)
    {
        try{
            $resultados = DB::select('SELECT
                a.id, a.id_carrera, a.turno, a.grado, a.general, a.created_at,
                a.titulo, a.contenido, a.documento, c.nombre as nombre_carrera
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
        
        try{
            DB::beginTransaction();

            $ruta_documento = null;
            $fecha = Carbon::now('America/Mexico_City');
            $id_usuario = Auth::user()->id;

            if ($request->hasFile('documento')){
                //$nombre = $file->getClientOriginalName();//nombre del archivo
                //$ruta_documento = $request->documento->store('upload-documents','public');
                $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento'));
            }
            
            $aviso = new Aviso();
            $aviso->id_usuario = $id_usuario;
            $aviso->id_carrera = $request->id_carrera;
            $aviso->turno = $request->turno;
            $aviso->grado = $request->grado;
            $aviso->titulo = $request->titulo;
            $aviso->contenido = $request->contenido;
            $aviso->documento = $ruta_documento;
            $aviso->general = $request->general;
            $aviso->estado = $request->estado;
            $aviso->fecha_hora = $fecha->toDateString();
            $aviso->save();
            
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

    }

    public function guardar_y_enviar_aviso(Request $request){
        try{
            DB::beginTransaction();

            $ruta_documento = null;
            $fecha = Carbon::now('America/Mexico_City');
            $id_usuario = Auth::user()->id;
            
            if ($request->hasFile('documento')){
                //$nombre = $file->getClientOriginalName();//nombre del archivo
                //$ruta_documento = $request->documento->store('upload-documents','public');
                $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento'));
            }
            
            $aviso = new Aviso();
            $aviso->id_usuario = $id_usuario;
            $aviso->id_carrera = $request->id_carrera;
            $aviso->turno = $request->turno;
            $aviso->grado = $request->grado;
            $aviso->titulo = $request->titulo;
            $aviso->contenido = $request->contenido;
            $aviso->documento = $ruta_documento;
            $aviso->general = $request->general;
            $aviso->estado = $request->estado;
            $aviso->fecha_hora = $fecha->toDateString();
            $aviso->save();

            // query notification
            if($aviso->id_carrera == 1){
                // todas las carreras
                $finalQuery = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE a.condicion = 1 AND a.id_dispositivo IS NOT NULL ';
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
                $string1 = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE m.id_carrera = :a_carrera AND a.id_dispositivo IS NOT NULL ';
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
        }

    }

    public function actualizar_aviso(Request $request){
        
        $ruta_documento = null;
        $url_img = '';
        
        try{
            DB::beginTransaction();

            //para filtrar el id del usuario
            $aviso = Aviso::findOrFail($request->id);

            if($request->hasFile('documento')){
                if($aviso->documento == null){
                    $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento'));
                }else{
                    if(strcmp($aviso->documento, $request->documento)===0){
                        $ruta_documento = $aviso->documento;
                    }else{
                        $url_img = 'public/'.$aviso->documento;
                        Storage::delete($url_img);
                        $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento')); 
                    }
                }
            }else{
                if(strcmp($aviso->documento, $request->documento)===0){
                    $ruta_documento = $aviso->documento;
                }
            }

            $aviso->id_carrera = $request->id_carrera;
            $aviso->turno = $request->turno;
            $aviso->grado = $request->grado;
            $aviso->titulo = $request->titulo;
            $aviso->contenido = $request->contenido;
            $aviso->documento = $ruta_documento;
            $aviso->general = $request->general;
            $aviso->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
        
    }

    public function eliminar_aviso(Request $request){
        try{
            DB::beginTransaction();
            
            $url_img = '';

            $aviso = Aviso::findOrFail($request->id);
            if($aviso->documento){
                $url_img = 'public/'.$aviso->documento;
                Storage::delete($url_img);   
            }
            $aviso->delete();

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function reenviar_aviso(Request $request){
        try{
            DB::beginTransaction();

            $aviso = Aviso::findOrFail($request->id);
            $aviso->estado = '1';
            $aviso->save();

            // query notification
            if($aviso->id_carrera == 1){
                // todas las carreras
                $finalQuery = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE a.condicion = 1 AND a.id_dispositivo IS NOT NULL ';
                $resultados = DB::select($finalQuery);
                
                foreach($resultados as $usuario){
                    OneSignal::sendNotificationToUser(
                        $aviso->titulo, 
                        $userId = $usuario->id_dispositivo,
                        $url = null, 
                        $data = ["aviso" => $aviso], 
                        $buttons = null, 
                        $schedule = null
                    );
                }
            } else {
                // especificos usuarios
                $string1 = 'SELECT a.id_dispositivo FROM alumnos a INNER JOIN matriculas m ON m.id = a.id_matricula WHERE m.id_carrera = :a_carrera AND a.id_dispositivo IS NOT NULL ';
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
                        $aviso->titulo, 
                        $userId = $usuario->id_dispositivo,
                        $url = null, 
                        $data = ["aviso" => $aviso], 
                        $buttons = null, 
                        $schedule = null
                    );
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }



}
