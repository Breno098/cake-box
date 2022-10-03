<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Http\Requests\Admin\Recipe\RecipeStoreRequest;
use App\Http\Requests\Admin\Recipe\RecipeUpdateRequest;
use App\Http\Resources\Admin\RecipeResourse;
use App\Services\Admin\RecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $recipes = $this->recipeService->index($request->all());

        return Inertia::render('Admin/Recipe/Index', [
            'recipes' => RecipeResourse::collection($recipes)
        ]);
    }

    /**
     * @param RecipeStoreRequest $recipeStoreRequest
     * @return RecipeResourse
     */
    public function store(RecipeStoreRequest $recipeStoreRequest): RecipeResourse
    {
        $recipe = $this->recipeService->store($recipeStoreRequest->validated());

        return new RecipeResourse($recipe);
    }

    /**
     * @param Recipe $recipe
     * @return Response
     */
    public function edit(Recipe $recipe): Response
    {
        return Inertia::render('Admin/Recipe/Edit', [
            'recipe' => $recipe
        ]);
    }

    /**
     * @param RecipeUpdateRequest $recipeUpdateRequest
     * @param Recipe $recipe
     * @return RecipeResourse
     */
    public function update(RecipeUpdateRequest $recipeUpdateRequest, Recipe $recipe): RecipeResourse
    {
        $recipe = $this->recipeService->update($recipe, $recipeUpdateRequest->validated());

        return new RecipeResourse($recipe);
    }

    /**
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function destroy(Recipe $recipe): JsonResponse
    {
        $deleted = $this->recipeService->delete($recipe);

        return response()->json([
            'deleted' => $deleted
        ]);
    }
}
