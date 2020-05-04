<?php

use Illuminate\Database\Migrations\Migration;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Authentication\Models\ACL\AccessControlResult;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\Groups\Group;
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
        $adminOnlyRules = [
            [
                'group' => 1,
                'action' => AccessControlResult::ALLOW(),
            ],
            [
                'action' => AccessControlResult::DENY(),
            ],
        ];

        AccessControlList::create([
            'system' => true,
            'data' => [
                [
                    'target' => [AuthenticationSource::class, null],
                    'rules' => $adminOnlyRules,
                ],
                [
                    'target' => [Group::class, AccessControlAction::EDIT()],
                    'rules' => $adminOnlyRules,
                ],
                [
                    'target' => [AccessControlList::class, AccessControlAction::EDIT()],
                    'rules' => $adminOnlyRules,
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
