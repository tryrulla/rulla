<?php

namespace Rulla\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Rulla\Authentication\AuthenticationManager;
use Rulla\Authentication\Providers\PassiveAuthenticationProvider;
use Rulla\Authentication\Providers\PasswordAuthenticationProvider;
use Rulla\Authentication\Providers\SocialAuthenticationProvider;
use Rulla\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    /** @var AuthenticationManager */
    private $authenticationManager;

    public function __construct(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    public function index(Request $request)
    {
        if ($this->authenticationManager->getPassiveProviders()
            ->filter(function (PassiveAuthenticationProvider $provider) {
                return $provider->useLogin();
            })
            ->filter(function (PassiveAuthenticationProvider $provider) use ($request) {
                return $provider->tryAuthenticate($request);
            })
            ->isNotEmpty()) {
            return redirect()
                ->intended('/');
        }

        $socialProviders = $this->authenticationManager->getSocialProviders()
            ->filter(function (SocialAuthenticationProvider $provider) {
                return $provider->useLogin();
            });

        $passwordProviders = $this->authenticationManager->getSocialProviders()
            ->filter(function (PasswordAuthenticationProvider $provider) {
                return $provider->useLogin();
            });

        if ($socialProviders->isEmpty() && $passwordProviders->isEmpty()) {
            return view('general.message', ['message' => __('auth.no-providers')]);
        }

        return view('authentication.auth', collect('socialProviders', 'passwordProviders'));
    }

    public function login(Request $request)
    {
        $providerId = $request->validate([
            'provider' => ['required', Rule::exists('authentication_sources', 'id')->where('use_login', true)],
        ])['provider'];

        $provider = $this->authenticationManager->getProvider($providerId);

        if (!$provider) {
            return abort(404, 'Provider not found');
        }

        return $provider->authenticate($request);
    }

    public function showProvider(int $provider)
    {
        $actualProvider = $this->authenticationManager->getProvider($provider);

        if (!$actualProvider) {
            return abort(404, 'Provider not found');
        }

        if (!$actualProvider->useLogin()) {
            return view('general.message', ['message' => __('auth.no-login-on-provider')]);
        }

        if ($actualProvider instanceof SocialAuthenticationProvider) {
            return $actualProvider->redirect();
        }

        return view('authentication.auth', ['selectedProvider' => $actualProvider->getId()]);
    }

    public function callback(Request $request, int $provider)
    {
        $actualProvider = $this->authenticationManager->getProvider($provider);

        if (!$actualProvider) {
            return abort(404, 'Provider not found');
        }

        if (!$actualProvider->useLogin()) {
            return view('general.message', ['message' => __('auth.no-login-on-provider')]);
        }

        return $actualProvider->authenticate($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/')
            ->with('notice', __('auth.logout'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
