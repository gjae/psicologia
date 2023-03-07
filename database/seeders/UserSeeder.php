<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Psychologist;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        User::create([
            "name"      => 'administrador',
            "lastname"  => "administrador",
            "email"     => "tupsicologoenlima@gmail.com",
            'phone'     => '51927038747',
            'gender'    => 'M',
            'role'      => 2,
            'age'       => '35',
            'password'  => Hash::make('admin_monterrico12')  
        ])->assignRole('administrador');
        
        
    }
}
