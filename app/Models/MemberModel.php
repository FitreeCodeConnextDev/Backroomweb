<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    protected $table = 'member_info';
    protected $primaryKey = 'member_id';
    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'card_no',
        'branch_id',
        'member_name',
        'member_license',
        'member_birthdate',
        'member_expiredate',
        'member_addr',
        'member_phone',
        'member_picture',
        'member_type',
        'issue_date',
        'lastuse_date',
        'credit_amt',
        'credit_limit',
        'lastpayment_date',
        'lastpayment_amt',
        'lastpayment_user_id',
        'activeflag'
    ];
}
