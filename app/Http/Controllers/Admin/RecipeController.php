<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recipe\RecipeIndexRequest;
use App\Models\Recipe;
use App\Http\Requests\Admin\Recipe\RecipeStoreRequest;
use App\Http\Requests\Admin\Recipe\RecipeUpdateRequest;
use App\Http\Resources\Admin\RecipeResourse;
use App\Models\Ingredient;
use App\Services\Admin\RecipeService;
use Illuminate\Http\RedirectResponse;
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
    public function index(RecipeIndexRequest $request): Response
    {
        $recipes = $this->recipeService->index(
            $request->filters(),
            $request->rowsPerPage(8),
            $request->orderBy('title'),
            $request->sort()
        );

        return Inertia::render('Admin/Recipe/Index', [
            'recipes' => RecipeResourse::collection($recipes),
            'query' => $request->dataQuery(),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        $optionsIngredients = Ingredient::orderBy('name')->get();

        return Inertia::render('Admin/Recipe/Create', [
            'ingredients' => $optionsIngredients
        ]);
    }

    /**
     * @param RecipeStoreRequest $recipeStoreRequest
     * @return RedirectResponse
     */
    public function store(RecipeStoreRequest $recipeStoreRequest): RedirectResponse
    {
        $recipe = $this->recipeService->store($recipeStoreRequest->validated());

        return redirect()->route('admin.recipe.edit', $recipe);
    }

    /**
     * @param Recipe $recipe
     * @return Response
     */
    public function edit(Recipe $recipe): Response
    {
        return Inertia::render('Admin/Recipe/Edit/Index', [
            'recipe' => new RecipeResourse($recipe),
        ]);
    }

    /**
     * @param RecipeUpdateRequest $recipeUpdateRequest
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(RecipeUpdateRequest $recipeUpdateRequest, Recipe $recipe): RedirectResponse
    {
        $recipe = $this->recipeService->update($recipe, $recipeUpdateRequest->validated());

        return redirect()->route('admin.recipe.edit', $recipe);
    }

    /**
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $this->recipeService->delete($recipe);

        return redirect()->route('admin.recipe.index');
    }
}
