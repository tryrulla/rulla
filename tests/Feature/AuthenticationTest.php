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
}
