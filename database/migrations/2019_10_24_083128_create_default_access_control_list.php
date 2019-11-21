<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Authentication\Models\ACL\AccessControlAction;
use Rulla\Authentication\Models\ACL\AccessControlTarget;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\Groups\Group;

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
                'action' => AccessControlAction::DENY(),
            ],
            [
                'group' => 1,
                'action' => AccessControlAction::ALLOW(),
            ],
        ];

        AccessControlList::create([
            'system' => true,
            'priority' => 100000,
            'data' => [
                [
                    'target' => [AuthenticationSource::class, null],
                    'rules' => $adminOnlyRules,
                ],
                [
                    'target' => [Group::class, 'edit'],
                    'rules' => $adminOnlyRules,
                ],
                [
                    'target' => [AccessControlList::class, 'edit'],
                    'rules' => $adminOnlyRules,
                ],
            ],
        ]);

        AccessControlList::create([
            'system' => true,
            'priority' => -100000,
            'data' => [
                [
                    'target' => [null, null],
                    'rules' => [
                        [
                            'action' => AccessControlAction::ALLOW(),
                        ],
                    ],
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
