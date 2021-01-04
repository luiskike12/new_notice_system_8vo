<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Aviso;

class AvisoController extends Controller
{
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
