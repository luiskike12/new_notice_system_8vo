<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Carrera;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            //se crea un array de todo lo que devuelva el metodo
            $carreras = Carrera::where('id','!=','1')
            ->where('id','!=','2')
            ->orderBy('id', 'desc')
            ->paginate(5);
        }
        else{
            $carreras = Carrera::where($criterio, 'like', '%'.$buscar.'%')
            ->where(function ($query) {
                $query->where('id','!=','1')->where('id','!=','2');
            })
            ->orderBy('id', 'desc')->paginate(5);
        }
        
        return[
            'pagination' => [
                'total'         => $carreras->total(),
                'current_page'  => $carreras->currentPage(),
                'per_page'      => $carreras->perPage(),
                'last_page'     => $carreras->lastPage(),
                'from'          => $carreras->firstItem(),
                'to'            => $carreras->lastItem(),
            ],
            'carreras' => $carreras
        ];
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        //metodo Guardar
        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->tipo_plan = $request->tipo_plan;
        $carrera->tipo_modalidad = $request->tipo_modalidad;
        $carrera->num_grados = $request->num_grados;

        if($request->tipo_modalidad == 1){//Escolarizada
            $carrera->turno_matutino = '1';
            $carrera->turno_vespertino = '1';
            $carrera->turno_nocturno = '1';
            $carrera->turno_mixto = '0';
        }
    
        if($request->tipo_modalidad == 2){//Semiescolarizada
            $carrera->turno_matutino = '0';
            $carrera->turno_vespertino = '0';
            $carrera->turno_nocturno = '0';
            $carrera->turno_mixto = '1';
        }
        
        $carrera->save();
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        //actualiza la fila de la tabla seleccionada
        $carrera = Carrera::findOrFail($request->id);
        $carrera->nombre = $request->nombre;
        $carrera->tipo_plan = $request->tipo_plan;
        $carrera->tipo_modalidad = $request->tipo_modalidad;
        $carrera->num_grados = $request->num_grados;

        //comparar si modalidad anterior es igual a modalidad actualizar
        $result = Carrera::find($request->id);
       
        if($result['tipo_modalidad']!=$request->tipo_modalidad){
            if($request->tipo_modalidad == 1){//Escolarizada
                $carrera->turno_matutino = '1';
                $carrera->turno_vespertino = '1';
                $carrera->turno_nocturno = '1';
                $carrera->turno_mixto = '0';
            }
            if($request->tipo_modalidad == 2){//Semiescolarizada
                $carrera->turno_matutino = '0';
                $carrera->turno_vespertino = '0';
                $carrera->turno_nocturno = '0';
                $carrera->turno_mixto = '1';
            }
        }
        
        $carrera->save();
    }

    //--------------------MATUTINO-----------------------------
    public function desactivar_matutino(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_matutino = '0';
        $carrera->save();
    }

    public function activar_matutino(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_matutino = '1';
        $carrera->save();
    }

    //--------------------VESPERTINO-----------------------------
    public function desactivar_vespertino(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_vespertino = '0';
        $carrera->save();
    }

    public function activar_vespertino(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_vespertino = '1';
        $carrera->save();
    }

    //--------------------NOCTURNO-------------------------------
    public function desactivar_nocturno(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_nocturno = '0';
        $carrera->save();
    }

    public function activar_nocturno(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_nocturno = '1';
        $carrera->save();
    }

    //--------------------MIXTO-------------------------------
    public function desactivar_turno_mixto(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_mixto = '0';
        $carrera->save();
    }

    public function activar_turno_mixto(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $carrera = Carrera::findOrFail($request->id);
        $carrera->turno_mixto = '1';
        $carrera->save();
    }

    public function selectCarrera(){
        /*Usar parametros dinamicos como un (?) marcador o (:title) parametro de sustitucion
        para evitar inyección SQL
        ------------ejemplo con el marcador------
        DB::insert('INSERT INTO professions (title) VALUES (?)', ["Desarrollador"]);

        ------------Parametro de sustitucion (cuando tenemos muchos parametros)------
        DB::insert('INSERT INTO professions (title) VALUES (:title)', ['title'=>'Desarrollador']);

        */
         
        $carreras = DB::select('SELECT id, nombre, CASE tipo_modalidad
        when 1 then "Escolarizado" 
        when 2 then "Semiescolarizado" end as tipo_modalidad, turno_matutino, turno_vespertino, 
        turno_nocturno, turno_mixto, num_grados
        FROM carreras 
        WHERE turno_matutino = :matutino OR turno_vespertino = :vespertino 
        OR turno_nocturno = :nocturno OR turno_mixto = :mixto ORDER BY nombre ASC;', 
        ['matutino' => 1, 'vespertino' => 1, 'nocturno' => 1, 'mixto' => 1]);

        return ['carreras' => $carreras];
    }
}
