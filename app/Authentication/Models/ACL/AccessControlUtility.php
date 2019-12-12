<?php

namespace Rulla\Authentication\Models\ACL;

use Rulla\Authentication\Models\User;

class AccessControlUtility
{

    public static function can(?User $user, string $targetClass, string $targetAction, array $ruleIds): bool
    {
        $rules = AccessControlCacher::getRuleSet($ruleIds);
        $lists = AccessControlCacher::getListForAction($rules, $targetClass, AccessControlAction::make($targetAction)->getName());
        dd($lists);
    }

    public static function defaultRuleIds(): array
    {
        // TODO
        return AccessControlList::pluck('id')
            ->toArray();
    }

}
