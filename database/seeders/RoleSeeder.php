<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role1= Role::create(['Name'=>'Paciente']);
        $role2= Role::create(['Name'=>'Administrador']);
        $role3= Role::create(['Name'=>'Psicologo']);
    }
}
