<?php

namespace App\Http\Resources\Customer\Home;

use App\Http\Resources\Customer\ImageResource;
use App\Models\Comment;
use App\Models\Post;
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
        /**
         * @var Post $post
         */
        $post = $this->resource;

        return [
            'type_feed' => 'post',
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'link_video' => $post->link_video,
            'created_by' => $post->created_by,
            'images' => ImageResource::collection($post->images),
            'liked' => $post->likesByAuthUser()->exists(),
            'saved' => $post->savesByAuthUser()->exists(),
            'tags'=> $post->tags,
            'comments' => $post->comments->map(function(Comment $comment) {
                return [
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('d/m/Y'),
                    'creator' => $comment->creator->name
                ];
            }),
        ];
    }
}
