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
        Schema::create('problem_psycho_therapy', function (Blueprint $table) {
            $table->id();
            $table->integer('id_psycho_therapy')->unsigned();
            $table->integer('id_problem')->unsigned();
            $table->integer('id_therapy')->unsigned();
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
        Schema::dropIfExists('problem_psycho_therapy');
    }
};

