<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffModel extends Model
{
    protected $table = 'staff_info';
    protected $primaryKey = 'staff_id';
    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'card_no',
        'branch_id',
        'staff_name',
        'staff_license',
        'staff_birthdate',
        'staff_expiredate',
        'staff_addr',
        'staff_phone',
        'staff_picture',
        'staff_type',
        'issue_date',
        'lastuse_date',
        'credit_amt',
        'credit_limit',
        'lastpayment_date',
        'lastpayment_amt',
        'lastpayment_user_id',
        'activeflag',
    ];
}
