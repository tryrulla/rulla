<?php

namespace Rulla\Authentication\Providers;

use Rulla\Console\Commands\ImportUsersCommand;

interface SupportsImport
{
    function importUsers(ImportUsersCommand $command);
}
