<?php

namespace Rulla\Comments;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo('commentable');
    }
}
