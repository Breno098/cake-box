<?php

namespace App\Http\Resources\Admin\Post;

use App\Http\Resources\Admin\ImageResource;
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
            'creator' => new CreatorResourse($this->creator),
            'images' => ImageResource::collection($this->images)
        ];
    }
}
