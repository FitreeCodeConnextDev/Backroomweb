<?php

namespace App\Http\Controllers;

use App\Models\MemberModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\PermissionHelper;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 1)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access to Member Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Member Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();

            // abort(401, 'You do not have access to this page.');
        }
        $lengthCard = DB::table('system_info')->value('lengthcard');
        $member_data = DB::table('member_info')
            ->select('member_id', 'member_name')
            ->where('activeflag', '=', 1)
            ->orderBy('member_id', 'asc')
            ->get();
        return view('pages.member.index', compact('member_data', 'lengthCard'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 3)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Create Member', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'create',
                'page' => 'Member Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }

        $lengthCard = DB::table('system_info')->value('lengthcard');
        if (session('auth_user.branch_id') == 000000) {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->select('branch_id')->get();
        } else {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->where('branch_id', session('auth_user.branch_id'))->select('branch_id')->get();
        }
        return view('pages.member.create', compact('lengthCard', 'branch_id'));
    }

    public function store(MemberRequest $request)
    {
        try {
            $member_expire = Carbon::parse($request->member_expiredate)->format('Y-m-d');
            $member_birthdate = Carbon::parse($request->member_birthdate)->format('Y-m-d');
            $checksum = $this->checkSum($request->card_no);
            $member_card_no = $request->card_no . $checksum;

            $member_info = new MemberModel();
            $member_info->member_id = $request->member_id;
            $member_info->member_name = $request->member_name;
            $member_info->branch_id = $request->branch_id;
            $member_info->member_license = $request->member_license;
            $member_info->member_expiredate = $member_expire;
            $member_info->member_birthdate = $member_birthdate;
            $member_info->member_addr = $request->member_addr;
            $member_info->member_phone = $request->member_phone;
            $member_info->card_no = $member_card_no;
            $member_info->issue_date = Carbon::now()->toDateTimeString();
            $member_info->credit_amt = 0;
            $member_info->credit_limit = 0;
            $member_info->lastpayment_amt = 0;
            $member_info->activeflag = 1;

            if ($member_info->save()) {
                Log::channel('activity')->info(session('auth_user.user_id') . ' Member Inserted: ' . $request->member_name, [
                    'member_id' => $member_info->member_id,
                    'member_name' => $request->member_name,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.save_is_success'));
                return redirect()->route('member.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' Member Insert Failed: ' . $member_info->getChanges(), [
                    'action' => 'insert',
                    'insert detail' => $member_info->getChanges(),
                    'error_message' => 'Insert Failed',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.save_is_failed'));
                return redirect()->route('member.create');
            }
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Insert Failed: ' . $request->member_name, [
                'action' => 'insert',
                'insert detail' => $request->all(),
                'error_message' => $e->getMessage(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('member.create');
        }
    }


    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 4)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Edit Member', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'edit',
                'page' => 'Member Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $member_data = DB::table('member_info')->where('member_id', $id)->first();
        $card_sub = DB::table('cardsub_info')
            ->selectRaw('(cur_amt + adj_amt - use_amt) as net')
            ->where('card_no', '=', $member_data->card_no)
            ->first();

        $use_card_member_daily = DB::table('sale_terminal_daily as a')
            ->join('vendor_info as b', 'a.vendor_id', '=', 'b.vendor_id')
            ->select(
                'a.txndate',
                'a.term_id',
                'b.vendor_name',
                'a.amount'
            )
            ->where('a.card_no', $member_data->card_no)
            ->where('a.void_flag', '0')
            ->orderBy('a.txndate', 'desc')
            ->get();
        $use_card_backup = DB::table('cardsub_info')

            ->select(
                'issuedate',
                'lastusedate',
                'lastadjustdate',
            )
            ->where('card_no', $member_data->card_no)
            ->orderBy('issuedate', 'desc')
            ->get();

        Log::channel('activity')->info('Member Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'member data' => $member_data,
            'page' => 'Member Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        $lengthCard = DB::table('system_info')->value('lengthcard');
        if (session('auth_user.branch_id') == 000000) {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->select('branch_id')->get();
        } else {
            $branch_id = DB::table('branch_info')->where('activeflag', 1)->where('branch_id', session('auth_user.branch_id'))->select('branch_id')->get();
        }

        return view('pages.member.edit', compact('member_data', 'card_sub', 'use_card_member_daily', 'use_card_backup', 'lengthCard', 'branch_id'));
    }
    public function update(Request $request, $id)
    {
        try {
            $member_expire = Carbon::parse($request->member_expiredate)->format('Y-m-d');
            $member_birthdate = Carbon::parse($request->member_birthdate)->format('Y-m-d');

            $member_info = MemberModel::find($id);
            $member_info->member_name = $request->member_name;
            $member_info->branch_id = $request->branch_id;
            $member_info->member_license = $request->member_license;
            $member_info->member_expiredate = $member_expire;
            $member_info->member_birthdate = $member_birthdate;
            $member_info->member_addr = $request->member_addr;
            $member_info->member_phone = $request->member_phone;

            if ($member_info->save()) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Member Updated: ' . $request->member_name, [
                    'member_id' => $id,
                    'member_name' => $request->member_name,
                    'action' => 'update',
                    'update detail' => $request->all(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.edit_is_success'));
                return redirect()->route('member.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' Member Update Failed: ' . $request->member_name, [
                    'member_id' => $id,
                    'member_name' => $request->member_name,
                    'action' => 'update',
                    'update detail' => $request->all(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.edit_is_failed'));
                return redirect()->route('member.index');
            }
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Update Failed: ' . $request->member_name, [
                'member_id' => $id,
                'member_name' => $request->member_name,
                'action' => 'update',
                'error' => $e->getMessage(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('member.index');
        }
    }
    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 5)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Delete Member', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'delete',
                'page' => 'Member Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        try {
            $member_info = MemberModel::find($id);
            $member_info->activeflag = 0;
            if ($member_info->save()) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Member Deleted: ' . $id, [
                    'member_id' => $id,
                    'action' => 'delete',
                    'deleted_at' => Carbon::now()->toDateTimeString(),
                    'deleted_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.delete_is_success'));
                return redirect()->route('member.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' Member Delete Failed: ' . $id, [
                    'member_id' => $id,
                    'action' => 'delete',
                    'deleted_at' => Carbon::now()->toDateTimeString(),
                    'deleted_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.delete_is_failed'));
                return redirect()->route('member.index');
            }
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Delete Failed: ' . $id, [
                'member_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('member.index');
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
