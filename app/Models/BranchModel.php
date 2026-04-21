<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    protected $table = 'branch_info';
    protected $primaryKey = 'branch_id';
    protected $fillable = [
        'branch_id',
        'branch_name',
        'branch_addr1',
        'branch_addr2',
        'branch_tel',
        'tax_id',
        'tax_name',
        'tax_addr1',
        'tax_addr2',
        'ipaddress',
        'businessdate',
        'batchno',
        'batchdate',
        'activeflag',
        'message_1',
        'message_2',
        'message_3',
        'message_4',
        'tax_name_e',
        'tax_addr1_e',
        'tax_addr2_e',
        'online',
        'tax_branch',
        'tax_branchseq',
        'tax_branchcode',
        'gl01_costcenter',
        'gl01_accno',
        'gl01_subaccno',
        'gl02_costcenter',
        'gl02_accno',
        'gl02_subaccno',
        'gl03_costcenter',
        'gl03_accno',
        'gl03_subaccno',
        'gl04_costcenter',
        'gl04_accno',
        'gl04_subaccno',
        'gl05_costcenter',
        'gl05_accno',
        'gl05_subaccno',
        'gl06_costcenter',
        'gl06_accno',
        'gl06_subaccno',
        'gl01_desc',
        'gl02_desc',
        'gl03_desc',
        'gl04_desc',
        'gl05_desc',
        'gl06_desc',
        'gl07_costcenter',
        'gl07_accno',
        'gl07_subaccno',
        'gl07_desc',
    ];
    public $timestamps = false;
}
