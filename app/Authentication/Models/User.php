<?php

namespace Rulla\Authentication\Models;

use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\Groups\UserInGroup;
use Rulla\Comments\HasComments;
use Rulla\Comments\SavesActivityAsComments;
use Rulla\Items\Instances\ItemCheckout;
use Rulla\Items\Instances\ItemFault;
use Rulla\Meta\HasFormattedIdentifier;

class User extends Authenticatable
{
    use Notifiable;
    use HasFormattedIdentifier;
    use HasComments, SavesActivityAsComments;

    protected $appends = ['viewUrl'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fieldToModelTypes = [
        'groups' => [Group::class, 'id'],
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'U';
    }

    public function getFieldNameTranslationPrefix()
    {
        return 'users.profile.view.details.';
    }

    public function getViewUrlAttribute()
    {
        return url(route('user.profile.view', $this));
    }

    public function assignedFaults()
    {
        return $this->hasMany(ItemFault::class, 'assignee_id', 'id')
            ->with('item', 'item.type')
            ->scopes('open');
    }

    public function checkouts()
    {
        return $this->hasMany(ItemCheckout::class, 'user_id', 'id')
            ->with('item', 'item.type')
            ->scopes('active');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, UserInGroup::class)
            ->orderBy('groups.id');
    }

    public function getGroupIds(): array
    {
        return $this->groups()
            ->pluck('groups.id')
            ->toArray();
    }

    /**
     * @param array $groupIds
     * @throws Exception
     */
    public function setGroups(array $groupIds) {
        try {
            DB::beginTransaction();

            $newGroups = collect($groupIds);
            $oldGroupIds = $this->getGroupIds();

            UserInGroup::where('user_id', $this->id)
                ->whereNotIn('group_id', $newGroups)
                ->delete();

            $newGroups->each(function ($newGroupId) {
                UserInGroup::updateOrCreate([
                    'user_id' => $this->id,
                    'group_id' => $newGroupId,
                ]);
            });

            $newGroupIds = $this->getGroupIds();
            $this->addPendingChange('groups', $oldGroupIds, $newGroupIds);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }
}
