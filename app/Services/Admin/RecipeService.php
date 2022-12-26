<?php

namespace App\Services\Admin;

use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Recipe[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Recipe::when(Arr::get($filters, 'title'), function(Builder $builder, $title) {
            return $builder->where('title', 'like', "%{$title}%");
        })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
            return $query->orderBy($orderBy, $sort);
        })
        ->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Recipe
     */
    public function store(array $requestData = []): Recipe
    {
        $recipe = Recipe::create($this->transformData($requestData));

        $this->syncIngredients($recipe, Arr::get($requestData, 'ingredients', []));

        $this->syncDirections($recipe, Arr::get($requestData, 'directions', []));

        $this->uploadImages($recipe, $requestData);

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

        $this->syncDirections($recipe, Arr::get($requestData, 'directions', []));

        $this->uploadImages($recipe, $requestData);

        return $recipe;
    }

     /**
     * @param Recipe $recipe
     * @return boolean|null
     */
    public function delete(Recipe $recipe): ?bool
    {
        $recipe->ingredients()->detach();

        $recipe->directions()->delete();

        return $recipe->delete();
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return [
            'title' => Arr::get($requestData, 'title'),
            'description' => Arr::get($requestData, 'description'),
            'info' => Arr::get($requestData, 'info'),
            'difficulty' => Arr::get($requestData, 'difficulty'),
            'time_to_cook' => Arr::get($requestData, 'time_to_cook'),
            'time_to_prepare' => Arr::get($requestData, 'time_to_prepare'),
            'yield_quantity' => Arr::get($requestData, 'yield_quantity'),
            'yield_unit_measure' => Arr::get($requestData, 'yield_unit_measure'),
        ];
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
                'quantity' => Arr::get($ingredient, 'quantity', 1),
                'unit_measure' => Arr::get($ingredient, 'unit_measure'),
            ];
        }

        $recipe->ingredients()->sync($ingredientsSync);
    }

    /**
     * @param Recipe $recipe
     * @param array $directions
     * @return void
     */
    public function syncDirections(Recipe $recipe, array $directions = []): void
    {
        $recipe->directions()->delete();

        foreach ($directions as $direction) {
            $recipe->directions()->create([
                'description' => Arr::get($direction, 'description'),
                'order' => Arr::get($direction, 'order'),
            ]);
        }
    }

     /**
     * @param Recipe $recipe
     * @param array $images
     * @return void
     */
    public function uploadImages(Recipe $recipe, array $requestData = []): void
    {
        $wallPaper = Arr::get($requestData, 'wallpaper');
        if ($wallPaper instanceof UploadedFile) {
            if ($recipe->wallpaper) {
                Storage::disk('public')->delete($recipe->wallpaper);
            }

            $recipe->update(['wallpaper' => Storage::disk('public')->put('recipe', $wallPaper)]);
        }

        foreach (range(1, 4) as $keyImage) {
            $image = Arr::get($requestData, "image_{$keyImage}");
            if ($image instanceof UploadedFile) {
                if ($recipe->{"image_{$keyImage}"}) {
                    Storage::disk('public')->delete($recipe->{"image_{$keyImage}"});
                }

                $recipe->update(["image_{$keyImage}" => Storage::disk('public')->put('recipe', $image)]);
            }
        }
    }

}
