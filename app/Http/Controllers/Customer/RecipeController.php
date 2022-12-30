<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Recipe\RecipeIndexRequest;
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
    public function index(RecipeIndexRequest $request): Response
    {
        $recipes = $this->recipeService->index(
            $request->filters(),
            $request->rowsPerPage(),
            $request->orderBy('created_at'),
            $request->sort('desc')
        );

        return Inertia::render('Customer/Recipe/Index', [
            'recipes' => RecipeResourse::collection($recipes),
            'query' => $request->dataQuery(),
        ]);
    }
}
