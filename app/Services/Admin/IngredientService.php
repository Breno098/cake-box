<?php

namespace App\Services\Admin;

use App\Models\Ingredient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class IngredientService
{
    /**
     * @param array $filters
     * @param integer $perPage
     * @return Ingredient[]|Collection|LengthAwarePaginator
     */
    public function index(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Ingredient::orderBy('name')
            ->when(Arr::get($filters, 'name'), function(Builder $builder, $name) {
                return $builder->where('name', 'like', "%{$name}%");
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * @param array $requestData
     * @return Ingredient
     */
    public function store(array $requestData = []): Ingredient
    {
        $ingredient = Ingredient::create($requestData);

        return $ingredient;
    }

   /**
     * @param Ingredient $ingredient
     * @param array $requestData
     * @return Ingredient
     */
    public function update(Ingredient $ingredient, array $requestData = []): Ingredient
    {
        $ingredient->update($requestData);

        return $ingredient;
    }

    /**
     * @param Ingredient $ingredient
     * @return boolean|null
     */
    public function delete(Ingredient $ingredient): ?bool
    {
        $ingredient->recipes()->detach();

        $ingredient->nutritional()->delete();

        return $ingredient->delete();
    }
}
