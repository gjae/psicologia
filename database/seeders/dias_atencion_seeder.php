<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\dias_atencion;

class dias_atencion_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        dias_atencion::create(['nombre'=>'Lunes']);
        dias_atencion::create(['nombre'=>'Martes']);
        dias_atencion::create(['nombre'=>'Miercoles']);
        dias_atencion::create(['nombre'=>'Jueves']);
        dias_atencion::create(['nombre'=>'Viernes']);
        dias_atencion::create(['nombre'=>'Sábado']);
    }
}
