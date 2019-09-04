<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rulla\Items\Types\ItemType;
use Rulla\Meta\HasViewUrl;

class Item extends Model
{
    use SoftDeletes;
    use HasViewUrl;

    public $guarded = [];

    public function getIdentifierPrefixLetter(): string
    {
        return 'I';
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'type_id', 'id');
    }

    public function location()
    {
        return $this->morphTo('location');
    }

    public function locatedHere()
    {
        return $this->morphMany(Item::class, 'location');
    }
}
