<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class MemberRequest extends FormRequest
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
        $lengthCard = DB::table('system_info')->value('lengthcard');
        $rules = [
            'member_name' => 'required',
            'branch_id' => 'nullable',
            'member_license' => 'nullable|min:13|max:13',
            'member_expire' => 'nullable',
            'member_birthdate' => 'nullable',
            'member_addr' => 'nullable',
            'member_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

        ];

        if ($this->isMethod('POST')) {
            $rules['member_id'] = 'required|max:10|unique:member_info,member_id';
            $rules['card_no'] = 'required|digits:' . $lengthCard;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'member_id.required' => __('member.member_id_valid'),
            'member_id.max' => __('member.member_id_valid_max'),
            'member_id.unique' => __('member.member_id_unique'),
            'member_name.required' => __('member.member_name_valid'),
            'member_license.required' => __('member.member_license_valid'),
            'member_license.min' => __('member.member_license_valid_min'),
            'member_license.max' => __('member.member_license_valid_max'),
            'member_license.num' => __('member.member_license_valid_num'),
            'member_expire.required' => __('member.member_expire_valid'),
            'member_birthdate.required' => __('member.member_birthdate_valid'),
            'member_addr.required' => __('member.member_addr_valid'),
            'member_phone.required' => __('member.member_phone_valid'),
            'member_phone.regex' => __('member.member_phone_valid_num'),
            'card_no.required' => __('member.card_no_valid'),
            'card_no.digits' => __('member.card_no_digits'),
        ];
    }
}
