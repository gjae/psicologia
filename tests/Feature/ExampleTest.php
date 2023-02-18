<?php

namespace Tests\Feature;

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
            'name'=>'Juan',
            'lastname'=>'alvarez',
            'email'=>'juan@asd.co',
            'therapy_id'=>'1',
            'personal_phone'=>'012485822',
            'bussiness_phone'=>'0212452152',
            'gender'=>'M',
            'specialty'=>'Terapia conductual'
        ]);

        $response->assertStatus(200);
    }
}
