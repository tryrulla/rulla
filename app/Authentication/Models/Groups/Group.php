<?php

namespace Rulla\Authentication\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Meta\HasViewUrl;
use Spatie\Translatable\HasTranslations;

class Group extends Model
{
    use HasTranslations;
    use HasViewUrl;

    protected $guarded = [];
    public $translatable = ['name'];

    public function getIdentifierPrefixLetter(): string
    {
        return 'G';
    }

    public function members()
    {
        return $this->hasManyThrough(User::class, UserInGroup::class);
    }
}
