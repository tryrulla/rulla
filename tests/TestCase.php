<?php

namespace Tests;

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

    public function login()
    {
        if (!$this->user) {
            $this->user = factory(User::class)->create();
        }

        $this->be($this->user);
    }
}
