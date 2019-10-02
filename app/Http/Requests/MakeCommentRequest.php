<?php

namespace Rulla\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Rulla\Comments\CommentType;
use Rulla\Items\Instances\ItemCheckout;
use Rulla\Items\Instances\ItemFault;

class MakeCommentRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'data' => [
                'text' => $this->get('text'),
            ],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.text' => 'required|min:1|max:1000',
            'comment_type' => ['required', Rule::in([CommentType::comment()])],
            'user_id' => ['required', Rule::in(Auth::user()->id)]
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
        $validator->sometimes(['commentable_id', 'commentable_type'], ['required'], function ($input) {
            return in_array($input->commentable_type, [
                ItemFault::class, ItemCheckout::class
            ]);
        });
    }
}
