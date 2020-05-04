<?php

namespace Rulla\Console\Commands;

use Illuminate\Console\Command;
use Rulla\Authentication\Models\User;

class AddToGroupCommand extends Command
{
    protected $signature = 'rulla:user:add-to-group {user} {group}';

    protected $description = 'Adds the specified user to the specified group';

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
        $user = User::findOrFail($this->argument('user'));
        $user->setGroups(array_merge($user->getGroupIds(), [$this->argument('group')]));
        $user->saveAllChanges();
    }
}
