<?php

namespace App\Http\Resources\Customer\Home;

use App\Http\Resources\Customer\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecipeResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type_feed' => 'recipe',
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'info' => $this->info,
            'difficulty' => $this->difficulty,
            'time_to_cook' => $this->time_to_cook,
            'time_to_prepare' => $this->time_to_prepare,
            'yield_quantity' => $this->yield_quantity,
            'yield_unit_measure' => $this->yield_unit_measure,
            'wallpaper' => $this->wallpaper,
            'images' => ImageResource::collection($this->images)
        ];
    }
}
