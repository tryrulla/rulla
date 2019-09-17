<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rulla\Items\Types\ItemType;
use Rulla\Meta\HasViewUrl;
use Rulla\Traits\HasCustomFields;

class Item extends Model
{
    use SoftDeletes;
    use HasViewUrl;
    use HasCustomFields;

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

    public function checkouts()
    {
        return $this->hasMany(ItemCheckout::class, 'item_id', 'id')
            ->orderByDesc('id');
    }

    public function lastCheckouts()
    {
        return $this->checkouts()
            ->limit(5);
    }

    /**
     * @return ItemCheckout|null
     */
    public function getActiveCheckout()
    {
        return ($this->relationLoaded('checkouts') ? $this->checkouts : $this->lastCheckouts)
            ->first(function (ItemCheckout $checkout) {
                return $checkout->returned_at === null;
            });
    }

    /**
     * @return bool
     */
    public function isCheckedOut()
    {
        return ($this->relationLoaded('checkouts') ? $this->checkouts : $this->lastCheckouts)
            ->filter(function (ItemCheckout $checkout) {
                return $checkout->returned_at === null;
            })
            ->isNotEmpty();
    }

    public function faults()
    {
        return $this->hasMany(ItemFault::class, 'item_id', 'id')
            ->orderByDesc('id');
    }

    public function lastFaults()
    {
        return $this->faults()
            ->limit(5);
    }
}
