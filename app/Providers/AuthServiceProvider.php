<?php

namespace Rulla\Providers;

use Rulla\Authentication\Models\Groups\Group;
use Rulla\Policies\Authentication\Groups\GroupPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Items\Fields\Field;
use Rulla\Policies\Authentication\ACL\AccessControlListPolicy;
use Rulla\Policies\Items\Fields\FieldPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AccessControlList::class => AccessControlListPolicy::class,
        Field::class => FieldPolicy::class,
        Group::class => GroupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
