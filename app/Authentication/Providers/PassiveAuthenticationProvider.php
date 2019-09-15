<?php

namespace Rulla\Authentication\Providers;

use Auth;
use Illuminate\Http\Request;
use Rulla\Authentication\Models\User;
use Symfony\Component\HttpFoundation\Response;

abstract class PassiveAuthenticationProvider extends AuthenticationProvider
{
    protected abstract function tryFindUser(Request $request): ?User;

    public function tryAuthenticate(Request $request): boolean
    {
        $user = $this->tryFindUser($request);

        if ($user) {
            Auth::login($user);
            return true;
        }

        return false;
    }

    public function authenticate(Request $request): Response
    {
        return $this->tryAuthenticate($request)
            ? redirect()->route('home')
            : view('general.message', ['message' => __('auth.passive.no-session')]);
    }
}
