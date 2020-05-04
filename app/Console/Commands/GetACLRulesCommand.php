<?php

namespace Rulla\Console\Commands;

use Illuminate\Console\Command;
use Rulla\Authentication\Models\ACL\AccessControlCacher;
use Rulla\Authentication\Models\ACL\AccessControlList;

class GetACLRulesCommand extends Command
{
    protected $signature = 'rulla:acl:get {--id=*} {--a|--all}';
    protected $description = 'Retrieve ACL rules';

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
        $ids = collect()
            ->concat($this->option('id'));

        if ($this->option('all')) {
            $ids = $ids->concat(AccessControlList::all()->pluck('id')->toArray());
        }

        dd(AccessControlCacher::getRuleSet($ids->toArray()));
    }
}
