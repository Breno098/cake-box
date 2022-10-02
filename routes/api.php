<?php

use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\RecipeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('recipe', RecipeController::class);
Route::apiResource('ingredient', IngredientController::class);

