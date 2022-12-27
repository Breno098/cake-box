<?php

namespace App\Services\Admin;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Arr;

class RecipeIngredientService
{
    /**
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @param array $requestData
     * @return void
     */
    public function attach(Recipe $recipe, Ingredient $ingredient, array $requestData = []): void
    {
        $recipe->ingredients()->attach($ingredient, [
            'quantity' => Arr::get($requestData, 'quantity', 1),
            'unit_measure' => Arr::get($requestData, 'unit_measure'),
        ]);
    }

    /**
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @param array $requestData
     * @return void
     */
    public function update(Recipe $recipe, Ingredient $ingredient, array $requestData = []): void
    {
        $this->detach($recipe, $ingredient);
        $this->attach($recipe, $ingredient, $requestData);
    }

     /**
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @return boolean|null
     */
    public function detach(Recipe $recipe, Ingredient $ingredient): ?bool
    {
        return $recipe->ingredients()->detach($ingredient) > 0;
    }
}
