<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Rulla\Items\Fields\FieldValue;
use Rulla\Items\Instances\Item;
use Rulla\Meta\HasViewUrl;

class ItemType extends Model
{
    use SoftDeletes;
    use HasViewUrl;

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

    public function parents()
    {
        return $this->parent()->with('parent');
    }

    public function children()
    {
        return $this->hasMany(ItemType::class, 'parent_id', 'id');
    }

    public function childTree()
    {
        return $this->children()->with('childTree');
    }

    public function storedAtIncludeParents()
    {
        $parents = $this->getAllParentIds(true);
        $storedAt = TypeStoredAt::whereIn('stored_type_id', $parents)
            ->with('storageType', 'storedType')
            ->get();

        return $storedAt
            ->groupBy(function (TypeStoredAt $at) {
                return $at->storageType->system;
            })
            ->sortKeysDesc()
            ->map(function (Collection $collection) {
                return $collection->sortBy(function (TypeStoredAt $at) {
                    return $at->storageType->name;
                });
            })
            ->flatten();
    }

    public function storedHereIncludeParents()
    {
        $parents = $this->getAllParentIds(true);
        $storedHere = TypeStoredAt::whereIn('storage_type_id', $parents)
            ->with('storageType', 'storedType')
            ->get();

        return $storedHere
            ->groupBy(function (TypeStoredAt $at) {
                return $at->storedType->system;
            })
            ->sortKeysDesc()
            ->map(function (Collection $collection) {
                return $collection->sortBy(function (TypeStoredAt $at) {
                    return $at->storedType->name;
                });
            })
            ->flatten();
    }

    public function hasParent($parent, $allowSelf = false)
    {
        if ($parent instanceof ItemType) {
            $parent = $parent->id;
        }

        if ($parent === $this->id && $allowSelf) {
            return true;
        }

        return $this->getAllParentIds()->contains($parent);
    }

    public function fields()
    {
        return $this->morphMany(FieldValue::class, 'value_holder');
    }

    /**
     * @return ItemType
     */
    public function getGrandparent()
    {
        $this->loadMissing('parents');
        $grandparent = $this;
        while ($grandparent->parents) {
            $grandparent = $grandparent->parents;
        }

        return $grandparent;
    }

    public function getAllParentIds($includeSelf = false)
    {
        $collection = $includeSelf ? collect($this->id) : collect();

        $this->loadMissing('parents');
        $loop = $this;
        while ($loop->parents) {
            $collection = $collection->push($loop->parents->id);
            $loop = $loop->parents;
        }

        return $collection;
    }

    public function instances()
    {
        return $this->hasMany(Item::class, 'type_id', 'id');
    }

    public function locatedHere()
    {
        return $this->morphMany(Item::class, 'location');
    }
}
