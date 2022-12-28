<?php

namespace App\Services\Admin;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Post[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Post::when(Arr::get($filters, 'title'), function(Builder $builder, $title) {
                return $builder->where('title', 'like', "%{$title}%");
            })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
                return $query->orderBy($orderBy, $sort);
            })
            ->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Post
     */
    public function store(array $requestData = []): Post
    {
        $post = Post::create(array_merge($requestData, [
            'created_by' => auth()->user()->id
        ]));

        $this->updateOrCreateImages($post, Arr::get($requestData, 'images', []));

        return $post;
    }

   /**
     * @param Post $post
     * @param array $requestData
     * @return Post
     */
    public function update(Post $post, array $requestData = []): Post
    {
        $post->update($requestData);

        $this->updateOrCreateImages($post, Arr::get($requestData, 'images', []));

        return $post;
    }

    /**
     * @param Post $post
     * @return boolean|null
     */
    public function delete(Post $post): ?bool
    {
        return $post->delete();
    }

    /**
     * @param Post $post
     * @param array $images
     * @return void
     */
    public function updateOrCreateImages(Post $post, array $images = []): void
    {
        /** Upload new images added */
        collect($images)->filter(function ($image) {
            return Arr::get($image, 'uploadedFile') instanceof UploadedFile;
        })->each(function($image) use ($post) {
            /** @var UploadedFile */
            $uploadedFile = Arr::get($image, 'uploadedFile');

            $post->images()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'path' => Storage::disk('public')->put('posts', $uploadedFile),
                'size' => $uploadedFile->getSize()
            ]);
        });

        /** Destroy images */
        $post->images()
            ->whereNotIn('id', data_get($images, '*.id'))
            ->each(function(Image $image) use ($post){
                $this->deleteImage($post, $image);
            });
    }

      /**
     * @param Post $post
     * @param Image $image
     * @return bool|null
     */
    public function deleteImage(Post $post, Image $image): ?bool
    {
        Storage::disk('public')->delete($image->path);

        return $post->images()->find($image->id)->delete();
    }
}
