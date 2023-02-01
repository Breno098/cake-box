<?php

namespace App\Services\Admin;

use App\Models\Image;
use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

        $this->uploadWallpaper($recipe, Arr::get($requestData, 'wallpaper'));

        $this->updateOrCreateImages($recipe, Arr::get($requestData, 'images', []));

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

        $this->uploadWallpaper($recipe, Arr::get($requestData, 'wallpaper'));

        $this->updateOrCreateImages($recipe, Arr::get($requestData, 'images', []));

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
     * @param array $images
     * @return void
     */
    public function updateOrCreateImages(Recipe $recipe, array $images = []): void
    {
        /** Upload new images added */
        collect($images)->filter(function ($image) {
            return Arr::get($image, 'uploadedFile') instanceof UploadedFile;
        })->each(function($image) use ($recipe) {
            /** @var UploadedFile */
            $uploadedFile = Arr::get($image, 'uploadedFile');

            $recipe->images()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'path' => Storage::url(Storage::disk('public')->put('recipes', $uploadedFile)),
                'size' => $uploadedFile->getSize()
            ]);
        });

        /** Destroy images */
        $recipe->images()
            ->whereNotIn('id', data_get($images, '*.id'))
            ->each(fn(Image $image) => $this->deleteImage($recipe, $image));
    }

    /**
     * @param Recipe $recipe
     * @return void
     */
    public function deleteWallpaper(Recipe $recipe): void
    {
        if ($recipe->wallpaper) {
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $recipe->wallpaper));

            $recipe->update(['wallpaper' => null]);
        }
    }

    /**
     * @param Recipe $recipe
     * @param UploadedFile $wallpaper
     * @return void
     */
    public function updateWallpaper(Recipe $recipe, UploadedFile $wallpaper): void
    {
        $this->deleteWallpaper($recipe);
        $recipe->update(['wallpaper' => Storage::url(Storage::disk('public')->put('recipes', $wallpaper))]);
    }

    /**
     * @param Recipe $recipe
     * @param null|string|UploadedFile $wallpaper
     * @return void
     */
    public function uploadWallpaper(Recipe $recipe, null|string|UploadedFile $wallpaper): void
    {
        if (! $wallpaper) {
            $this->deleteWallpaper($recipe);
        } else if ($wallpaper instanceof UploadedFile) {
            $this->updateWallpaper($recipe, $wallpaper);
        }
    }

     /**
     * @param Recipe $recipe
     * @param Image $image
     * @return bool|null
     */
    public function deleteImage(Recipe $recipe, Image $image): bool|null
    {
        Storage::disk('public')->delete(Str::replaceFirst('storage', '', $image->path));

        return $recipe->images()->find($image->id)->delete();
    }
}
