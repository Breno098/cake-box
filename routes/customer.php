<?php

use App\Http\Controllers\Customer\Auth\AuthController;
use App\Http\Controllers\Customer\Auth\PasswordResetController;
use App\Http\Controllers\Customer\Auth\PasswordSendLinkController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\RecipeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customer/auth/sign-in');
Route::redirect('/customer', '/customer/auth/sign-in');

Route::middleware('guest:customer')
    ->get('customer/auth/sign-in', [AuthController::class, 'form'])
    ->name('customer.auth.sign-in');

Route::middleware('guest:customer')
    ->post('customer/auth/login', [AuthController::class, 'login'])
    ->name('customer.auth.login');

Route::middleware('guest:customer')
    ->get('customer/auth/forgot-password', [PasswordSendLinkController::class, 'form'])
    ->name('customer.auth.forgot-password-form');

Route::middleware('guest:customer')
    ->post('customer/auth/forgot-password-send-link', [PasswordSendLinkController::class, 'sendLink'])
    ->name('customer.auth.forgot-password-send-link');

Route::middleware('guest:customer')
    ->post('customer/auth/reset-password', [PasswordResetController::class, 'reset'])
    ->name('customer.auth.password.reset');

Route::middleware('auth:customer')
    ->post('customer/auth/logout', [AuthController::class, 'logout'])
    ->name('customer.auth.logout');

Route::middleware('guest:customer')
    ->get('customer/auth/reset-password/{token}', [PasswordResetController::class, 'form'])
    ->name('password.reset');

Route::middleware('auth:customer')
    ->prefix('customer')
    ->name('customer.')
    ->group(function() {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('recipe', [RecipeController::class, 'index'])->name('recipe.index');
    });
