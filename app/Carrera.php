<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //protected $table = 'carreras';


    //asignacion de valores en masa
    protected $fillable = ['nombre', 'tipo_plan', 'tipo_modalidad', 'num_grados', 'turno_matutino', 'turno_vespertino', 'turno_nocturno', 'turno_mixto'];

    //Una carrera puede tener asociados varios Usuarios
    public function users(){
        return $this->hasMany('App\User', 'id_carrera');
    }

    //Una carrera puede tener asociadas muchas matriculas
    public function matriculas(){
        return $this->hasMany('App\Matricula', 'id_carrera');
    }

}
