<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recipe\RecipeAttachIngredientRequest;
use App\Models\Recipe;
use App\Http\Resources\Admin\IngredientResourse;
use App\Http\Resources\Admin\RecipeResourse;
use App\Models\Ingredient;
use App\Services\Admin\RecipeIngredientService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RecipeIngredientController extends Controller
{
    /**
     * @var RecipeIngredientService
     */
    protected RecipeIngredientService $recipeIngredientService;

    /**
     * @param RecipeIngredientService $recipeIngredientService
     */
    public function __construct(RecipeIngredientService $recipeIngredientService)
    {
        $this->recipeIngredientService = $recipeIngredientService;
    }

    /**
     * @param Recipe $recipe
     * @return Response
     */
    public function index(Recipe $recipe): Response
    {
        $optionsIngredients = Ingredient::whereNotIn('id', $recipe->ingredients()->allRelatedIds())->orderBy('name')->get();

        return Inertia::render('Admin/Recipe/Tabs/Ingredients', [
            'recipe' => new RecipeResourse($recipe),
            'ingredients' => IngredientResourse::collection($recipe->ingredients),
            'optionsIngredients' => $optionsIngredients
        ]);
    }

    /**
     * @param RecipeAttachIngredientRequest $request,
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function attach(RecipeAttachIngredientRequest $request, Recipe $recipe, Ingredient $ingredient): RedirectResponse
    {
        $this->recipeIngredientService->attach($recipe, $ingredient, $request->validated());

        return redirect()->route('admin.recipe.ingredient.index', $recipe);
    }

    /**
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function detach(Recipe $recipe, Ingredient $ingredient): RedirectResponse
    {
        $this->recipeIngredientService->detach($recipe, $ingredient);

        return redirect()->route('admin.recipe.ingredient.index', $recipe);
    }

    /**
     * @param RecipeAttachIngredientRequest $request,
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function update(RecipeAttachIngredientRequest $request, Recipe $recipe, Ingredient $ingredient): RedirectResponse
    {
        $this->recipeIngredientService->update($recipe, $ingredient, $request->validated());

        return redirect()->route('admin.recipe.ingredient.index', $recipe);
    }
}
