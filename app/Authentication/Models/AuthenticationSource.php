<?php

namespace Rulla\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AuthenticationSource extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    public $guarded = [];

    protected $casts = [
        'options' => 'object',
        'active' => 'boolean',
    ];
}
