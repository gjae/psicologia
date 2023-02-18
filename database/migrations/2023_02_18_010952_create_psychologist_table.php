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
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->string('personal_phone');
            $table->string('bussiness_phone');
            $table->string('gender');
            $table->string('specialty');
            $table->integer('therapy_id')->unsigned();
            $table->timestamps();

            
            $table->foreign('therapy_id')->references('id')->on('therapy');
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
