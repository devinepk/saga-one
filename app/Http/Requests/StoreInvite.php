<?php

namespace App\Http\Requests;

use App\Journal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvite extends FormRequest
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
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::notIn(array_column($this->route('journal')->users->all(), 'email'))
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'  => 'Please provide a :attribute.',
            'email.required' => 'Please provide an :attribute.',
            'email.not_in'   => 'A user with that :attribute is already participating in this journal.',
            'max'            => 'The :attribute may not be longer than :max characters.'
        ];
    }
}
