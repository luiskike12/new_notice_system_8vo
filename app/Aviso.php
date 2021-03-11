<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    //asignacion de valores en masa
    protected $fillable = ['id_carrera', 'turno', 'grado', 'titulo', 'contenido', 'documento', 'general'];

    public function alumno(){
        return $this->hasMany('App\Alumnos', 'id_matricula');
    }

}
