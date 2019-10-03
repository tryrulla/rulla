<?php

namespace Rulla\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Rulla\Authentication\AuthenticationManager;
use Rulla\Authentication\Providers\PasswordAuthenticationProvider;
use Rulla\Authentication\Providers\SupportsImport;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rulla:auth:import {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all users from provider';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param AuthenticationManager $authenticationManager
     * @return mixed
     * @throws Exception
     */
    public function handle(AuthenticationManager $authenticationManager)
    {
        $provider = $authenticationManager->getProvider($this->argument('provider'));

        if (!$provider) {
            throw new Exception("Authentication provider not found");
        }

        if (!($provider instanceof SupportsImport)) {
            throw new Exception("Authentication provider does not support password authentication");
        }


        $provider->importUsers($this);
    }
}
