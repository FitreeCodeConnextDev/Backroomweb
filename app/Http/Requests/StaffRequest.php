<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StaffRequest extends FormRequest
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

            'staff_name' => 'required',
            'staff_type' => 'nullable',
            'staff_license' => 'nullable|max:13',
            'staff_birthdate' => 'nullable',
            'staff_expiredate' => 'nullable',
            'staff_addr' => 'nullable',
            'staff_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',
            'credit_limit' => 'nullable',
            'branch_id' => 'required',

        ];
        if ($this->isMethod('POST')) {
            $rules['staff_id'] = 'required|max:10|unique:staff_info,staff_id';
            $rules['card_no'] = 'required|digits:' . $lengthCard;
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'staff_id.required' => __('staff.staff_id_required'),
            'staff_id.max' => __('staff.staff_id_valid_max'),
            'staff_id.unique' => __('staff.staff_id_valid_unique'),
            'staff_name.required' => __('staff.staff_name_required'),
            'staff_type.required' => __('staff.staff_type_required'),
            'staff_license.required' => __('staff.staff_license_required'),
            'staff_license.max' => __('staff.staff_license_max'),
            'staff_birthdate.required' => __('staff.staff_birthdate_required'),
            'staff_expiredate.required' => __('staff.staff_expiredate_required'),
            'staff_addr.required' => __('staff.staff_addr_required'),
            'staff_phone.required' => __('staff.staff_phone_required'),
            'staff_phone.regex' => __('staff.staff_phone_num'),
            'staff_limit.required' => __('staff.staff_limit_required'),
            'card_no.required' => __('staff.card_no_valid'),
            'card_no.digits' => __('staff.card_no_digits'),
        ];

        return $messages;
    }
}
