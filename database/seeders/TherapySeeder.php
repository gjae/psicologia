<?php

namespace Database\Seeders;

use App\Models\Therapy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TherapySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Therapy::create([
            "therapy_type"   => 'Terapia de pareja',
            "description" => "lorem ipsum dolor sit amet"
        ]);
        Therapy::create([
            "therapy_type"   => 'Terapia personal',
            "description" => "lorem ipsum dolor sit amet"
        ]);
        Therapy::create([
            "therapy_type"   => 'Terapia de menores',
            "description" => "lorem ipsum dolor sit amet"
        ]);
    }
}
