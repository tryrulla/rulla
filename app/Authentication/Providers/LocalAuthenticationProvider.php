<?php

namespace Rulla\Authentication\Providers;

use Illuminate\Support\Facades\Hash;
use Rulla\Authentication\Models\User;

/**
 * Authenticates users using an username and password from database
 */
class LocalAuthenticationProvider extends PasswordAuthenticationProvider
{
    public function findUser(string $email, string $password): ?User
    {
        return User::where([
            'email' => $email,
            'password' => Hash::make($password),
        ])->first();
    }
}
