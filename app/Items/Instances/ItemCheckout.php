<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Meta\HasFormattedIdentifier;

class ItemCheckout extends Model
{
    use HasFormattedIdentifier;

    public function getIdentifierPrefixLetter(): string
    {
        return 'IC';
    }

    /**
     * Scope a query to only include active checkouts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('returned_at', null);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $dates = [
        'returned_at',
    ];
}
