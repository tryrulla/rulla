<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;

class TypeStoredAt extends Model
{
    public $guarded = [];

    public function storedType()
    {
        return $this->belongsTo(ItemType::class, 'stored_type_id', 'id');
    }

    public function storageType()
    {
        return $this->belongsTo(ItemType::class, 'storage_type_id', 'id');
    }
}
