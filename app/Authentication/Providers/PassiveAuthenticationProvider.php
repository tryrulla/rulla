<?php

namespace Rulla\Authentication\Providers;

use Auth;
use Illuminate\Http\Request;
use Rulla\Authentication\Models\User;
use Symfony\Component\HttpFoundation\Response;

abstract class PassiveAuthenticationProvider extends AuthenticationProvider
{
    public abstract function tryFindUser(Request $request): ?User;

    /**
     * @param Request $request
     * @return bool
     */
    public function tryAuthenticate(Request $request)
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
