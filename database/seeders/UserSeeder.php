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
        //
        User::create([
            "name"   => 'psicologo',
            "lastname" => "monterrico",
            "email"   => "monterrico@gmail.com",
            'phone'   => '5451520202',
            'gender'    => 'M',
            'role'    => 1,
            'age'    => '24',
            'password' => Hash::make('01452')  
        ]);

        User::create([
            "name"   => 'Yohanna',
            "lastname" => "Padrino",
            "email"   => "ypadrino@gmail.com",
            'phone'   => '5451520202',
            'gender'    => 'F',
            'role'    => 2,
            'age'    => '29',
            'password' => Hash::make('000000')  
        ]);
        User::create([
            "name"   => 'Pablo',
            "lastname" => "moya",
            "email"   => "pmoya@gmail.com",
            'phone'   => '54515435302',
            'gender'    => 'H',
            'role'    => 3,
            'age'    => '25',
            'password' => Hash::make('012345')  
        ]);
        
    }
}
