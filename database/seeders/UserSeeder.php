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

            'age'       => '35',

            'password'  => Hash::make('admin_monterrico12')  

        ])->assignRole('administrador');

        

        User::create([

            "name"      => 'Pablo',

            "lastname"  => "Moya",

            "email"     => "ing.pmoya@gmail.com",

            'phone'     => '51927038747',

            'gender'    => 'M',

            'age'       => '35',

            'password'  => Hash::make('sushi1234')  

        ])->assignRole('administrador');

    }

}

