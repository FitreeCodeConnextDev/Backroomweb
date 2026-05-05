<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCardModel extends Model
{
    protected $table = 'promotion_info';
    protected $primaryKey = 'promo_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'promo_code',
        'promo_desc',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'buy_amt',
        'get_amt',
        'get_point',
        'adj_amt',
        'adjget_amt',
        'adjget_point',
        'activeflag',
        'promo_seq',
        'promo_topup_verify',
        'expense_owner',
        'req_refno',
        'day_use',
    ];

    public $timestamps = false;
}
