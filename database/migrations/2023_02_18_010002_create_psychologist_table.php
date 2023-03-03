<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychologist', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('personal_phone');
            $table->string('bussiness_phone');
            $table->string('specialty');
            $table->string('photo')->nullable();
            $table->integer('ranking')->nullable();
            $table->integer('therapy_id')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->timestamps();

            
            $table->foreign('therapy_id')->references('id')->on('therapy');

            $table->foreign('id_user')->references('id')->on('users'); //nombre de la tabla, no del modelo.. El modelo se llama USER, y la tabla se llama USERS
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psychologist');
    }
};
