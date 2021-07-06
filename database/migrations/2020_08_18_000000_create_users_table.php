<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

            $table->string('name');
            $table->string('email')->unique();
            $table->string('usuario')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('condicion')->default(1);

            $table->rememberToken();
            $table->timestamps();
        });

        //Usuario principal al ejecutar las migrasiones
        DB::table('users')->insert(
        ['id'=>1,'id_carrera'=>1,'id_rol'=>1, 'name'=>'admin',
        'email'=>'admin@email.com', 'usuario'=>'admin', 'password'=>bcrypt('password'),
        'avatar'=>'img/avatars/avatar.png', 'condicion'=>1]);
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
