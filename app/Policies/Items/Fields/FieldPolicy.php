<?php

namespace Rulla\Policies\Items\Fields;

use Rulla\Authentication\ACL\ACLParser;
use Rulla\Authentication\Models\ACL\AccessControlAction;
use Rulla\Authentication\Models\User;
use Rulla\Items\Fields\Field;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any fields.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::LIST());
    }

    /**
     * Determine whether the user can view the field.
     *
     * @param User $user
     * @param Field $field
     * @return mixed
     */
    public function view(?User $user, Field $field)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::VIEW());
    }

    /**
     * Determine whether the user can create fields.
     *
     * @param User $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::CREATE());
    }

    /**
     * Determine whether the user can update the field.
     *
     * @param User $user
     * @param Field $field
     * @return mixed
     */
    public function update(?User $user, Field $field)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::EDIT());
    }

    /**
     * Determine whether the user can delete the field.
     *
     * @param User $user
     * @param Field $field
     * @return mixed
     */
    public function delete(?User $user, Field $field)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::DELETE());
    }

    /**
     * Determine whether the user can restore the field.
     *
     * @param User $user
     * @param Field $field
     * @return mixed
     */
    public function restore(?User $user, Field $field)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::DELETE());
    }

    /**
     * Determine whether the user can permanently delete the field.
     *
     * @param User $user
     * @param Field $field
     * @return mixed
     */
    public function forceDelete(?User $user, Field $field)
    {
        return ACLParser::can($user, Field::class, AccessControlAction::FORCEDELETE());
    }
}
