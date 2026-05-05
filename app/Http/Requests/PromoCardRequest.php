<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PromoCardRequest extends FormRequest
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
            'promo_desc' => 'required|string',
            'promo_seq' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'expense_owner' => 'required',
            'req_refno' => 'required',
            'buy_amt' => 'required',
            'get_amt' => 'required',
            'get_point' => 'required',
            'adj_amt' => 'required',
            'adjget_amt' => 'required',
            'adjget_point' => 'required',
            'promo_topup_verify' => 'required',
            'mon_day' => 'required',
            'tue_day' => 'required',
            'wed_day' => 'required',
            'thu_day' => 'required',
            'fri_day' => 'required',
            'sat_day' => 'required',
            'sun_day' => 'required',
            'expire_day' => 'required',
            'priority' => 'required',
            'deposit' => 'required',
            'expire_checkby' => 'required',
        ];

        if ($this->isMethod('POST') || $this->isMethod('PUT')) {
            $rules['promo_code'] = 'required|max:10|unique:promotion_info,promo_code';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'promo_code.required' => __('card_promo.promo_code_valid'),
            'promo_code.max' => __('card_promo.promo_code_max'),
            'promo_code.unique' => __('card_promo.promo_code_unique'),
            'promo_desc' => __('card_promo.promo_desc_valid'),
            'promo_seq' => __('card_promo.promo_seq_valid'),
            'start_date' => __('card_promo.start_date_valid'),
            'end_date' => __('card_promo.end_date_valid'),
            'start_time' => __('card_promo.start_time_valid'),
            'end_time' => __('card_promo.end_time_valid'),
            'expense_owner' => __('card_promo.expense_owner_valid'),
            'req_refno' => __('card_promo.req_refno_valid'),
            'buy_amt' => __('card_promo.buy_amt_valid'),
            'get_amt' => __('card_promo.get_amt_valid'),
            'get_point' => __('card_promo.get_point_valid'),
            'adj_amt' => __('card_promo.adj_amt_valid'),
            'adjget_amt' => __('card_promo.adjget_amt_valid'),
            'adjget_point' => __('card_promo.adjget_point_valid'),
            'promo_topup_verify' => __('card_promo.promo_topup_verify_required'),
            'mon_day' => __('card_promo.mon_day_required'),
            'tue_day' => __('card_promo.tue_day_required'),
            'wed_day' => __('card_promo.wed_day_required'),
            'thu_day' => __('card_promo.thu_day_required'),
            'fri_day' => __('card_promo.fri_day_required'),
            'sat_day' => __('card_promo.sat_day_required'),
            'sun_day' => __('card_promo.sun_day_required'),
            'expire_day' => __('card_promo.expire_day_required'),
            'piority' => __('card_promo.piority_required'),
            'deposit' => __('card_promo.deposit_required'),
            'expire_checkby' => __('card_promo.expire_checkby_required'),
        ];
    }
}
