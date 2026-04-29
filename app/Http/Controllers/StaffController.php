<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use App\Http\Requests\StaffRequest;
use App\Models\StaffModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 11)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Staff Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Staff Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $staff_data = DB::table('staff_info')
            ->select('staff_id', 'staff_name')
            ->where('activeflag', '=', 1)
            ->get();

        return view('pages.staff.index', compact('staff_data'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 33)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $lengthCard = DB::table('system_info')->value('lengthcard');
        if (session('auth_user.branch_id') == 000000) {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->select('branch_id')->get();
        } else {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->where('branch_id', session('auth_user.branch_id'))->select('branch_id')->get();
        }
        return view('pages.staff.create', compact('lengthCard', 'branch_id'));
    }

    public function store(StaffRequest $request)
    {
        try {
            $staff_birthdate = Carbon::parse($request->staff_birthdate)->format('Y-m-d');
            $staff_expiredate = Carbon::parse($request->staff_expiredate)->format('Y-m-d');
            $checksum = $this->checkSum($request->card_no);
            $card_no_checksum = $request->card_no . $checksum;

            $staff_info = new StaffModel();
            $staff_info->staff_id = $request->staff_id;
            $staff_info->staff_name = $request->staff_name;
            $staff_info->staff_type = $request->staff_type;
            $staff_info->staff_license = $request->staff_license;
            $staff_info->branch_id = $request->branch_id;
            $staff_info->staff_birthdate = $staff_birthdate;
            $staff_info->staff_expiredate = $staff_expiredate;
            $staff_info->staff_addr = $request->staff_addr;
            $staff_info->staff_phone = $request->staff_phone;
            $staff_info->credit_limit = $request->staff_limit;
            $staff_info->card_no = $card_no_checksum;
            $staff_info->issue_date = Carbon::now()->toDateTimeString();
            $staff_info->credit_amt = 0;
            $staff_info->credit_limit = 0;
            $staff_info->lastpayment_amt = 0;
            $staff_info->activeflag = 1;

            if ($staff_info->save()) {
                Log::channel('activity')
                    ->notice(session('auth_user.user_id') .  'Created new staff: ' . $request->staff_id, [
                        'staff_id' => $request->staff_id,
                        'staff_name' => $request->staff_name,
                        'action' => 'create',
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'created_by' => session('auth_user.user_id'),
                    ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.save_is_success'));
                return redirect()->route('staff.index');
            } else {
                Log::channel('activity')
                    ->error(session('auth_user.user_id') .  'Failed to create staff', [
                        'staff_id' => $request->staff_id,
                        'staff_name' => $request->staff_name,
                        'action' => 'create',
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'created_by' => session('auth_user.user_id'),
                    ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.save_is_failed'));
                return redirect()->route('staff.create');
            }
        } catch (\Exception $e) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') .  'Failed to create staff: ' . $e->getMessage(), [
                    'staff_id' => $request->staff_id,
                    'staff_name' => $request->staff_name,
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('staff.create');
        }
    }
    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 34)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Staff Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Staff Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $staff_data = StaffModel::find($id);
        $card_sub = DB::table('cardsub_info')
            ->selectRaw('(cur_amt + adj_amt - use_amt) as net')
            ->where('card_no', '=', $staff_data->card_no)
            ->first();
        $use_card = db::table('sale_card_daily as d')
            ->join('cardsub_info as c', 'd.card_no', '=', 'c.card_no')
            ->select(
                'd.txndate',
                'd.clientno as term_id',
                db::raw("cast('cashier' as varchar(100)) as ref_name"),
                db::raw("(d.sale_amt + d.adj_amt) as total")
            )
            ->where('d.card_no', $staff_data->card_no)
            ->whereraw('d.txndate >= c.issuedate')
            ->where('d.txntype', '<>', '02');
        $use_card_staff = DB::table('sale_terminal_daily as a')
            ->join('vendor_info as b', 'a.vendor_id', '=', 'b.vendor_id')
            ->select(
                'a.txndate',
                'a.term_id',
                'b.vendor_name',
                'a.amount'
            )
            ->where('a.card_no', $staff_data->card_no)
            ->where('a.void_flag', '0')
            ->orderBy('a.txndate', 'desc')
            ->get();
        $staff_card_detail = DB::table('cardsub_info')

            ->select(
                'issuedate',
                'lastusedate',
                'lastadjustdate',
            )
            ->where('card_no', $staff_data->card_no)
            ->orderBy('issuedate', 'desc')
            ->get();

        // dd($use_card_staff_backup);
        Log::channel('activity')->info('Staff Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'staff_data' => $staff_data,
            'card_sub' => $card_sub,
            'use_card' => $use_card,
            'page' => 'Staff Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        $lengthCard = DB::table('system_info')->value('lengthcard');
        if (session('auth_user.branch_id') == 000000) {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->select('branch_id')->get();
        } else {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->where('branch_id', session('auth_user.branch_id'))->select('branch_id')->get();
        }
        return view('pages.staff.edit', compact('staff_data', 'card_sub', 'use_card_staff', 'staff_card_detail', 'lengthCard', 'branch_id'));
    }

    public function update(StaffRequest $request, $id)
    {
        try {
            $staff_info = StaffModel::find($id);
            $staff_info->staff_name = $request->staff_name;
            $staff_info->staff_type = $request->staff_type;
            $staff_info->staff_license = $request->staff_license;
            $staff_info->branch_id = $request->branch_id;
            $staff_info->staff_birthdate = $request->staff_birthdate;
            $staff_info->staff_expiredate = $request->staff_expiredate;
            $staff_info->staff_addr = $request->staff_addr;
            $staff_info->staff_phone = $request->staff_phone;
            $staff_info->credit_limit = $request->credit_limit;
            if ($staff_info->save()) {
                Log::channel('activity')
                    ->info(session('auth_user.user_id') .  'Successfully updated staff: ' . $id, [
                        'staff_id' => $id,
                        'staff_name' => $request->staff_name,
                        'action' => 'update',
                        'update detail' => $request->all(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                        'updated_by' => session('auth_user.user_id'),
                    ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.edit_is_success'));
                return redirect()->route('staff.index');
            } else {
                Log::channel('activity')
                    ->error(session('auth_user.user_id') .  'Failed to update staff: ' . $id, [
                        'staff_id' => $id,
                        'staff_name' => $request->staff_name,
                        'action' => 'update',
                        'update detail' => $request->all(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                        'updated_by' => session('auth_user.user_id'),
                    ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.edit_is_failed'));
                return redirect()->route('staff.edit', $id);
            }
        } catch (\Exception $e) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') .  'Failed to update staff: ' . $id, [
                    'staff_id' => $id,
                    'staff_name' => $request->staff_name,
                    'action' => 'update',
                    'update detail' => $request->all(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('staff.edit', $id);
        }
    }
    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 35)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Staff Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Staff Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $db_delete = DB::table('staff_info')
            ->where('staff_id', $id)
            ->update([
                'activeflag' => 0
            ]);
        if (isset($db_delete)) {
            Log::channel('activity')
                ->notice(session('auth_user.user_id') .  'Deleted staff: ' . $id, [
                    'staff_id' => $id,
                    'action' => 'delete',
                    'deleted_at' => Carbon::now()->toDateTimeString(),
                    'deleted_by' => session('auth_user.user_id'),
                ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('staff.index');
        } else {
            Log::channel('activity')
                ->error(session('auth_user.user_id') .  'Failed to delete staff: ' . $id, [
                    'staff_id' => $id,
                    'action' => 'delete',
                    'deleted_at' => Carbon::now()->toDateTimeString(),
                    'deleted_by' => session('auth_user.user_id'),
                ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('staff.index');
        }
    }
    private function byteCrc(int $data, int &$crc): void
    {
        $crc ^= ($data << 8) & 0xFFFF;

        for ($i = 0; $i < 8; $i++) {
            if (($crc & 0x8000) !== 0) {
                $crc = (($crc << 1) & 0xFFFF) ^ 0x1021;
            } else {
                $crc = ($crc << 1) & 0xFFFF;
            }
        }
    }

    private function stringCrc(string $s): int
    {
        $crc = 0;
        $len = strlen($s);

        for ($i = 0; $i < $len; $i++) {
            $this->byteCrc(ord($s[$i]), $crc);
        }

        return $crc;
    }

    private function checkSum(string $cardNo): string
    {
        $buf = $this->stringCrc($cardNo);

        $hex = strtoupper(str_pad(dechex($buf), 4, '0', STR_PAD_LEFT));

        $buf1 = hexdec(substr($hex, 0, 2));
        $buf2 = hexdec(substr($hex, 2, 2));

        $checksum = ($buf1 ^ $buf2) % 100;

        return str_pad((string)$checksum, 2, '0', STR_PAD_LEFT);
    }
}
