<?php

namespace Rulla\Console\Commands;

use Illuminate\Console\Command;
use Rulla\Authentication\AuthenticationManager;
use Rulla\Authentication\Providers\PasswordAuthenticationProvider;

class TestAuthenticationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rulla:auth:test {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to test an authentication provider';

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
     */
    public function handle(AuthenticationManager $authenticationManager)
    {
        $provider = $authenticationManager->getProvider($this->argument('provider'));

        if (!$provider) {
            $this->error("Authentication provider not found");
            die(1);
        }

        if (!($provider instanceof PasswordAuthenticationProvider)) {
            $this->error("Authentication provider does not support password authentication");
            die(1);
        }

        $this->info("Please enter your credentials for " . $provider->getName());

        $username = $this->ask("Username");
        $password = $this->secret("Password");

        dd($provider->findUser($username, $password));

        return;
    }
}
