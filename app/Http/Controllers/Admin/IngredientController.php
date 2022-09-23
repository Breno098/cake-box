<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Http\Requests\Admin\Ingredient\IngredientStoreRequest;
use App\Http\Requests\Admin\Ingredient\IngredientUpdateRequest;
use App\Http\Resources\Admin\IngredientResourse;
use App\Services\Admin\IngredientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $ingredients = $this->ingredientService->index($request->all());

        return IngredientResourse::collection($ingredients);
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
     * @return IngredientResourse
     */
    public function show(Ingredient $ingredient): IngredientResourse
    {
        return new IngredientResourse($ingredient);
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
     * @return JsonResponse
     */
    public function destroy(Ingredient $ingredient): JsonResponse
    {
        $deleted = $this->ingredientService->delete($ingredient);

        return response()->json([
            'deleted' => $deleted
        ]);
    }
}
