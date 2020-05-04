<?php

namespace Rulla\Policies\Items\Fields;

use Rulla\Authentication\Models\ACL\AccessControlAction;
use Rulla\Authentication\Models\ACL\AccessControlUtility;
use Rulla\Authentication\Models\User;
use Rulla\Items\Fields\Field;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any fields.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::LIST(), AccessControlUtility::defaultRuleIds());
    }

    /**
     * Determine whether the user can view the field.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @param  \Rulla\Items\Fields\Field  $field
     * @return mixed
     */
    public function view(?User $user, Field $field)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::VIEW(), $field->getAclRuleIds());
    }

    /**
     * Determine whether the user can create fields.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::CREATE(), AccessControlUtility::defaultRuleIds());
    }

    /**
     * Determine whether the user can update the field.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @param  \Rulla\Items\Fields\Field  $field
     * @return mixed
     */
    public function update(?User $user, Field $field)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::EDIT(), $field->getAclRuleIds());
    }

    /**
     * Determine whether the user can delete the field.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @param  \Rulla\Items\Fields\Field  $field
     * @return mixed
     */
    public function delete(?User $user, Field $field)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::DELETE(), $field->getAclRuleIds());
    }

    /**
     * Determine whether the user can restore the field.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @param  \Rulla\Items\Fields\Field  $field
     * @return mixed
     */
    public function restore(?User $user, Field $field)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::DELETE(), $field->getAclRuleIds());
    }

    /**
     * Determine whether the user can permanently delete the field.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @param  \Rulla\Items\Fields\Field  $field
     * @return mixed
     */
    public function forceDelete(?User $user, Field $field)
    {
        return AccessControlUtility::can($user, Field::class, AccessControlAction::FORCEDELETE(), $field->getAclRuleIds());
    }
}
