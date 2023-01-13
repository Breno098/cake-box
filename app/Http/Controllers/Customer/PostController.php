<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Home\PostResourse;
use App\Models\Post;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        return inertia('Customer/Post/Show', [
            'post' => new PostResourse($post)
        ]);
    }

    /**
     * @param Post $post
     * @return void
     */
    public function toogleLike(Post $post)
    {
        if ($post->likesByAuthUser()->exists()) {
            $post->dislike(auth()->user());
        } else {
            $post->toLike(auth()->user());
        }
    }

    /**
     * @param Post $post
     * @return void
     */
    public function toogleSave(Post $post)
    {
        if ($post->savesByAuthUser()->exists()) {
            $post->notSave(auth()->user());
        } else {
            $post->toSave(auth()->user());
        }
    }
}
