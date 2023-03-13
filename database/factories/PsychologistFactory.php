<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Psychologist;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Psychologist>
 */
class PsychologistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'therapy_id'=> $this->faker->numberBetween($min= 1, $max= 3),
            'bio'=> $this->faker->sentence(6) ,
            'ranking'=> $this->faker->randomDigit,
            'personal_phone'=> $this->faker->phoneNumber,
            'bussiness_phone'=> $this->faker->phoneNumber,
            'photo'=> $this->faker->sentence(6),
            'specialty'=>$this->faker->word
        ];
    }

}
