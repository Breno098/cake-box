<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->text(15),
            'description' => fake()->text(100),
            'info' => fake()->text(100),
            'difficulty' => fake()->randomElement(['very easy', 'easy', 'medium', 'hard', 'very hard']),
            'time_to_cook' => fake()->numberBetween(0, 50000),
            'time_to_prepare' => fake()->numberBetween(0, 50000),
            'rating' => fake()->numberBetween(0, 5),
            'yield_quantity' => fake()->numberBetween(0, 15),
            'yield_unit_measure' => fake()->randomElement(['Pedaço', 'Fatia', 'Gramas']),
        ];
    }
}
