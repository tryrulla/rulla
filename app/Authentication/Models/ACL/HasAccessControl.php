<?php


namespace Rulla\Authentication\Models\ACL;


trait HasAccessControl
{
    function getAclRuleIds(): array
    {
        // TODO
        return AccessControlUtility::defaultRuleIds();
    }
}
