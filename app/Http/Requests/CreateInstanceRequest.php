<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Rulla\Items\Instances\Item;
use Rulla\Items\Types\ItemType;

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
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes(['location_id', 'location_type'], ['required'], function ($input) {
            return in_array($input->location_type, [ItemType::class, Item::class]);
        });
    }
}
