<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_registers_psychologist()
    {
        $response = $this->post('/registerpsychologist',[
            'name'=>'Miria',
            'lastname'=>'alvarez',
            'email'=>'abc@gmail.com',
            'phone'=>'20515',
            'therapy_id'=>'2',
            'personal_phone'=>'012485822',
            'bussiness_phone'=>'0212452152',
            'gender'=>'M',
            'id_user'=>4, //el ultimo que se cree
            'photo'=>'terapista.png',
            'role'=>3,
            'specialty'=>'Terapia conductual',
            'password'=>Hash::make('12345678')  
        ]);

        $response->assertStatus(200);
    }
}
