<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recipe\Direction\RecipeDirectionStoreRequest;
use App\Http\Requests\Admin\Recipe\Direction\RecipeDirectionUpdateRequest;
use App\Models\Recipe;
use App\Http\Resources\Admin\DirectionResourse;
use App\Http\Resources\Admin\RecipeResourse;
use App\Models\Direction;
use App\Services\Admin\RecipeDirectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RecipeDirectionController extends Controller
{
    /**
     * @var RecipeDirectionService
     */
    protected RecipeDirectionService $recipeDirectionService;

    /**
     * @param RecipeDirectionService $recipeDirectionService
     */
    public function __construct(RecipeDirectionService $recipeDirectionService)
    {
        $this->recipeDirectionService = $recipeDirectionService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Recipe $recipe): Response
    {
        return Inertia::render('Admin/Recipe/Tabs/Directions', [
            'recipe' => new RecipeResourse($recipe),
            'directions' => DirectionResourse::collection($recipe->directions),
        ]);
    }

    /**
     * @param RecipeDirectionStoreRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function store(RecipeDirectionStoreRequest $request, Recipe $recipe): RedirectResponse
    {
        $this->recipeDirectionService->store($recipe, $request->validated());

        return redirect()->route('admin.recipe.direction.index', $recipe);
    }

    /**
     * @param RecipeDirectionUpdateRequest $request
     * @param Recipe $recipe
     * @param Direction $direction
     * @return RedirectResponse
     */
    public function update(RecipeDirectionUpdateRequest $request, Recipe $recipe, Direction $direction): RedirectResponse
    {
        $this->recipeDirectionService->update($recipe, $direction, $request->validated());

        return redirect()->route('admin.recipe.direction.index', $recipe);
    }

     /**
     * @param Recipe $recipe
     * @param Direction $direction
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe, Direction $direction): RedirectResponse
    {
        $this->recipeDirectionService->delete($direction);

        return redirect()->route('admin.recipe.direction.index', $recipe);
    }
}
