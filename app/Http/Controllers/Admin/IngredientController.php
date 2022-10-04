<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Http\Requests\Admin\Ingredient\IngredientStoreRequest;
use App\Http\Requests\Admin\Ingredient\IngredientUpdateRequest;
use App\Http\Resources\Admin\IngredientResourse;
use App\Services\Admin\IngredientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IngredientController extends Controller
{
    /**
     * @var IngredientService
     */
    protected IngredientService $ingredientService;

    /**
     * @param IngredientService $ingredientService
     */
    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $ingredients = $this->ingredientService->index($request->all());

        return Inertia::render('Admin/Ingredient/Index', [
            'ingredients' => IngredientResourse::collection($ingredients)
        ]);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Ingredient/Edit');
    }

    /**
     * @param IngredientStoreRequest $ingredientStoreRequest
     * @return IngredientResourse
     */
    public function store(IngredientStoreRequest $ingredientStoreRequest): IngredientResourse
    {
        $ingredient = $this->ingredientService->store($ingredientStoreRequest->validated());

        return new IngredientResourse($ingredient);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    public function edit(Ingredient $ingredient): Response
    {
        return Inertia::render('Admin/Ingredient/Edit', [
            'recipe' => new IngredientResourse($ingredient)
        ]);
    }

    /**
     * @param IngredientUpdateRequest $ingredientUpdateRequest
     * @param Ingredient $ingredient
     * @return IngredientResourse
     */
    public function update(IngredientUpdateRequest $ingredientUpdateRequest, Ingredient $ingredient): IngredientResourse
    {
        $ingredient = $this->ingredientService->update($ingredient, $ingredientUpdateRequest->validated());

        return new IngredientResourse($ingredient);
    }

    /**
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $this->ingredientService->delete($ingredient);

        return redirect()->route('admin.ingredient.index');
    }
}
