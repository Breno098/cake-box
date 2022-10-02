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
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->whenPivotLoaded(IngredientRecipe::class, function() {
                return $this->pivot->quantity;
            }),
            'unit_measure' => $this->whenPivotLoaded(IngredientRecipe::class, function() {
                return $this->pivot->unit_measure;
            }),
            'unit_measure' => $this->nutritional->unit_measure,
            'kcal' => $this->nutritional->kcal,
            'fat' => $this->nutritional->fat,
            'saturates' => $this->nutritional->saturates,
            'carbs' => $this->nutritional->carbs,
            'sugars' => $this->nutritional->sugars,
            'fibre' => $this->nutritional->fibre,
            'protein' => $this->nutritional->protein,
            'salt' => $this->nutritional->salt,
            'nutritional' => new NutricionalResourse($this->nutritional),
            'url_image' => $this->image->url,
        ];
    }
}
