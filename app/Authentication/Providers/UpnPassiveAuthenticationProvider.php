<?php

namespace Rulla\Authentication\Providers;

use Illuminate\Http\Request;
use Rulla\Authentication\Models\User;

/**
 * Allows users to log in using proxy auth using UPN from AD. Designed for one specific use case only.
 */
class UpnPassiveAuthenticationProvider extends PassiveAuthenticationProvider
{
    protected function tryFindUser(Request $request): ?User
    {
        $upn = getenv('upn');
        if ($upn) {
            $email = $upn;
            $emailWithoutDomain = strtolower(explode('@', $email)[0]);
            $realName = ucwords(str_replace('.', ' ', $emailWithoutDomain));

            return User::firstOrCreate([
                'email' => $email,
            ], [
                'email' => $email,
                'email_verified_at' => now(),
                'name' => $realName,
                'password' => '',
            ]);
        }

        return null;
    }
}
