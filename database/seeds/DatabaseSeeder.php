<?php

use Illuminate\Database\Seeder;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        AuthenticationSource::create([
            'name' => 'Rulla Local Account',
            'type' => LocalAuthenticationProvider::class,
        ]);

        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@example.org'
        ]);

        // $this->call(UsersTableSeeder::class);
    }
}
