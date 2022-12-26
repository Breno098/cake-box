<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ingredient\IngredientIndexRequest;
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
     * @param IngredientIndexRequest $request
     * @return Response
     */
    public function index(IngredientIndexRequest $request): Response
    {
        $ingredients = $this->ingredientService->index(
            $request->filters(),
            $request->rowsPerPage(),
            $request->orderBy('name'),
            $request->sort()
        );

        return Inertia::render('Admin/Ingredient/Index', [
            'ingredients' => IngredientResourse::collection($ingredients),
            'query' => $request->dataQuery(),
        ]);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Ingredient/Create');
    }

    /**
     * @param IngredientStoreRequest $ingredientStoreRequest
     * @return RedirectResponse
     */
    public function store(IngredientStoreRequest $ingredientStoreRequest): RedirectResponse
    {
        $ingredient = $this->ingredientService->store($ingredientStoreRequest->validated());

        return redirect()->route('admin.ingredient.edit', $ingredient);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    public function edit(Ingredient $ingredient): Response
    {
        return Inertia::render('Admin/Ingredient/Edit', [
            'ingredient' => new IngredientResourse($ingredient)
        ]);
    }

    /**
     * @param IngredientUpdateRequest $ingredientUpdateRequest
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function update(IngredientUpdateRequest $ingredientUpdateRequest, Ingredient $ingredient): RedirectResponse
    {
        $ingredient = $this->ingredientService->update($ingredient, $ingredientUpdateRequest->validated());

        return redirect()->route('admin.ingredient.edit', $ingredient);
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
