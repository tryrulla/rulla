<?php

namespace Rulla\Comments;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Rulla\Authentication\Models\User;

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
        $diff = $this->getPendingChanges();

        if (empty($diff)) {
            return;
        }

        $userId = Auth::check() ? Auth::user()->id : 0;

        Comment::create([
            'user_id' => $userId,
            'commentable_id' => $this->id,
            'commentable_type' => get_class($this),
            'comment_type' => CommentType::change(),
            'data' => ['diff' => $diff],
        ]);

        $this->clearPendingChanges();
    }

    public function saveAllChanges()
    {
        $diff = collect($this->getChanges())
            ->map(function ($item, $key) {
                $original = $this->getOriginal($key);

                if ($this->hasCast($key)) {
                    $original = $this->publicCastAttribute($key, $original);
                }

                return ['original' => $original, 'new' => $item];
            })
            ->reject(function ($item, $key) {
                return $key === 'updated_at' || $this->isGuarded($key);
            })
            ->concat($this->getPendingChanges());
        $this->clearPendingChanges();

        if ($diff->isEmpty()) {
            return;
        }

        $userId = Auth::check() ? Auth::user()->id : 0;

        Comment::create([
            'user_id' => $userId,
            'commentable_id' => $this->id,
            'commentable_type' => get_class($this),
            'comment_type' => CommentType::change(),
            'data' => ['diff' => $diff],
        ]);

    }

    public static function bootSavesActivityAsComments()
    {
        static::created(function (Model $model) {
            $model->saveAllChanges();
        });

        static::updated(function (Model $model) {
            $model->saveAllChanges();
        });
    }

    public function publicCastAttribute($key, $value)
    {
        return $this->castAttribute($key, $value);
    }

    public abstract function getFieldNameTranslationPrefix();
}
