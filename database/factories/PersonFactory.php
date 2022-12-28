<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'whatsapp' => fake()->numerify('(##)#####-####'),
            'instagram' => fake()->email(),
            'facebook' => fake()->email(),
            'linkedin' => fake()->email(),
            'phone' => fake()->numerify('(##)####-####'),
            'cellphone' => fake()->numerify('(##)#####-####'),
            'info' => fake()->realText(100),
            'web_site' => fake()->url(),
            'specialty' => fake()->randomElement([
                'Nutricionista',
                'Instrutor Físico',
                'Nutrólogo'
            ]),
        ];
    }
}
