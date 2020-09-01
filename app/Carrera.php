<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //protected $table = 'carreras';


    //asignacion de valores en masa
    protected $fillable = ['nombre', 'tipo_plan', 'tipo_modalidad', 'num_grados', 'turno_matutino', 'turno_vespertino', 'turno_nocturno', 'turno_mixto'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function matricula(){
        return $this->hasMany('App\Matricula');
    }

}
