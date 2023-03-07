<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $role1  = Role::create(['name'  =>  'paciente']);
        $role2  = Role::create(['name'  =>  'administrador']);
        $role3  = Role::create(['name'  =>  'psicologo']);

         Permission::create(['name' =>  'evaluar'])->assignRole($role2);
         Permission::create(['name' =>  'registrar_horarios_index'])->assignRole($role3);
         Permission::create(['name' =>  'usuarios.index'])->assignRole($role2);
         Permission::create(['name' =>  'psicologos.index'])->assignRole($role2);
    }
}
