<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInstanceRequest extends FormRequest
{
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
            'tag' => 'nullable|unique:items,tag',
            'type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ]
        ];
    }
}
