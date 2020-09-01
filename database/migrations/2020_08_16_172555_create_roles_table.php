<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 130);
            $table->boolean('condicion')->default(1);
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador','descripcion'=>'Tiene los permisos para, operar todas las funcionalidades del sistema.'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Coordinador','descripcion'=>'Tiene permisos y funciones específicas de la carrera a su cargo, entre ellas, enviar mensajes, activar y desactivar alumnos.'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Asistente','descripcion'=>'Tiene permisos únicamente, para el envío de mensajes y registros de matrículas de la carrera a su cargo.'));
        DB::table('roles')->insert(array('id'=>'4','nombre'=>'Docente','descripcion'=>'Tiene permisos únicamente, para el envío de mensajes.'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void3
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
