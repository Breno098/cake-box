<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\RecipeResourse;
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
        $recipes = Recipe::orderBy('rating', 'desc')->limit(4)->get();

        return Inertia::render('Customer/Dashboard', [
            'recipes' => RecipeResourse::collection($recipes)
        ]);
    }
}
