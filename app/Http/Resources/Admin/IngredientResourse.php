<?php

namespace App\Http\Resources\Admin;

use App\Models\IngredientRecipe;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResourse extends JsonResource
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
            'name' => $this->name,
            'quantity' => $this->whenPivotLoaded(IngredientRecipe::class, function() {
                return $this->pivot->quantity;
            }),
            'unit_measure' => $this->whenPivotLoaded(IngredientRecipe::class, function() {
                return $this->pivot->unit_measure;
            }),
            'nutritional' => new NutricionalResourse($this->nutritional),
            'url_image' => $this->image->url
        ];
    }
}
