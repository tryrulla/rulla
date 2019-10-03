<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TypeStoredAt extends Model
{
    public $guarded = [];
    protected $appends = ['mode'];

    protected $casts = [
        'storage' => 'boolean',
        'checkout' => 'boolean',
    ];

    public function storedType()
    {
        return $this->belongsTo(ItemType::class, 'stored_type_id', 'id');
    }

    public function storageType()
    {
        return $this->belongsTo(ItemType::class, 'storage_type_id', 'id');
    }

    /**
     * @return Collection
     */
    public function getModeAttribute()
    {
        $modes = collect();

        if ($this->storage) {
            $modes->push('storage');
        }

        if ($this->checkout) {
            $modes->push('checkout');
        }

        return $modes;
    }
}
