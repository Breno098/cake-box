<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Home\PostResourse;
use App\Http\Resources\Customer\Home\RecipeResourse;
use App\Models\Post;
use App\Models\Recipe;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $recipes = Recipe::orderByDesc('wallpaper')->limit(2)->get();

        $posts = Post::limit(3)->get();

        return Inertia::render('Customer/Dashboard', [
            'recipes' => RecipeResourse::collection($recipes),
            'posts' => PostResourse::collection($posts)
        ]);
    }
}
