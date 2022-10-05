<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_measure' => fake()->randomElement(['Pedaço', 'Fatia', 'Gramas']),
            'kcal' => fake()->numberBetween(0, 300),
            'fat' => fake()->numberBetween(0, 300),
            'saturates' => fake()->numberBetween(0, 300),
            'carbs' => fake()->numberBetween(0, 300),
            'sugars' => fake()->numberBetween(0, 300),
            'fibre' => fake()->numberBetween(0, 300),
            'protein' => fake()->numberBetween(0, 300),
            'salt' => fake()->numberBetween(0, 300),
        ];
    }
}
