<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'branch_name' => 'required',
            'online' => 'required',
            'branch_addr1' => 'required',
            'branch_addr2' => 'nullable',
            'branch_tel' => 'nullable',
            'tax_id' => 'required',
            'tax_name' => 'required',
            'tax_branchseq' => 'nullable',
            'tax_addr1' => 'required',
            'tax_addr2' => 'nullable',
            'tax_name_e' => 'nullable',
            'tax_addr1_e' => 'nullable',
            'tax_addr2_e' => 'nullable',
            'ipaddress' => 'nullable',
            'batchno' => 'required',
            'businessdate' => 'required',
            'deposit' => 'required',
            'vatrate' => 'required',
            'message_1' => 'nullable',
            'message_2' => 'nullable',
            'message_3' => 'nullable',
            'message_4' => 'nullable',

        ];

        if ($this->method() == 'POST') {
            $rules['branch_id'] = 'required|max:6|unique:branch_info,branch_id';
            $rules['batchdate'] = 'required';
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'branch_id.required' => __('branch.branch_id_required'),
            'branch_id.max' => __('branch.branch_id_max'),
            'branch_id.unique' => __('branch.branch_id_unique'),
            'branch_name.required' => __('branch.branch_name_required'),
            'online.required' => __('branch.online_required'),
            'branch_addr1.required' => __('branch.branch_addr1_required'),
            'branch_tel.required' => __('branch.branch_tel_required'),
            'tax_id.required' => __('branch.tax_id_required'),
            'tax_name.required' => __('branch.tax_name_required'),
            'tax_addr1.required' => __('branch.tax_addr1_required'),
            'batchno.required' => __('branch.batchno_required'),
            'businessdate.required' => __('branch.businessdate_required'),
            'deposit.required' => __('branch.deposit_required'),
            'vatrate.required' => __('branch.vatrate_required'),
        ];
    }
}
