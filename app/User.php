<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//Importacion de la clase con el texto modificado para reseteo de contraseña
Use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_carrera', 'id_rol', 'name', 'email', 'usuario', 'password', 'avatar', 'condicion'
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


    /**
     *  ------------------------------------------------------
     *       NOTIFICACIÓN PERSONALIZADA para el reseteo de contraseña 
     *  -------------------------------------------------------
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    //Relaciones de las tablas con los modelos
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
