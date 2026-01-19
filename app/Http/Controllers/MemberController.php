<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\PermissionHelper;

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
        return view('pages.member.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $valida_data = $request->validate([
            'member_id' => 'required|max:10|unique:member_info,member_id',
            'member_name' => 'required',
            'member_license' => 'nullable|min:13|max:13',
            'member_expire' => 'nullable',
            'member_birthdate' => 'nullable',
            'member_addr' => 'nullable',
            'member_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',
            'card_no' => 'required|digits:11',

        ], [
            'member_id.required' => __('member.member_id_valid'),
            'member_id.max' => __('member.member_id_valid_max'),
            'member_id.unique' => __('member.member_id_unique'),
            'member_name.required' => __('member.member_name_valid'),
            'member_license.required' => __('member.member_license_valid'),
            'member_license.min' => __('member.member_license_valid_min'),
            'member_license.max' => __('member.member_license_valid_max'),
            'member_license.num' => __('member.member_license_valid_num'),
            'member_expire.required' => __('member.member_expire_valid'),
            'member_birthdate.required' => __('member.member_birthdate_valid'),
            'member_addr.required' => __('member.member_addr_valid'),
            'member_phone.required' => __('member.member_phone_valid'),
            'member_phone.regex' => __('member.member_phone_valid_num'),
            'card_no.required' => __('member.card_no_valid'),
            'card_no.digits' => __('member.card_no_digits'),

        ]);

        $member_expire = Carbon::parse($valida_data['member_expire'])->format('Y-m-d');
        $member_birthdate = Carbon::parse($valida_data['member_birthdate'])->format('Y-m-d');
        $checksum = $this->checkSum($valida_data['card_no']);
        $checksum_card_no = $valida_data['card_no'] = $valida_data['card_no'] . $checksum;

        try {
            DB::table('member_info')->insert([
                'member_id' => $valida_data['member_id'],
                'member_name' => $valida_data['member_name'],
                'member_license' => $valida_data['member_license'],
                'member_expiredate' => $member_expire,
                'member_birthdate' => $member_birthdate,
                'member_addr' => $valida_data['member_addr'],
                'member_phone' => $valida_data['member_phone'],
                'card_no' => $checksum_card_no,
                'activeflag' => 1
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('member.index');
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Insert Failed: ' . $valida_data['member_name'], [
                'member_id' => $valida_data['member_id'],
                'member_name' => $valida_data['member_name'],
                'action' => 'insert',
                'insert detail' => $valida_data,
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
        $use_card = DB::table('sale_terminal_backup as A')
            ->join('vendor_info as B', 'A.vendor_id', '=', 'B.vendor_id')
            ->join('member_info as M', 'A.card_no', '=', 'M.card_no')
            ->select('A.txndate', 'B.vendor_name', 'A.amount')
            ->where('A.void_flag', '=', '0')
            ->get();
        // dd($use_card);
        Log::channel('activity')->info('Member Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'member data' => $member_data,
            'page' => 'Member Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        $lengthCard = DB::table('system_info')->value('lengthcard');

        return view('pages.member.edit', compact('member_data', 'card_sub', 'use_card', 'lengthCard'));
    }
    public function update(Request $request, $id)
    {
        $valida_data = $request->validate([
            'member_name' => 'required',
            'member_license' => 'nullable|min:13|max:13',
            'member_expire' => 'nullable',
            'member_birthdate' => 'nullable',
            'member_addr' => 'nullable',
            'member_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

        ], [
            'member_name.required' => __('member.member_name_valid'),
            'member_license.required' => __('member.member_license_valid'),
            'member_license.min' => __('member.member_license_valid_min'),
            'member_license.max' => __('member.member_license_valid_max'),
            'member_license.num' => __('member.member_license_valid_num'),
            'member_expire.required' => __('member.member_expire_valid'),
            'member_birthdate.required' => __('member.member_birthdate_valid'),
            'member_addr.required' => __('member.member_addr_valid'),
            'member_phone.required' => __('member.member_phone_valid'),
            'member_phone.regex' => __('member.member_phone_valid_num'),

        ]);
        $member_expire = Carbon::parse($valida_data['member_expire'])->format('Y-m-d');
        $member_birthdate = Carbon::parse($valida_data['member_birthdate'])->format('Y-m-d');
        $member_data = DB::table('member_info')->where('member_id', $id)->first();

        if ($member_data->card_no != $valida_data['card_no']) {
            $checksum = $this->checkSum($valida_data['card_no']);
            $valida_data['card_no'] = $valida_data['card_no'] . $checksum;
        }

        try {
            DB::table('member_info')
                ->where('member_id', $id)
                ->update([
                    'member_name' => $valida_data['member_name'],
                    'member_license' => $valida_data['member_license'],
                    'member_expiredate' => $member_expire,
                    'member_birthdate' => $member_birthdate,
                    'member_addr' => $valida_data['member_addr'],
                    'member_phone' => $valida_data['member_phone'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Member Updated: ' . $valida_data['member_name'], [
                'member_id' => $id,
                'member_name' => $valida_data['member_name'],
                'action' => 'update',
                'update detail' => $valida_data,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('member.index');
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Update Failed: ' . $valida_data['member_name'], [
                'member_id' => $id,
                'member_name' => $valida_data['member_name'],
                'action' => 'update',
                'update detail' => $valida_data,
                'error_message' => $e->getMessage(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('member.create');
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
            $delete_member = DB::table('member_info')
                ->where('member_id', $id)
                ->update([
                    'activeflag' => 0,
                ]);
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
        } catch (\Exception $e) {
            log::channel('activity')->error(session('auth_user.user_id') . ' Member Delete Failed: ' . $id, [
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
