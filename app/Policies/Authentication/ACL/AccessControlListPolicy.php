<?php

namespace Rulla\Policies\Authentication\ACL;

use Rulla\Authentication\Models\ACL\AccessControlAction;
use Rulla\Authentication\Models\ACL\AccessControlUtility;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessControlListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any access control lists.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::LIST(), AccessControlUtility::defaultRuleIds());
    }

    /**
     * Determine whether the user can view the access control list.
     *
     * @param User $user
     * @param AccessControlList $acl
     * @return mixed
     */
    public function view(?User $user, AccessControlList $acl)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::VIEW(), $acl->getAclRuleIds());
    }

    /**
     * Determine whether the user can create access control lists.
     *
     * @param User $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::CREATE(), AccessControlUtility::defaultRuleIds());
    }

    /**
     * Determine whether the user can update the access control list.
     *
     * @param User $user
     * @param AccessControlList $acl
     * @return mixed
     */
    public function update(?User $user, AccessControlList $acl)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::EDIT(), $acl->getAclRuleIds());
    }

    /**
     * Determine whether the user can delete the access control list.
     *
     * @param User $user
     * @param AccessControlList $acl
     * @return mixed
     */
    public function delete(?User $user, AccessControlList $acl)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::DELETE(), $acl->getAclRuleIds());
    }

    /**
     * Determine whether the user can restore the access control list.
     *
     * @param User $user
     * @param AccessControlList $acl
     * @return mixed
     */
    public function restore(?User $user, AccessControlList $acl)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::DELETE(), $acl->getAclRuleIds());
    }

    /**
     * Determine whether the user can permanently delete the access control list.
     *
     * @param User $user
     * @param AccessControlList $acl
     * @return mixed
     */
    public function forceDelete(?User $user, AccessControlList $acl)
    {
        return AccessControlUtility::can($user, AccessControlList::class, AccessControlAction::FORCEDELETE(), $acl->getAclRuleIds());
    }
}
