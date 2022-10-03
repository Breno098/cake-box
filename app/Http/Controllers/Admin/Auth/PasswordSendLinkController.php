<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\PasswordSendLinkRequest;
use App\Services\Admin\AuthService;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordSendLinkController extends Controller
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
        return Inertia::render('Admin/Auth/ForgotPassword');
    }

    /**
     * @param PasswordSendLinkRequest $request
     * @return Response
     */
    public function sendLink(PasswordSendLinkRequest $request): Response
    {
        $responseOk = $this->authService->passwordSendLink($request->get('email'));

        if ($responseOk) {
            return Inertia::render('Admin/Auth/ForgotPassword', [
                'status' =>"Email para redefinição enviado para {$request->get('email')}"
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Erro ao enviar email. Tente novamente.',
        ]);
    }
}
