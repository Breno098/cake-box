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
            }, $this->unit_measure),
            'unit_measure' => $this->unit_measure,
            'kcal' => $this->kcal,
            'fat' => $this->fat,
            'saturates' => $this->saturates,
            'carbs' => $this->carbs,
            'sugars' => $this->sugars,
            'fibre' => $this->fibre,
            'protein' => $this->protein,
            'salt' => $this->salt,
            'image' => $this->image,
        ];
    }
}
