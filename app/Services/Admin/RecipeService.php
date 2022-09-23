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

        return $recipe;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $startAt = Arr::get($requestData, 'start_at') ? Carbon::createFromFormat('d/m/Y', Arr::get($requestData, 'start_at')) : null;
        $endAt = Arr::get($requestData, 'end_at') ? Carbon::createFromFormat('d/m/Y', Arr::get($requestData, 'end_at')) : null;

        return array_merge($requestData, [
            'start_at' => $startAt,
            'end_at' => $endAt
        ]);
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
