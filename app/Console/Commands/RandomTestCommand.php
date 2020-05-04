<?php

namespace Rulla\Console\Commands;

use Illuminate\Console\Command;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Models\ACL\AccessControlList;

class RandomTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rulla:random-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $user = User::find(1);
        dd($user->can('update', AccessControlList::find(1)));
    }
}
