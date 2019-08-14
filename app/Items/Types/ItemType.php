<?php

namespace Rulla\Items\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
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
        return $this->hasMany(ItemType::class, 'parent_id', 'id')->with('children');
    }

    public function storedAtIncludeParents()
    {
        return $this->processStoredAtParents($this);
    }

    private function processStoredAtParents(ItemType $type) {
        $storedAt = TypeStoredAt::where(['stored_type_id' => $type->id])
            ->with('storageType', 'storedType')
            ->get();

        /** @var ItemType $parent */
        $parent = $type->parents;
        if ($parent) {
            $storedAt = $storedAt->merge($this->processStoredAtParents($parent));
        }

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
        return $this->processStoredHereIncludeParents($this);
    }

    private function processStoredHereIncludeParents(ItemType $type) {
        $storedHere = TypeStoredAt::where(['storage_type_id' => $type->id])
            ->with('storageType', 'storedType')
            ->get();

        /** @var ItemType $parent */
        $parent = $type->parents;
        if ($parent) {
            $storedHere = $storedHere->merge($this->processStoredHereIncludeParents($parent));
        }

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

    public function hasParent($parentId)
    {
        return $this->processHasParent($this, $parentId);
    }

    private function processHasParent(ItemType $type, $parentId)
    {
        if ($type->id === $parentId) {
            return true;
        }

        /** @var ItemType $parent */
        $parent = $type->parents;
        if ($parent) {
            return $this->processHasParent($parent, $parentId);
        }

        return false;
    }
}
