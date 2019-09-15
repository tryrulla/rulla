<?php

namespace Rulla\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Rulla\Authentication\AuthenticationManager;
use Rulla\Authentication\Providers\PassiveAuthenticationProvider;

class Authenticate extends Middleware
{
    /** @var AuthenticationManager */
    private $authenticationManager;

    public function __construct(Auth $auth, AuthenticationManager $authenticationManager)
    {
        parent::__construct($auth);
        $this->authenticationManager = $authenticationManager;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            if ($this->authenticationManager->getPassiveProviders()
                ->filter(function (PassiveAuthenticationProvider $provider) use ($request) {
                    return $provider->tryAuthenticate($request);
                })
                ->isEmpty()) {
                throw $e;
            }
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
