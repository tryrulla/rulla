<?php

namespace Rulla\Authentication\Providers;

use Adldap\Adldap;
use Adldap\Connections\ProviderInterface;
use Adldap\Models\User as AdldapUser;
use Rulla\Authentication\Models\User;
use Rulla\Console\Commands\ImportUsersCommand;

class LdapAuthenticationProvider extends PasswordAuthenticationProvider implements SupportsImport
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

        /** @var AdldapUser $ldapUser */
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

    public function importUsers(ImportUsersCommand $command)
    {
        $bar = $command->getOutput()->createProgressBar();
        $bar->setFormat('%message% %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%');

        $bar->setMessage('Connecting to LDAP');
        $bar->display();
        $this->openConnection();
        $connection = $this->connection;

        $bar->setMessage('Retrieving results');
        $bar->display();

        $ldapUsers = $connection->search()
            ->users()
            ->rawFilter($this->rawFilters)
            ->get();

        $bar->setMaxSteps(count($ldapUsers));
        $bar->setFormat('%message% %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%');
        $bar->setMessage('Saving users to database');
        $bar->display();

        foreach ($ldapUsers as $ldapUser) {
            /** @var AdldapUser $ldapUser */

            $ldapEmail = $ldapUser->getAttribute($this->emailAttribute);

            if (is_array($ldapEmail)) {
                if (sizeof($ldapEmail) < 1) {
                    return null;
                }

                $ldapEmail = $ldapEmail[0];
            }

            $user = User::firstOrNew([
                'email' => $ldapEmail,
            ], [
                'email_verified_at' => now(),
                'password' => '',
            ]);

            $user->name = $ldapUser->getName();
            $user->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
