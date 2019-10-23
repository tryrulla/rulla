<?php

namespace Rulla\Authentication\Providers;

use Adldap\Adldap;
use Adldap\Connections\ProviderInterface;
use Adldap\Models\Group as AdlapGroup;
use Adldap\Models\User as AdldapUser;
use Exception;
use Rulla\Authentication\Models\User;
use Rulla\Console\Commands\ImportUsersCommand;
use RuntimeException;

class LdapAuthenticationProvider extends PasswordAuthenticationProvider implements SupportsImport
{
    /** @var array */
    private $ldapConfig;

    /** @var string */
    private $emailAttribute;

    /** @var array */
    private $rawFilters;

    /** @var array */
    private $groupSync;

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
        $this->groupSync = collect(($options->groupSync ?? []))
            ->mapWithKeys(function ($value, $key) {
                return [strtolower($key) => $value];
            });
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

        return $this->syncLdapUser($ldapUser);
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
            $this->syncLdapUser($ldapUser);
            $bar->advance();
        }

        $bar->finish();
    }

    private function syncLdapUser(AdldapUser $ldapUser): User
    {
        $ldapEmail = $ldapUser->getAttribute($this->emailAttribute);

        if (is_array($ldapEmail)) {
            if (sizeof($ldapEmail) < 1) {
                throw new RuntimeException("LDAP user missing email");
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

        $ldapGroups = $ldapUser->getGroups([$ldapUser->getSchema()->distinguishedName(), $ldapUser->getSchema()->memberOf()], true)
            ->map(function (AdlapGroup $group) {
                return $group->getDistinguishedName();
            })
            ->unique();

        $allSyncedGroups = $this->groupSync->values();
        $addGroups = $ldapGroups
            ->map(function ($dn) {
                return strtolower($dn);
            })
            ->map(function ($dn) {
                return $this->groupSync->get($dn);
            })
            ->reject(function ($value) {
                return $value === null;
            });

        $newGroups = collect($user->getGroupIds())
            ->reject(function($id) use ($allSyncedGroups) {
                return $allSyncedGroups->contains($id);
            })
            ->merge($addGroups)
            ->toArray();

        try {
            $user->setGroups($newGroups);
        } catch (Exception $e) {
            throw new RuntimeException($e);
        }

        $user->save();
        $user->savePendingChanges();

        return $user;
    }
}
