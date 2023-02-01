<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->colorName(),
            'path' => \App\Helpers\Seeder\Random::image(),
            'size' =>  fake()->numberBetween(500, 5000)
        ];
    }
}
