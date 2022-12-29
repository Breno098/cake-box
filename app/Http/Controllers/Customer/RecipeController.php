<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Home\RecipeResourse;
use App\Services\Customer\RecipeService;
use Inertia\Inertia;
use Inertia\Response;

class RecipeController extends Controller
{
    /**
     * @var RecipeService
     */
    protected RecipeService $recipeService;

    /**
     * @param RecipeService $recipeService
     */
    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }


    /**
     * @return Response
     */
    public function index(): Response
    {
        $recipes = $this->recipeService->index([], 15, 'created_at', 'desc');

        return Inertia::render('Customer/Recipe/Index', [
            'recipes' => RecipeResourse::collection($recipes),
        ]);
    }
}
