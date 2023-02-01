<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->realText(500),
            'tags' => implode(' ', fake()->randomElements([
                '#' . fake()->colorName(), '#' . fake()->colorName(),
                '#' . fake()->colorName(), '#' . fake()->colorName(),
                '#' . fake()->colorName(), '#' . fake()->colorName(),
                '#' . fake()->colorName(), '#' . fake()->colorName(),
                '#' . fake()->colorName(), '#' . fake()->colorName(),
                '#' . fake()->colorName(), '#' . fake()->colorName(),
            ], random_int(1, 10)))
        ];
    }
}
