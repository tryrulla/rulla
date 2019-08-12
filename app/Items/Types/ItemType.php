<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rulla\Meta\HasViewUrl;
use Spatie\Translatable\HasTranslations;

class ItemType extends Model
{
    use HasTranslations;
    use SoftDeletes;
    use HasViewUrl;

    protected $relations = ['parent', 'children'];
    public $translatable = ['name'];
    public $guarded = [];

    protected $casts = [
        'system' => 'boolean'
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'T';
    }

    public function parent()
    {
        return $this->belongsTo(ItemType::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(ItemType::class, 'parent_id', 'id')->with('children');
    }
}
