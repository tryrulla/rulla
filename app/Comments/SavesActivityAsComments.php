<?php

namespace Rulla\Comments;

use Illuminate\Database\Eloquent\Model;

trait SavesActivityAsComments
{
    // protected $fieldToModelTypes = [];

    /**
     * @return array
     */
    public function getFieldToModelTypes(): array
    {
        return isset($this->fieldToModelTypes) ? $this->fieldToModelTypes : [];
    }

    public function getFieldModelType($field)
    {
        return $this->getFieldToModelTypes()[$field];
    }

    public static function bootSavesActivityAsComments()
    {
        static::created(function (Model $model) {
            $user = \Auth::user();

            if (!$user) {
                return;
            }

            $diff = collect($model->getAttributes())
                ->reject(function ($item) {
                    return $item === null;
                })
                ->map(function ($item, $key) use ($model) {
                    if ($model->hasCast($key)) {
                        $item = $model->publicCastAttribute($key, $item);
                    }

                    return ['original' => null, 'new' => $item];
                })
                ->reject(function ($item, $key) {
                    return $key === 'created_at' || $key === 'updated_at';
                });

            Comment::create([
                'user_id' => $user->id,
                'commentable_id' => $model->id,
                'commentable_type' => get_class($model),
                'comment_type' => CommentType::change(),
                'data' => ['diff' => $diff],
            ]);
        });

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
