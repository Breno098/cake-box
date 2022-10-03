<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Auth\PasswordSendLinkController;
use App\Http\Controllers\Admin\RecipeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin/auth/sing-in');
Route::redirect('/admin', '/admin/auth/sing-in');

Route::middleware('guest:admin')
    ->get('admin/auth/sing-in', [AuthController::class, 'form'])
    ->name('admin.auth.sing-in');

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
    ->name('password.reset');

Route::get('/admin/home', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.home');


Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::resource('recipe', RecipeController::class);
    });

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// require __DIR__.'/auth.php';
