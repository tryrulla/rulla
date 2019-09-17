<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rulla\Meta\HasFormattedIdentifier;

class ItemFault extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];

    public function getIdentifierPrefixLetter(): string
    {
        return 'IF';
    }

    /**
     * Scope a query to only include open faults.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOpen(Builder $query)
    {
        return $query->where('closed', false);
    }

    /**
     * Scope a query to only include closed faults.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeClosed(Builder $query)
    {
        return $query->where('closed', true);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
