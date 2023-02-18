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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('appointment_date');
            $table->string('appointment_info');
            $table->integer('id_user')->unsigned();
            $table->integer('id_schedule')->unsigned();
            $table->integer('number_of_sessions');
            $table->float('amount');
            $table->string('cause');
            $table->timestamps();

            
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_schedule')->references('id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
