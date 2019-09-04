<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Rulla\Traits\ConvertsBoolean;

class FieldAppliesToRequest extends FormRequest
{
    use ConvertsBoolean;

    protected $boolean_attributes = ['apply_to_type', 'apply_to_item'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'field_id' => [
                'required',
                Rule::exists('fields', 'id')->where('system', 'false'),
            ],
            'type_id' => [
                'required',
            ],
            'apply_to_type' => 'boolean',
            'apply_to_item' => 'boolean',
        ];
    }
}
