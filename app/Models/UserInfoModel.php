<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfoModel extends Model
{
    protected $table = 'user_info';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'branch_id',
        'user_name',
        'user_pass',
        'front_permiss',
        'back_permiss',
        'term_permiss',
        'user_lock',
        'user_nomiss',
        'issuedate',
        'issuetime',
        'lastlogdate',
        'lastlogtime',
        'lastuser_pass',
        'startdate_reset',
        'needresetpass',
        'resetpass_day',
        'activeflag',
        'function_permiss',
        'city_license',
        'card_no',
        'profile_code',
    ];
    protected $hidden = [
        'user_pass',
        'lastuser_pass',
    ];
    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
