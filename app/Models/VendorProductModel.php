<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProductModel extends Model
{
    protected $table = 'vendorproduct_info';
    // protected $primaryKey = 'vendor_id';
    protected $fillable = [
        'vendor_id',
        'branch_id',
        'term_id',
        'product_seq',
        'product_id',
        'priceunit',
        'pricediscount',
        'pricemember',
        'pricestaff',
        'typediscount',
        'discountamt',
        'cur_discount',
        'def_discount',
        'use_discount',
        'discount_bdate',
        'discount_edate',
        'discount_btime',
        'discount_etime',
        'groupvat',
        'vatrate',
        'product_free',
        'product_perunit',
        'use_point',
        'add_point',
        'activeflag',
        'gp_normal',
        'gp_promotion',
        'gp_member',
        'gp_staff',
        'pricerabbit',
        'gp_rabbit',
        'priceqr',
        'gp_qr',
        'campaign_code',
        'campaign_startdate',
        'campaign_enddate',
        'pricesp1',
        'gp_sp1',
        'pricesp2',
        'gp_sp2',
        'pricesp3',
        'gp_sp3',
        'pricesp4',
        'gp_sp4',
        'pricesp5',
        'gp_sp5',
        'priceedc',
        'gp_edc',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
