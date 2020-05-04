<?php

namespace Rulla\Policies\Authentication\Groups;

use Rulla\Authentication\ACL\ACLParser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Models\ACL\AccessControlAction;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any groups.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::LIST());
    }

    /**
     * Determine whether the user can view the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function view(?User $user, Group $group)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::VIEW());
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param User $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::CREATE());
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function update(?User $user, Group $group)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::EDIT());
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function delete(?User $user, Group $group)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::DELETE());
    }

    /**
     * Determine whether the user can restore the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function restore(?User $user, Group $group)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::DELETE());
    }

    /**
     * Determine whether the user can permanently delete the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function forceDelete(?User $user, Group $group)
    {
        return ACLParser::can($user, Group::class, AccessControlAction::FORCEDELETE());
    }
}
