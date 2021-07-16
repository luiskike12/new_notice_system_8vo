<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 80);
            $table->integer('tipo_plan');
            $table->integer('tipo_modalidad');
            $table->boolean('turno_matutino')->default(1);
            $table->boolean('turno_vespertino')->default(1);
            $table->boolean('turno_nocturno')->default(1);
            $table->boolean('turno_mixto')->default(1);
            $table->integer('num_grados');
            $table->timestamps();
        });
        DB::table('carreras')->insert(
        array('id'=>'1','nombre'=>'Institucional General','tipo_plan'=>'0',
        'tipo_modalidad'=>'0', 'turno_matutino'=>'0', 'turno_vespertino'=>'0', 'turno_nocturno'=>'0',
        'turno_mixto'=>'0', 'num_grados'=>'0')
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carreras');
    }
}
