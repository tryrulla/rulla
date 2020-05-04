<?php


namespace Rulla\Authentication\Models\ACL;


use Cache;

class AccessControlCacher
{
    const DEFAULT = 'default';

    public static function parseLists($acls)
    {
        $results = [
            self::DEFAULT => [
                AccessControlAction::DEFAULT()->getName() => [],
            ],
        ];

        foreach ($acls as $acl) {
            foreach ($acl->data as $ruleSet) {
                $targetClass = sizeof($ruleSet->target) > 0 ? $ruleSet->target[0] : self::DEFAULT;
                $targetAction = sizeof($ruleSet->target) > 1 ? $ruleSet->target[1] : self::DEFAULT;

                $targetClass = strlen($targetClass) > 0 ? $targetClass : self::DEFAULT;
                $targetAction = strlen($targetAction) > 0 ? AccessControlAction::make($targetAction)->getName() : AccessControlAction::DEFAULT()->getName();

                if (!array_key_exists($targetClass, $results)) {
                    $results[$targetClass] = [
                        AccessControlAction::DEFAULT()->getName() => [],
                    ];
                }

                if (!array_key_exists($targetAction, $results[$targetClass])) {
                    $results[$targetClass][$targetAction] = [];
                }

                foreach ($ruleSet->rules as $rule) {
                    $results[$targetClass][$targetAction][] = [
                        'group' => $rule->group ?? null,
                        'result' => AccessControlResult::make($rule->result),
                    ];
                }
            }
        };

        return $results;
    }

    public static function getListForAction($rules, $class = self::DEFAULT, string $action = null)
    {
        if (!$action) {
            $action = AccessControlAction::DEFAULT()->getName();
        }

        $results = [];

        if (array_key_exists($class, $rules)) {
            //dd(compact('rules', 'class'));
            dd([
                'action' => $action,
                'rules' => $rules[$class],
            ]);
            if (array_key_exists($action, $rules[$class])) {
                $results = array_merge($results, $rules[$class][$action]);
            }

            if (array_key_exists(AccessControlAction::DEFAULT()->getName(), $rules[$class]) && $action !== AccessControlAction::DEFAULT()->getName()) {
                $results = array_merge($results, $rules[$class][AccessControlAction::DEFAULT()->getName()]);
            }
        }

        if (array_key_exists(self::DEFAULT, $rules) && $action !== AccessControlAction::DEFAULT()->getName()) {
            if (array_key_exists($action, $rules[self::DEFAULT])) {
                $results = array_merge($results, $rules[self::DEFAULT][$action]);
            }

            if (array_key_exists(AccessControlAction::DEFAULT()->getName(), $rules[self::DEFAULT])) {
                $results = array_merge($results, $rules[self::DEFAULT][AccessControlAction::DEFAULT()->getName()]);
            }
        }

        return $results;
    }

    public static function getRuleSet(array $ruleIds)
    {
        $cacheKey = "acl-sets-" . join('-', $ruleIds);

        return Cache::remember($cacheKey, 3600, function () use ($ruleIds) {
            return self::parseLists(AccessControlList::findMany($ruleIds));
        });
    }
}
