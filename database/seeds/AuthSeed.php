<?php

use Illuminate\Database\Seeder;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;

class AuthSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 10)->create();

        AuthenticationSource::create([
            'name' => 'Rulla Local Account',
            'type' => LocalAuthenticationProvider::class,
            'use_login' => true,
        ]);

        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@example.org'
        ]);

        factory(User::class, 19)->create();
    }
}
