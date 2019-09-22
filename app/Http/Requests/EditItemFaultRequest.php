<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Rulla\Traits\ConvertsBoolean;

class EditItemFaultRequest extends FormRequest
{
    use ConvertsBoolean;

    protected $boolean_attributes = ['closed'];

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
            'title' => 'nullable|max:150',
            'description' => 'nullable',
            'assignee_id' => 'nullable|exists:users,id',
            'closed' => 'boolean',
        ];
    }
}
