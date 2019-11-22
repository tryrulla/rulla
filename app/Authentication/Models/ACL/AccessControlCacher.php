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
                self::DEFAULT => [],
            ],
        ];

        foreach ($acls as $acl) {
            foreach ($acl->data as $ruleSet) {
                $targetClass = sizeof($ruleSet->target) > 0 ? $ruleSet->target[0] : self::DEFAULT;
                $targetAction = sizeof($ruleSet->target) > 1 ? $ruleSet->target[1] : self::DEFAULT;

                if (!array_key_exists($targetClass, $results)) {
                    $results[$targetClass] = [
                        self::DEFAULT => [],
                    ];
                }

                if (!array_key_exists($targetAction, $results[$targetClass])) {
                    $results[$targetClass][$targetAction] = [];
                }

                foreach ($ruleSet->rules as $rule) {
                    $results[$targetClass][$targetAction][] = [
                        'group' => $rule->group ?? null,
                        'action' => AccessControlAction::make($rule->action),
                    ];
                }
            }
        };

        return $results;
    }

    public static function getListForAction($rules, $class = self::DEFAULT, $action = self::DEFAULT)
    {
        $results = [];

        if (array_key_exists($class, $rules)) {
            if (array_key_exists($action, $rules[$class])) {
                $results = array_merge($results, $rules[$class][$action]);
            }

            if (array_key_exists(self::DEFAULT, $rules[$class]) && $action !== self::DEFAULT) {
                $results = array_merge($results, $rules[$class][self::DEFAULT]);
            }
        }

        if (array_key_exists(self::DEFAULT, $rules) && $action !== self::DEFAULT) {
            if (array_key_exists($action, $rules[self::DEFAULT])) {
                $results = array_merge($results, $rules[self::DEFAULT][$action]);
            }

            if (array_key_exists(self::DEFAULT, $rules[self::DEFAULT])) {
                $results = array_merge($results, $rules[self::DEFAULT][self::DEFAULT]);
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
