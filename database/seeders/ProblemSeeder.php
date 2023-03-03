<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Problems;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Problems::create([
            "id_therapy" => 1,
            "problem" => "Infidelidad"
        ]);
        
        Problems::create([
            "id_therapy" => 1,
            "problem" => "Separación"
        ]);
        
        Problems::create([
            "id_therapy" => 1,
            "problem" => "Problemas de comunicación"
        ]);
        
        Problems::create([
            "id_therapy" => 2,
            "problem" => "Ansiedad"
        ]);
        
        Problems::create([
            "id_therapy" => 2,
            "problem" => "Dependencia"
        ]);
        
        Problems::create([
            "id_therapy" => 2,
            "problem" => "Depresión"
        ]);
        
        Problems::create([
            "id_therapy" => 3,
            "problem" => "Impulsividad"
        ]);
        
        Problems::create([
            "id_therapy" => 3,
            "problem" => "Baja atención"
        ]);
        
    }
}
