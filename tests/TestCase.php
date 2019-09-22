<?php

namespace Tests;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Rulla\Authentication\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    /** @var User|null */
    protected $user;

    public function loginWithFakeUser()
    {
        if (!$this->user) {
            $this->user = User::firstOrCreate([
                'id' => 1,
            ], [
                'name' => 'User 1',
                'email' => 'rulla-user-1@example.org',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        $this->be($this->user);
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }
}
