<?php

namespace Rulla\Items\Fields;

use Illuminate\Database\Eloquent\Model;
use Rulla\Meta\HasViewUrl;
use Spatie\Enum\Laravel\HasEnums;
use Spatie\Translatable\HasTranslations;

class Field extends Model
{
    use HasViewUrl;

    use HasTranslations, HasEnums {
        HasTranslations::setAttribute as translationTraitSetAttribute;
        HasEnums::setAttribute as enumTraitSetAttribute;
    }

    protected $casts = [
        'system' => 'boolean',
    ];

    public function setAttribute($key, $value)
    {
        if ($this->isTranslatableAttribute($key)) {
            return $this->translationTraitSetAttribute($key, $value);
        }

        if ($this->isEnumAttribute($key)) {
            return $this->enumTraitSetAttribute($key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    public $translatable = ['name', 'description'];

    public $enums = [
        'type' => FieldType::class,
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'F';
    }

    public function values()
    {
        return $this->hasMany(FieldValue::class, 'field_id')
            ->with('valueHolder');
    }

    public function appliesTo()
    {
        return $this->hasMany(FieldAppliesTo::class, 'field_id');
    }
}