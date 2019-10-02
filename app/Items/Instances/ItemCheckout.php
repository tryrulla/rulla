<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Comments\HasComments;
use Rulla\Comments\SavesActivityAsComments;
use Rulla\Items\Types\ItemType;
use Rulla\Meta\HasViewUrl;

class ItemCheckout extends Model
{
    use HasViewUrl;
    use HasComments, SavesActivityAsComments;

    protected $guarded = [];

    protected $fieldToModelTypes = [
        'item_id' => [Item::class, 'id'],
        'user_id' => [User::class, 'id'],
        'location_id' => [ItemType::class, 'id'],
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'IC';
    }

    public function getFieldNameTranslationPrefix()
    {
        return 'items.checkouts.fields.';
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

    public function location()
    {
        return $this->belongsTo(ItemType::class, 'location_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $dates = [
        'returned_at',
        'due_date',
    ];
}
