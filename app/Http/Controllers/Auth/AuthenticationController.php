<?php

namespace Rulla\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Rulla\Authentication\AuthenticationManager;
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

    public function index()
    {
        return view('authentication.auth');
    }

    public function login(Request $request)
    {
        $providerId = $request->validate([
            'provider' => 'required|exists:authentication_sources,id',
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

        if (!$provider) {
            return abort(404, 'Provider not found');
        }

        if ($actualProvider instanceof SocialAuthenticationProvider) {
            return $actualProvider->redirect();
        }

        return view('authentication.auth', ['selectedProvider' => $actualProvider->getId()]);
    }

    public function callback(Request $request, int $provider)
    {
        $actualProvider = $this->authenticationManager->getProvider($provider);

        if (!$provider) {
            return abort(404, 'Provider not found');
        }

        return $actualProvider->authenticate($request);
    }
}
