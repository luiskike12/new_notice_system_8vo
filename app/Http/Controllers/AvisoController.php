<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Aviso;

class AvisoController extends Controller
{
    public function traerAvisosAlumnosFiltros(Request $request)
    {
        try{
            if($request->filter_date){
                $alumno = DB::select('SELECT
                    a.id_carrera, a.turno, a.grado, a.general, a.created_at, a.titulo, a.contenido,
                    a.documento, c.nombre as nombre_carrera
                    FROM avisos a INNER JOIN carreras c ON c.id = a.id_carrera
                    WHERE a.id_carrera = :a_carrera AND
                    a.turno = :a_turno AND
                    a.grado = :a_grado AND
                    a.created_at BETWEEN :a_start AND :a_end
                    ORDER BY a.created_at DESC',
                    [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                        'a_grado'=>$request->grado,
                        'a_start'=>$request->start,
                        'a_end'=>$request->end
                    ]);
            
                return ['avisos' => $alumno];
            } else {
                $alumno = DB::select('SELECT * FROM avisos WHERE
                    (id_carrera = :a_carrera) AND
                    (turno = :a_turno) AND
                    (grado = :a_grado)
                    ORDER BY created_at DESC',
                    [
                        'a_carrera'=>$request->carrera,
                        'a_turno'=>$request->turno,
                        'a_grado'=>$request->grado
                    ]);
            
                return ['avisos' => $alumno];
            }
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function traerAvisosAlumnos(Request $request)
    {
        try{
            $alumno = DB::select('SELECT
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
            
            return ['avisos' => $alumno];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardar_aviso(Request $request){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $ruta_documento = null;

        try{
            DB::beginTransaction();
            // $data = $request->validate([])
            if ($request->hasFile('documento')){
                $out->writeln("SI llego un archivo... 
                id_carrera: ".$request['id_carrera'].
                " || turno: ".$request['turno'].
                " || grado: ".$request['grado'].
                " || titulo: ".$request['titulo'].
                " || contenido: ".$request['contenido'].
                " || general: ".$request['general'].
                " || documento: ".$request['documento']);
                
                //$nombre = $file->getClientOriginalName();//nombre del archivo
                //$ruta_documento = $request->documento->store('upload-documents','public');
                $ruta_documento = Storage::disk('public')->put('upload-documents', $request->file('documento'));
            }
            else{
                $out->writeln("NO LLEGO ningun archivo... 
                id_carrera: ".$request['id_carrera'].
                " || turno: ".$request['turno'].
                " || grado: ".$request['grado'].
                " || titulo: ".$request['titulo'].
                " || contenido: ".$request['contenido'].
                " || general: ".$request['general'].
                " || documento: ".$request['documento']);    
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
            
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
        
    }
}
