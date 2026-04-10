<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'term_id' => 'required',
            'term_seq' => 'required',
            'vendor_name' => 'required',
            'vendor_food' => 'required',
            'issuedate' => 'required|date',
            'validdate' => 'required|date|after:issuedate',
            'vendor_subfood' => 'nullable',
            'ar_sap' => 'nullable',
            'vendorno' => 'required',
            'productno' => 'required',
            'pmino' => 'nullable',
            'taxbranch' => 'nullable',
            'owner_shop' => 'required',
            'vendor_locate' => 'nullable',
            'serialno' => 'nullable',
            'ipaddress' => 'nullable|ip',
            'txnno' => 'required',
            'vendor_batchno' => 'required',
            'billcount' => 'required',
        ];
        if ($this->isMethod('post')) {
            $rules['vendor_id'] = 'required|max:10|unique:vendor_info,vendor_id';
            $rules['branch_id'] = 'required';
        }

        return $rules;
    }
    public function messages(): array
    {
        return [
            'vendor_id.required' => __('vendor.vendor_id_required'),
            'vendor_id.max' => __('vendor.vendor_id_max'),
            'vendor_id.unique' => __('vendor.vendor_id_unique'),
            'branch_id.required' => __('vendor.brand_id_required'),
            'term_id.required' => __('vendor.term_id_required'),
            'term_seq.required' => __('vendor.term_seq_required'),
            'vendor_name.required' => __('vendor.vendor_name_required'),
            'vendor_food.required' => __('vendor.vendor_food_required'),
            'issuedate.required' => __('vendor.issuedate_required'),
            'validdate.required' => __('vendor.validdate_required'),
            'vendorno.required' => __('vendor.vendorno_required'),
            'productno.required' => __('vendor.productno_required'),
            'owner_shop.required' => __('vendor.owner_shop_required'),
            'txnno.required' => __('vendor.txnno_required'),
            'vendor_batchno.required' => __('vendor.vendor_batchno_required'),
            'billcount.required' => __('vendor.vendor_billcount_required'),
        ];
    }
}
