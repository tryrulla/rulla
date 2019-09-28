<?php

namespace Rulla\Authentication\Providers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use League\OAuth2\Client\Provider\GenericProvider;
use Symfony\Component\HttpFoundation\Response;

class OpenIdAuthenticationProvider extends SocialAuthenticationProvider
{
    private $openIdConfiguration = [];

    /** @var GenericProvider */
    private $provider;

    public function __construct(int $id, string $name, $options)
    {
        parent::__construct($id, $name, $options);

        $key = "authentication-openid-$id-configuration";

        $this->openIdConfiguration = Cache::remember($key, 3600, function () use ($options) {
            $client = new Client();
            return json_decode($client->get($options->metadata)->getBody());
        });

        $this->provider = new GenericProvider([
            'clientId' => $this->getOptions()->client_id,
            'clientSecret' => $this->getOptions()->client_secret,
            'redirectUri' => url(route('login.provider.callback', ['provider' => $this->getId()])),
            'urlAuthorize' => $this->openIdConfiguration->authorization_endpoint,
            'urlAccessToken' => $this->openIdConfiguration->token_endpoint,
            'urlResourceOwnerDetails' => $this->openIdConfiguration->userinfo_endpoint,
            'scopes' => $this->getOptions()->scope
        ]);
    }

    function authenticate(Request $request): Response
    {
        $state = $request->session()->get('openid_' . $this->getId() . '_state');

        if (!$state || $state !== $request->get('state', '')) {
            return abort('Invalid state');
        }

        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $request->get('code'),
        ]);

        \Log::debug('Access Token: ' . $accessToken->getToken());
        \Log::debug('Refresh Token: ' . $accessToken->getRefreshToken());
        \Log::debug('Expired in: ' . $accessToken->getExpires());
        \Log::debug('Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired'));

        dd($accessToken);

        $resourceOwner = $this->provider->getResourceOwner($accessToken);

        dd($resourceOwner->toArray());
        // TODO: Implement authenticate() method.
    }

    function redirect(): Response
    {
        $authorizationUrl = $this->provider->getAuthorizationUrl();

        session()->put('openid_' . $this->getId() . '_state', $this->provider->getState());
        return redirect($authorizationUrl);
    }
}
