<?php

namespace App\Services\Admin;

use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class RecipeService
{
    /**
     * @param array $filters
     * @param integer $perPage
     * @return Recipe[]|Collection|LengthAwarePaginator
     */
    public function index(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Recipe::orderBy('title')
            ->when(Arr::get($filters, 'title'), function(Builder $builder, $title) {
                return $builder->where('title', 'like', "%{$title}%");
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * @param array $requestData
     * @return Recipe
     */
    public function store(array $requestData = []): Recipe
    {
        $recipe = Recipe::create($this->transformData($requestData));

        $this->syncIngredients($recipe, Arr::get($requestData, 'ingredients', []));

        return $recipe;
    }

   /**
     * @param Recipe $recipe
     * @param array $requestData
     * @return Recipe
     */
    public function update(Recipe $recipe, array $requestData = []): Recipe
    {
        $recipe->update($this->transformData($requestData));

        $this->syncIngredients($recipe, Arr::get($requestData, 'ingredients', []));

        return $recipe;
    }

    /**
     * @param Recipe $recipe
     * @param array $ingredients
     * @return void
     */
    public function syncIngredients(Recipe $recipe, array $ingredients = []): void
    {
        $ingredientsSync = [];

        foreach ($ingredients as $ingredient) {
            $ingredientsSync[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'unit_measure' => $ingredient['unit_measure'],
            ];
        }

        $recipe->ingredients()->sync($ingredientsSync);
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return array_merge($requestData);
    }

    /**
     * @param Recipe $recipe
     * @return boolean|null
     */
    public function delete(Recipe $recipe): ?bool
    {
        return $recipe->delete();
    }
}
