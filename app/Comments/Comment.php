<?php

namespace Rulla\Comments;

use Illuminate\Database\Eloquent\Model;
use Rulla\Authentication\Models\User;
use Spatie\Enum\Laravel\HasEnums;

class Comment extends Model
{
    use HasEnums;

    protected $guarded = [];

    protected $enums = [
        'comment_type' => CommentType::class,
    ];

    protected $casts = [
        'data' => 'object',
    ];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo('commentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
