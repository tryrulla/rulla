<?php

namespace Rulla\Authentication\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Comments\HasComments;
use Rulla\Comments\SavesActivityAsComments;
use Rulla\Meta\HasViewUrl;

class Group extends Model
{
    use HasViewUrl;
    use HasComments, SavesActivityAsComments;

    protected $guarded = [];

    public function getIdentifierPrefixLetter(): string
    {
        return 'G';
    }

    public function members()
    {
        return $this->belongsToMany(User::class, UserInGroup::class)
            ->orderBy('users.id');
    }

    public function getFieldNameTranslationPrefix()
    {
        return 'users.groups.fields.';
    }
}
