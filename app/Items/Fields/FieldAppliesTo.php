<?php

namespace Rulla\Items\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rulla\Items\Types\ItemType;

class FieldAppliesTo extends Model
{
    protected $guarded = [];
    protected $appends = ['mode'];

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'type_id', 'id');
    }

    /**
     * @return Collection
     */
    public function getModeAttribute()
    {
        $modes = collect();

        if ($this->apply_to_item) {
            $modes->push('item');
        }

        if ($this->apply_to_type) {
            $modes->push('type');
        }
        return $modes;
    }
}
