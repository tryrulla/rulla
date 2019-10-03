<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Rulla\Traits\ConvertsBoolean;

class CreateTypeStoredAtRequest extends FormRequest
{
    use ConvertsBoolean;

    protected $boolean_attributes = ['storage', 'checkout'];

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
            'stored_type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ],
            'storage_type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ],
            'storage' => 'required|boolean',
            'checkout' => 'required|boolean',
        ];
    }
}
