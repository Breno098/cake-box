<?php

namespace App\Services\Admin;

use App\Models\Ingredient;
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
        $recipe = Recipe::create($requestData);

        // $this->uploadImages($recipe, $requestData);

        return $recipe;
    }

   /**
     * @param Recipe $recipe
     * @param array $requestData
     * @return Recipe
     */
    public function update(Recipe $recipe, array $requestData = []): Recipe
    {
        $recipe->update($requestData);

        // $this->uploadImages($recipe, $requestData);

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
