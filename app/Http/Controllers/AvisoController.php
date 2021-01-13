<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Aviso;

class AvisoController extends Controller
{

    public function index(Request $request){
        //if(!$request->ajax())return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            //se crea un array de todo lo que devuelva el metodo
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

    public function guardar_aviso(Request $request){
        //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $ruta_documento = null;

        try{
            DB::beginTransaction();
            // $data = $request->validate([])
            if ($request->hasFile('documento')){
                // $out->writeln("SI llego un archivo... 
                // id_carrera: ".$request['id_carrera'].
                // " || turno: ".$request['turno'].
                // " || grado: ".$request['grado'].
                // " || titulo: ".$request['titulo'].
                // " || contenido: ".$request['contenido'].
                // " || general: ".$request['general'].
                // " || documento: ".$request['documento']);
                
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
            
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
        
    }
}
