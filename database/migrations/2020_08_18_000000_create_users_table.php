<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_carrera')->unsigned();
            $table->foreign('id_carrera')->references('id')->on('carreras');

            $table->integer('id_rol')->unsigned();
            $table->foreign('id_rol')->references('id')->on('roles');

            $table->string('usuario', 30)->unique();
            $table->string('password');
            $table->string('nombre', 80);
            $table->string('correo', 80);
            $table->boolean('condicion')->default(1);

            $table->rememberToken();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
