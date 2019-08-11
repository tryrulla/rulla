<?php

namespace Rulla\Authentication\Providers;

use Symfony\Component\HttpFoundation\Response;

abstract class SocialAuthenticationProvider extends AuthenticationProvider
{
    abstract function redirect(): Response;
}
