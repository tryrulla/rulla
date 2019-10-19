<?php

namespace Rulla\Comments;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SavesActivityAsComments
{
    // protected $fieldToModelTypes = [];

    private $pendingChanges = [];

    /**
     * @return array
     */
    public function getFieldToModelTypes(): array
    {
        return isset($this->fieldToModelTypes) ? $this->fieldToModelTypes : [];
    }

    public function getFieldName($field)
    {
        if (Str::endsWith($field, '_id')) {
            $field = substr($field, 0, strlen($field) - 3);
        }

        return __($this->getFieldNameTranslationPrefix() . $field);
    }

    /**
     * @return array
     */
    public function getPendingChanges(): array
    {
        return $this->pendingChanges;
    }

    public function clearPendingChanges(): void
    {
        $this->pendingChanges = [];
    }

    public function addPendingChange(string $key, $original, $new)
    {
        if ($original === $new) {
            return;
        }

        $this->pendingChanges[$key] = ['original' => $original, 'new' => $new];
    }

    public function savePendingChanges()
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $diff = $this->getPendingChanges();

        if (empty($diff)) {
            return;
        }

        Comment::create([
            'user_id' => $user->id,
            'commentable_id' => $this->id,
            'commentable_type' => get_class($this),
            'comment_type' => CommentType::change(),
            'data' => ['diff' => $diff],
        ]);

        $this->clearPendingChanges();
    }

    public static function bootSavesActivityAsComments()
    {
        static::created(function (Model $model) {
            $user = Auth::user();

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
                })
                ->concat($model->getPendingChanges());
            $model->clearPendingChanges();

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

        static::updated(function (Model $model) {
            $user = Auth::user();

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
                })
                ->concat($model->getPendingChanges());
            $model->clearPendingChanges();

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

    public abstract function getFieldNameTranslationPrefix();
}
