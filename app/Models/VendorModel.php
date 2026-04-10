<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{
    protected $table = 'vendor_info';
    protected $primaryKey = 'vendor_id';
    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
    protected $fillable = [
        'vendor_id',
        'branch_id',
        'term_id',
        'term_seq',
        'vendor_name',
        'vendor_food',
        'vendorno',
        'productno',
        'pmino',
        'serialno',
        'ipaddress',
        'forrent',
        'gprate_1',
        'gprate_2',
        'gprate_3',
        'vatrate',
        'govvatrate',
        'includevat',
        'includegovvat',
        'invoiceprint',
        'invoicename',
        'invoiceaddr1',
        'invoiceaddr2',
        'invoiceduedate',
        'invoicepaydate',
        'typediscount',
        'discountamt',
        'cur_discount',
        'def_discount',
        'use_discount',
        'discount_bdate',
        'discount_edate',
        'discount_btime',
        'discount_etime',
        'vendor_function',
        'txnno',
        'vendor_batchno',
        'issuedate',
        'activeflag',
        'min_garantee1',
        'min_garantee2',
        'min_garantee3',
        'dis_garantee',
        'validdate',
        'vendor_subfood',
        'taxbranch',
        'vendor_locate',
        'vendor_paymenttype',
        'billcount',
        'owner_shop',
        'ar_sap',
        'costcenter',
        'invoicecontractname',
        'vendor_area',
        'invoicebranch',
        'invoiceemail',
        'invoicepostcode',
        'invoicephone'
    ];
}
