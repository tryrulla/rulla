<?php

namespace Rulla\Authentication;

use Illuminate\Support\Collection;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Providers\AuthenticationProvider;
use Rulla\Authentication\Providers\OpenIdAuthenticationProvider;
use Rulla\Authentication\Providers\PasswordAuthenticationProvider;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;
use Rulla\Authentication\Providers\SocialAuthenticationProvider;

class AuthenticationManager
{
    /** @var array */
    private $providerClasses = [
        LocalAuthenticationProvider::class,
        OpenIdAuthenticationProvider::class,
    ];

    /** @var Collection */
    private $providers = [];

    private function boot()
    {
        if ($this->providers) {
            return;
        }

        $this->providers = AuthenticationSource::all()
            ->filter(function (AuthenticationSource $source) {
                return in_array($source->type, $this->providerClasses);
            })
            ->map(function (AuthenticationSource $source) {
                $class = $source->type;
                return new $class($source->id, $source->name, $source->options);
            });
    }

    /**
     * @return Collection
     */
    public function getProviders(): Collection
    {
        $this->boot();
        return $this->providers;
    }

    /**
     * @return Collection
     */
    public function getPasswordProviders(): Collection
    {
        return $this->getProviders()
            ->filter(function ($it) {
                return $it instanceof PasswordAuthenticationProvider;
            });
    }

    /**
     * @return Collection
     */
    public function getSocialProviders(): Collection
    {
        return $this->getProviders()
            ->filter(function ($it) {
                return $it instanceof SocialAuthenticationProvider;
            });
    }

    /**
     * @param int $id
     * @return AuthenticationProvider|null
     */
    public function getProvider(int $id): ?AuthenticationProvider
    {
        return $this->getProviders()
            ->filter(function (AuthenticationProvider $it) use ($id) {
                return $it->getId() === $id;
            })
            ->first();
    }
}
