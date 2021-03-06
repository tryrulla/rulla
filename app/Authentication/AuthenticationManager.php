<?php

namespace Rulla\Authentication;

use Illuminate\Support\Collection;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Providers\AuthenticationProvider;
use Rulla\Authentication\Providers\LdapAuthenticationProvider;
use Rulla\Authentication\Providers\OpenIdAuthenticationProvider;
use Rulla\Authentication\Providers\PassiveAuthenticationProvider;
use Rulla\Authentication\Providers\PasswordAuthenticationProvider;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;
use Rulla\Authentication\Providers\SocialAuthenticationProvider;
use Rulla\Authentication\Providers\UpnPassiveAuthenticationProvider;

class AuthenticationManager
{
    /** @var array */
    private $providerClasses = [
        LocalAuthenticationProvider::class,
        OpenIdAuthenticationProvider::class,
        UpnPassiveAuthenticationProvider::class,
    ];

    /** @var Collection */
    private $providers;

    private function boot()
    {
        if ($this->providers) {
            return;
        }

        if (extension_loaded('ldap')) {
            $this->providerClasses[] = LdapAuthenticationProvider::class;
        }

        $this->providers = AuthenticationSource::where('active', true)
            ->get()
            ->filter(function (AuthenticationSource $source) {
                return in_array($source->type, $this->providerClasses);
            })
            ->map(function (AuthenticationSource $source) {
                $class = $source->type;
                return (new $class($source->id, $source->name, $source->options))
                    ->setUseLogin($source->use_login)
                    ->setUseImport($source->use_import);
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
     * @return Collection
     */
    public function getPassiveProviders(): Collection
    {
        return $this->getProviders()
            ->filter(function ($it) {
                return $it instanceof PassiveAuthenticationProvider;
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
