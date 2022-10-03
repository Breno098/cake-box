<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Admin\AuthService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return Response
     */
    public function form(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('admin.auth.forgot-password-form'),
            'status' => session('status'),
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $responseLogin = $this->authService->login(
            $request->validated()
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        $this->authService->logout();

        return redirect('/');
    }
}
