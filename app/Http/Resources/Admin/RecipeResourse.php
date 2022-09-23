<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'title' => $this->title,
            'description' => $this->description,
            'info' => $this->info,
            'difficulty' => $this->difficulty,
            'time_to_cook' => $this->time_to_cook,
            'time_to_prepare' => $this->time_to_prepare,
            'rating' => $this->rating,
            'yield_quantity' => $this->yield_quantity,
            'yield_unit_measure' => $this->yield_unit_measure,
            'ingredients' => IngredientResourse::collection($this->ingredients),
            'directions' => DirectionResourse::collection($this->directions),
        ];
    }
}
