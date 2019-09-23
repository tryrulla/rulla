<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    public function testRedirectsToAuth()
    {
        $response = $this
            ->get('/');

        $response->assertRedirect('/auth');
    }

    public function testDoesNotRedirectIfSignedIn()
    {
        $this->withoutExceptionHandling();

        $this->login();
        $response = $this
            ->get('/');

        $this->assertFalse($response->isRedirect());
        $response->assertSee($this->user->name);
    }
}
