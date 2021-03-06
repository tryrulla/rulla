<?php

namespace Rulla\Items\Instances;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Rulla\Comments\HasComments;
use Rulla\Comments\SavesActivityAsComments;
use Rulla\Meta\HasViewUrl;

class ItemFault extends Model
{
    protected $fieldToModelTypes = [
        'item_id' => [Item::class, 'id'],
        'assignee_id' => [User::class, 'id'],
    ];

    use HasViewUrl;
    use HasComments, SavesActivityAsComments;

    protected $guarded = [];

    public function getIdentifierPrefixLetter(): string
    {
        return 'IF';
    }

    protected $casts = [
        'closed' => 'boolean',
    ];

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

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }

    public function getFieldNameTranslationPrefix()
    {
        return 'items.faults.fields.';
    }
}
