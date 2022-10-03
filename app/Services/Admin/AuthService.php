<?php

namespace App\Services\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthService
{
    /**
     * @var string GUARD
     */
    const GUARD = 'admin';

    /**
     * @var string BROKEN
     */
    const BROKEN = 'admins';

    /**
     * @param array $data = []
     * @return void
     */
    public function login(array $data = []): void
    {
        $auth = Auth::guard(self::GUARD)->attempt(Arr::only($data, ['email', 'password']));

        if (!$auth) {
            throw ValidationException::withMessages([
                'email' => 'E-mail ou senha incorretos.',
            ]);
        }

        session()->regenerate();
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Auth::guard(self::GUARD)->logout();

        session()->invalidate();

        session()->regenerateToken();
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function passwordSendLink(string $email): bool
    {
        $status = Password::broker(self::BROKEN)->sendResetLink([
            'email' => $email
        ]);

        return $status == Password::RESET_LINK_SENT;
    }

    public function passwordReset(string $email, string $password, string $password_confirmation, string $token)
    {
        $status = Password::broker(self::BROKEN)->reset([
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $token
            ],
            function ($user, $password){
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                Auth::guard(self::GUARD)->login($user);
            }
        );

        return $status == Password::RESET_LINK_SENT;
    }
}
