<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumno extends Model
{
    /*
        Eloquent también asumirá que cada tabla tiene una columna de clave primaria nombrada id. 
        Puede definir una $primaryKey protegida y anular esta convención:
        protected $primaryKey = 'flight_id';
    */

    protected $primaryKey = 'id_matricula';
    
    //protected $table = 'alumnos';
    protected $fillable = [ 'id_matricula', 'id_dispositivo', 'password', 'correo', 'grado', 'turno'];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function matricula(){
        //Funcion inversa de hasOne() para relacionar esta tabla con la entidad padre uno a uno
        return $this->belongsTo('App\Matricula');
    }

}
