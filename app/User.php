<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_carrera', 'id_rol', 'usuario', 'password', 'nombre', 'correo', 'condicion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;

    public function rol(){
        return $this->belongsTo('App\Rol', 'id');
    }

    public function carrera(){
        return $this->belongsTo('App\Carrera', 'id');
    }

    /* Un usuaio puede tener muchos avisos, uno a muchos */
    public function avisos(){
        return $this->hasMany('App\Aviso', 'id_user');
    }
    
}
