<?php

namespace App\Services\Customer;

use App\Models\Post;
use App\Http\Resources\Customer\Home\PostResourse;
use App\Http\Resources\Customer\Home\RecipeResourse;
use App\Models\Recipe;

class FeedService
{
    /**
     * @return array
     */
    public function index(): array
    {
        $feed = [];

        $postCount = 0;
        $recipeCount = 0;

        $timesLimit = 5;
        $times = 0;

        $postsForFeed = Post::orderByDesc('created_at')->limit(3)->offset($postCount)->get();

        while ($times < $timesLimit && $postsForFeed->count() > 0) {
            $times++;

            foreach ($postsForFeed as $postForFeed) {
                $postCount++;
                $feed[] = new PostResourse($postForFeed);
            }

            $recipesForFeed = Recipe::orderByDesc('created_at')->limit(1)->offset($recipeCount)->get();

            foreach ($recipesForFeed as $recipeForFeed) {
                $recipeCount++;
                $feed[] = new RecipeResourse($recipeForFeed);
            }

            $postsForFeed = Post::orderByDesc('created_at')->limit(3)->offset($postCount)->get();
        }

        return $feed;
    }
}
