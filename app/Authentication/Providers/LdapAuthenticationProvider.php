<?php

namespace Rulla\Authentication\Providers;

use Adldap\Adldap;
use Adldap\Connections\ProviderInterface;
use Adldap\Models\User as AdldapUser;
use Rulla\Authentication\Models\User;

class LdapAuthenticationProvider extends PasswordAuthenticationProvider
{
    /** @var array */
    private $ldapConfig;

    /** @var string */
    private $emailAttribute;

    /** @var array */
    private $rawFilters;

    /** @var ProviderInterface */
    private $connection;

    /**
     * LdapAuthenticationProvider constructor.
     * @param int $id
     * @param string $name
     * @param object $options
     */
    public function __construct(int $id, string $name, $options)
    {
        parent::__construct($id, $name, $options);

        $this->emailAttribute = $options->emailAttribute ?? 'userPrincipalName';
        $this->rawFilters = $options->rawFilters ?? [];
        $this->ldapConfig = (array) $options->adldapConfig;
    }

    private function openConnection()
    {
        if ($this->connection) {
            return;
        }

        $ldap = new Adldap;
        $ldap->addProvider($this->ldapConfig);
        $this->connection = $ldap->connect();
    }

    function findUser(string $email, string $password): ?User
    {
        $this->openConnection();
        $connection = $this->connection;

        if (!$connection->auth()->attempt($email, $password)) {
            return null;
        }

        /** @var AdldapUser $ldapUser    */
        $ldapUser = $connection->search()
            ->users()
            ->rawFilter($this->rawFilters)
            ->findBy($this->emailAttribute, $email);

        if (!$ldapUser) {
            return null;
        }

        $ldapEmail = $ldapUser->getAttribute($this->emailAttribute);

        if (is_array($ldapEmail)) {
            if (sizeof($ldapEmail) < 1) {
                return null;
            }

            $ldapEmail = $ldapEmail[0];
        }

        return User::updateOrCreate(
            [
                'email' => $ldapEmail,
            ],
            [
                'name' => $ldapUser->getName(),
                'email' => $ldapEmail,
                'email_verified_at' => now(),
                'password' => '',
            ]
        );
    }
}
