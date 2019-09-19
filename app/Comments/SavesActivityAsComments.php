<?php

namespace Rulla\Comments;

use Illuminate\Database\Eloquent\Model;

trait SavesActivityAsComments
{
    public static function bootSavesActivityAsComments()
    {
        static::updated(function (Model $model) {
            $user = \Auth::user();

            if (!$user) {
                return;
            }

            $diff = collect($model->getChanges())
                ->map(function ($item, $key) use ($model) {
                    $original = $model->getOriginal($key);

                    if ($model->hasCast($key)) {
                        $original = $model->publicCastAttribute($key, $original);
                    }

                    return ['original' => $original, 'new' => $item];
                })
                ->reject(function ($item, $key) {
                    return $key === 'updated_at';
                });

            if ($diff->isEmpty()) {
                return;
            }

            Comment::create([
                'user_id' => $user->id,
                'commentable_id' => $model->id,
                'commentable_type' => get_class($model),
                'comment_type' => CommentType::change(),
                'data' => ['diff' => $diff],
            ]);
        });
    }

    public function publicCastAttribute($key, $value)
    {
        return $this->castAttribute($key, $value);
    }
}
