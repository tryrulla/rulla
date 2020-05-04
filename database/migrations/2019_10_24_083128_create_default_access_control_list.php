<?php

use Illuminate\Database\Migrations\Migration;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Authentication\Models\ACL\AccessControlResult;
use Rulla\Authentication\Models\ACL\AccessControlAction;

class CreateDefaultAccessControlList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $allowAdminRule = [[
            'group' => 1,
            'result' => AccessControlResult::ALLOW(),
        ]];

        $allowAllRule = [[
            'result' => AccessControlResult::ALLOW(),
        ]];

        $denyAllRule = [[
            'result' => AccessControlResult::DENY(),
        ]];

        AccessControlList::create([
            'title' => 'Allow access to edit authentication-related objects for administrators',
            'system' => true,
            'priority' => 100000,
            'data' => [
                [
                    'target' => [AuthenticationSource::class, AccessControlAction::ANY()],
                    'rules' => $allowAdminRule,
                ],
                [
                    'target' => [Group::class, AccessControlAction::CREATE()],
                    'rules' => $allowAdminRule,
                ],
                [
                    'target' => [Group::class, AccessControlAction::EDIT()],
                    'rules' => $allowAdminRule,
                ],
                [
                    'target' => [AccessControlList::class, AccessControlAction::CREATE()],
                    'rules' => $allowAdminRule,
                ],
                [
                    'target' => [AccessControlList::class, AccessControlAction::EDIT()],
                    'rules' => $allowAdminRule,
                ],
            ],
        ]);

        AccessControlList::create([
            'title' => 'Deny access to edit authentication-related objects if not explicitly allowed',
            'system' => true,
            'priority' => -99999,
            'data' => [
                [
                    'target' => [AuthenticationSource::class, AccessControlAction::ANY()],
                    'rules' => $denyAllRule,
                ],
                [
                    'target' => [Group::class, AccessControlAction::CREATE()],
                    'rules' => $denyAllRule,
                ],
                [
                    'target' => [Group::class, AccessControlAction::EDIT()],
                    'rules' => $denyAllRule,
                ],
                [
                    'target' => [AccessControlList::class, AccessControlAction::CREATE()],
                    'rules' => $denyAllRule,
                ],
                [
                    'target' => [AccessControlList::class, AccessControlAction::EDIT()],
                    'rules' => $denyAllRule,
                ],
            ],
        ]);

        AccessControlList::create([
            'title' => 'Allow all if not explicitly denied',
            'system' => true,
            'priority' => -100000,
            'data' => [
                [
                    'target' => [null, AccessControlAction::ANY()],
                    'rules' => $allowAllRule,
                ],
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        AccessControlList::where('system', true)
            ->delete();
    }
}
