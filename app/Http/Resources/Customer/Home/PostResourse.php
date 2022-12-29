<?php

namespace App\Http\Resources\Customer\Home;

use App\Http\Resources\Customer\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResourse extends JsonResource
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
            'link_video' => $this->link_video,
            'created_by' => $this->created_by,
            'images' => ImageResource::collection($this->images)
        ];
    }
}
