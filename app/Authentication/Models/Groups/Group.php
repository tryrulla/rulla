<?php

namespace Rulla\Authentication\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Meta\HasViewUrl;

class Group extends Model
{
    use HasViewUrl;

    protected $guarded = [];

    public function getIdentifierPrefixLetter(): string
    {
        return 'G';
    }

    public function members()
    {
        return $this->belongsToMany(User::class, UserInGroup::class);
    }
}
