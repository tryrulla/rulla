<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ItemType extends Model
{
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];
    public $guarded = [];

    protected $casts = [
        'system' => 'boolean'
    ];
    //
}
