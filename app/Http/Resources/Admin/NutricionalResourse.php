<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class NutricionalResourse extends JsonResource
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
            'unit_measure' => $this->unit_measure,
            'kcal' => $this->kcal,
            'fat' => $this->fat,
            'saturates' => $this->saturates,
            'carbs' => $this->carbs,
            'sugars' => $this->sugars,
            'fibre' => $this->fibre,
            'protein' => $this->protein,
            'salt' => $this->salt,
        ];
    }
}
