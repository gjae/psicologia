<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        //
        Schema::create('hora_dia_atencion', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('id_schedule')->unsigned();
            $table->integer('id_dia')->unsigned();
            $table->integer('id_psycho')->unsigned();
            

            $table->foreign('id_schedule')
            ->references('id')->on('schedules');
            
            $table->foreign('id_dia')
            ->references('id')->on('dias_atencion');

            $table->foreign('id_psycho')
            ->references('id')->on('psychologist');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        
        Schema::dropIfExists('hora_dia_atencion');
    }
};
