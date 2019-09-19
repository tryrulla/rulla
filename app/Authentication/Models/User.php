<?php

namespace Rulla\Authentication\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rulla\Meta\HasFormattedIdentifier;

class User extends Authenticatable
{
    use Notifiable;
    use HasFormattedIdentifier;

    public function getIdentifierPrefixLetter(): string
    {
        return 'U';
    }

    protected $appends = ['viewUrl'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function getViewUrlAttribute()
    {
        return url(route('user.profile.view', $this));
    }
}
