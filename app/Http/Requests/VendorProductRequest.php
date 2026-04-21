<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorProductRequest extends FormRequest
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
            'term_id' => 'required',
            'product_id' => 'required',
            'product_free' => 'required',
            'groupvat' => 'required',
            'product_seq' => 'required|numeric',
            'use_point' => 'required',
            'add_point' => 'required',
            'priceunit' => 'required',
            'gp_normal' => 'required',
            'pricediscount' => 'required',
            'gp_promotion' => 'required',
            'pricemember' => 'required',
            'gp_member' => 'required',
            'pricestaff' => 'required',
            'gp_staff' => 'required',
            'pricerabbit' => 'required',
            'gp_rabbit' => 'required',
            'priceqr' => 'required',
            'gp_qr' => 'required',
            'product_perunit' => 'required',
            'vatrate' => 'required',
            'pricesp1' => 'required',
            'gp_sp1' => 'required',
            'pricesp2' => 'required',
            'gp_sp2' => 'required',
            'pricesp3' => 'required',
            'gp_sp3' => 'required',
            'pricesp4' => 'required',
            'gp_sp4' => 'required',
            'pricesp5' => 'required',
            'gp_sp5' => 'required',
            'priceedc' => 'nullable',
            'gp_edc' => 'nullable',
            'campaing_code' => 'nullable',
            'campaing_startdate' => 'nullable',
            'campaing_enddate' => 'nullable',
            'campaing_starttime' => 'nullable',
            'campaing_endtime' => 'nullable',
        ];

        if ($this->isMethod('post')) {
            $rules['product_seq'] = 'required|numeric|unique:vendorproduct_info,product_seq,NULL,id,vendor_id,' . $this->vendor_id . ',branch_id,' . $this->branch_id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'vendor_id.required' => __('vendor_product.vendor_id_required'),
            'branch_id.required' => __('vendor_product.branch_id_required'),
            'term_id.required' => __('vendor_product.term_id_required'),
            'product_id.required' => __('vendor_product.product_id_required'),
            'product_free.required' => __('vendor_product.product_free_required'),
            'groupvat.required' => __('vendor_product.groupvat_required'),
            'product_seq.required' => __('vendor_product.product_seq_required'),
            'product_seq.numeric' => __('vendor_product.product_seq_numeric'),
            'product_seq.unique' => __('vendor_product.product_seq_unique'),
            'use_point.required' => __('vendor_product.product_use_point_required'),
            'add_point.required' => __('vendor_product.product_add_point_required'),
            'priceunit.required' => __('vendor_product.product_priceunit_required'),
            'gp_normal.required' => __('vendor_product.product_gp_normal_required'),
            'pricediscount.required' => __('vendor_product.product_pricediscount_required'),
            'gp_promotion.required' => __('vendor_product.product_gp_promotion_required'),
            'pricemember.required' => __('vendor_product.product_price_member_required'),
            'gp_member.required' => __('vendor_product.product_gp_member_required'),
            'pricestaff.required' => __('vendor_product.product_price_staff_required'),
            'gp_staff.required' => __('vendor_product.product_gp_staff_required'),
            'pricerabbit.required' => __('vendor_product.product_price_rabbit_required'),
            'gp_rabbit.required' => __('vendor_product.product_gp_rabbit_required'),
            'priceqr.required' => __('vendor_product.product_price_qr_required'),
            'gp_qr.required' => __('vendor_product.product_gp_qr_required'),
            'product_perunit.required' => __('vendor_product.product_perunit_required'),
            'vatrate.required' => __('vendor_product.product_vatrate_required'),
            'pricesp1.required' => __('vendor_product.product_sp1_required'),
            'gp_sp1.required' => __('vendor_product.product_gp_sp1_required'),
            'pricesp2.required' => __('vendor_product.product_sp2_required'),
            'gp_sp2.required' => __('vendor_product.product_gp_sp2_required'),
            'pricesp3.required' => __('vendor_product.product_sp3_required'),
            'gp_sp3.required' => __('vendor_product.product_gp_sp3_required'),
            'pricesp4.required' => __('vendor_product.product_sp4_required'),
            'gp_sp4.required' => __('vendor_product.product_gp_sp4_required'),
            'pricesp5.required' => __('vendor_product.product_sp5_required'),
            'gp_sp5.required' => __('vendor_product.product_gp_sp5_required'),
            'priceedc.required' => __('vendor_product.product_price_edc_required'),
            'gp_edc.required' => __('vendor_product.product_gp_edc_required'),

        ];
    }
}
