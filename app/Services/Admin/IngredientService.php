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
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Ingredient[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Ingredient::when(Arr::get($filters, 'name'), function(Builder $builder, $name) {
                return $builder->where('name', 'like', "%{$name}%");
            })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
                return $query->orderBy($orderBy, $sort);
            })
            ->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Ingredient
     */
    public function store(array $requestData = []): Ingredient
    {
        return Ingredient::create($requestData);
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

        return $ingredient->delete();
    }
}
