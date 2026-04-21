<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [

            'user_name' => 'required',
            'user_pass' => 'required',
            'branch_id' => 'required',
            'city_license' => 'nullable',
            'card_no' => 'nullable',
            'needresetpass' => 'required',
            'resetpass_day' => 'required',
            'user_nomiss' => 'nullable',
            'issuedate' => 'nullable',
            'issuetime' => 'nullable',
            'lastuser_pass' => 'nullable',
            'startdate_reset' => 'nullable'

        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|max:6|unique:user_info,user_id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __('users.user_id_required'),
            'user_id.max' => __('users.user_id_max'),
            'user_id.unique' => __('users.user_id_unique'),
            'user_name.required' => __('users.user_name_required'),
            'user_pass.required' => __('users.user_pass_required'),
            'branch_id.required' => __('users.branch_id_required'),
        ];
    }
}
