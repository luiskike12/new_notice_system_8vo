<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    //protected $table = 'matriculas';
    protected $fillable = ['matricula', 'nombre', 'condicion'];

    public function carrera(){
        return $this->belongsTo('App\Carrera');
    }    

    public function alumno(){
        return $this->hasOne('App\Alumno', 'id_matricula');
    }
    /*id personalizado, la llave predefinida es (id) en Eloquent, lo cual id_matricula es la llave
    foranea que conecta al App\Alumno con App\Matricula y se relaciona con el nombre id_matricula
    */



}
