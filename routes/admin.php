<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Auth\PasswordSendLinkController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\RecipeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/auth/sign-in');
Route::redirect('/admin', '/admin/auth/sign-in');

Route::middleware('guest:admin')
    ->get('admin/auth/sign-in', [AuthController::class, 'form'])
    ->name('admin.auth.sign-in');

Route::middleware('guest:admin')
    ->post('admin/auth/login', [AuthController::class, 'login'])
    ->name('admin.auth.login');

Route::middleware('guest:admin')
    ->get('admin/auth/forgot-password', [PasswordSendLinkController::class, 'form'])
    ->name('admin.auth.forgot-password-form');

Route::middleware('guest:admin')
    ->post('admin/auth/forgot-password-send-link', [PasswordSendLinkController::class, 'sendLink'])
    ->name('admin.auth.forgot-password-send-link');

Route::middleware('guest:admin')
    ->post('admin/auth/reset-password', [PasswordResetController::class, 'reset'])
    ->name('admin.auth.password.reset');

Route::middleware('auth:admin')
    ->post('admin/auth/logout', [AuthController::class, 'logout'])
    ->name('admin.auth.logout');

Route::middleware('guest:admin')
    ->get('admin/auth/reset-password/{token}', [PasswordResetController::class, 'form'])
    ->name('admin.password.reset');

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::resource('recipe', RecipeController::class);
        Route::resource('ingredient', IngredientController::class);

        Route::get('recipe/{recipe}/ingredient', [RecipeController::class, 'indexIngredient'])->name('recipe.ingredient.index');
        Route::post('recipe/{recipe}/ingredient/{ingredient}', [RecipeController::class, 'attachIngredient'])->name('recipe.ingredient.attach');
        Route::put('recipe/{recipe}/ingredient/{ingredient}', [RecipeController::class, 'updateIngredient'])->name('recipe.ingredient.update');
        Route::delete('recipe/{recipe}/ingredient/{ingredient}', [RecipeController::class, 'detachIngredient'])->name('recipe.ingredient.detach');
    });
