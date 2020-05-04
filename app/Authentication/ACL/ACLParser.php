<?php

namespace Rulla\Authentication\ACL;

use Rulla\Authentication\Models\User;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Authentication\Models\ACL\AccessControlResult;
use Rulla\Authentication\Models\ACL\AccessControlAction;

class ACLParser
{
    private static function getAclsFor($class, AccessControlAction $action)
    {
        $aclObjects = AccessControlList::defaultRuleList();
        $lists = [];

        foreach ($aclObjects as $acl) {
            /** @var AccessControlList $acl */
            $aclSets = $acl->data;
            foreach ($aclSets as $aclSet) {
                $classMatches = $aclSet->target[0] == null || $aclSet->target[0] == $class;
                $actionMatches = $aclSet->target[1] == null || $action->isEqual($aclSet->target[1]);

                if ($classMatches && $actionMatches) {
                    foreach ($aclSet->rules as $rule) {
                        $lists[] = $rule;
                    }
                }
            }
        }

        return $lists;
    }

    public static function can(User $user, $class, AccessControlAction $action)
    {
        $rules = static::getAclsFor($class, $action);
        $allGroups = $user->groups()->pluck('groups.id')->toArray();

        foreach ($rules as $rule) {
            if (!isset($rule->group) || in_array($rule->group, $allGroups)) {
                return AccessControlResult::make($rule->action);
            }
        }

        return AccessControlResult::DENY(); // deny if not allowed
    }
}
