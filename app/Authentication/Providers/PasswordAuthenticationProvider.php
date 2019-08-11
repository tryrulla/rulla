<?php

namespace Rulla\Authentication\Providers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Rulla\Authentication\Models\User;
use Symfony\Component\HttpFoundation\Response;

abstract class PasswordAuthenticationProvider extends AuthenticationProvider
{
    abstract function findUser(string $email, string $password): ?User;

    public function authenticate(Request $request): Response
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($user = $this->findUser($credentials['email'], $credentials['password'])) {
            $this->guard()->login($user, $request->filled('remember'));

            return redirect()
                ->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }
}
