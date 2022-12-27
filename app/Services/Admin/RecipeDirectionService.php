<?php

namespace App\Services\Admin;

use App\Models\Direction;
use App\Models\Recipe;
use Illuminate\Support\Arr;

class RecipeDirectionService
{
    /**
     * @param Recipe $recipe
     * @param array $requestData
     * @return void
     */
    public function store(Recipe $recipe, array $requestData = []): void
    {
        $recipe->directions()->create([
            'description' => Arr::get($requestData, 'description'),
            'order' => $recipe->directions()->count() + 1,
        ]);
    }

    /**
     * @param Recipe $recipe
     * @param Direction $direction
     * @param array $requestData
     * @return void
     */
    public function update(Recipe $recipe, Direction $direction, array $requestData = []): void
    {
        $direction->update([
            'description' => Arr::get($requestData, 'description'),
            'order' => $recipe->directions()->count() + 1,
        ]);
    }

    /**
     * @param Direction $direction
     * @return boolean|null
     */
    public function delete(Direction $direction): ?bool
    {
        return $direction->delete();
    }
}
