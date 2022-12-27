<?php

namespace App\Http\Resources\Admin;

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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'info' => $this->info,
            'difficulty' => $this->difficulty,
            'time_to_cook' => $this->time_to_cook,
            'time_to_prepare' => $this->time_to_prepare,
            'rating' => $this->rating,
            'yield_quantity' => $this->yield_quantity,
            'yield_unit_measure' => $this->yield_unit_measure,
            'wallpaper' => $this->when($this->wallpaper, Storage::url($this->wallpaper)),
            'image_1' => $this->when($this->image_1, Storage::url($this->image_1)),
            'image_2' => $this->when($this->image_2, Storage::url($this->image_2)),
            'image_3' => $this->when($this->image_3, Storage::url($this->image_3)),
            'image_4' => $this->when($this->image_4, Storage::url($this->image_4)),
            'image_5' => $this->when($this->image_5, Storage::url($this->image_5)),
            'image_6' => $this->when($this->image_6, Storage::url($this->image_6)),
            // 'ingredients' => IngredientResourse::collection($this->ingredients),
            // 'directions' => DirectionResourse::collection($this->directions),
        ];
    }
}
