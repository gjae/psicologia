<?php



namespace Database\Factories;



use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;



/**

 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>

 */

class UserFactory extends Factory

{

    /**

     * Define the model's default state.

     *

     * @return array<string, mixed>

     */

    public function definition()

    {

        //$faker = Factory::create();

        return [

        'name' => $this->faker->name(),

        'lastname' => 'as',

        'email' => $this->faker->email,

        'password' => Hash::make('00000000'),

        'phone' => '1234567',

        'gender' => 'H',

        'age' => 36,

        'role' => 1

        ];

    }



    /**

     * Indicate that the model's email address should be unverified.

     *

     * @return static

     */

    public function unverified()

    {

        return $this->state(fn (array $attributes) => [

            'email_verified_at' => null,

        ]);

    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (User $user) {
            // ...
        })->afterCreating(function (User $user) {
            // ...
            $ultimo= User::latest()->first();
            $ultimo->assignRole('psicologo');
        });
    }

}

