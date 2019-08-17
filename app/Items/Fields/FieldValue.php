<?php

namespace Rulla\Items\Fields;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class FieldValue extends Model
{
    protected $casts = [
        'value' => 'object',
    ];

    public function valueHolder()
    {
        return $this->morphTo();
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function getFormattedValue()
    {
        /** @var FieldType $fieldType */
        $fieldType = $this->field->type;
        $fieldOptions = $this->field->extra_options ? json_decode($this->field->extra_options) : new stdClass();
        $value = $this->value;

        if ($fieldType->isEqual(FieldType::number())) {
            $decimals = $fieldOptions->decimals ?? 0;
            $unit = $fieldOptions->unit ?? '';
            return number_format($value->number, $decimals) . $unit;
        }

        if (FieldType::string()->isEqual($fieldType)) {
            return $value->string;
        }

        return 'ERROR';
    }
}
