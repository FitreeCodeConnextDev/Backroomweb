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
        $member_data = DB::table('member_info')
            ->select('member_id', 'member_name')
            ->where('activeflag', '=', 1)
            ->orderBy('member_id', 'asc')
            ->get();
        return view('pages.member.index', compact('member_data'));
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
        $valida_data = $request->validate([
            'member_id' => 'required|max:10|unique:member_info,member_id',
            'member_name' => 'required',
            'member_license' => 'nullable|min:13|max:13',
            'member_expire' => 'nullable',
            'member_birthdate' => 'nullable',
            'member_addr' => 'nullable',
            'member_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

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

        ]);
        // dd($valida_data);
        $member_expire = Carbon::parse($valida_data['member_expire'])->format('Y-m-d');
        $member_birthdate = Carbon::parse($valida_data['member_birthdate'])->format('Y-m-d');

        $member_insert = DB::table('member_info')->insert([
            'member_id' => $valida_data['member_id'],
            'member_name' => $valida_data['member_name'],
            'member_license' => $valida_data['member_license'],
            'member_expiredate' => $member_expire,
            'member_birthdate' => $member_birthdate,
            'member_addr' => $valida_data['member_addr'],
            'member_phone' => $valida_data['member_phone'],
            'activeflag' => 1,
        ]);

        if (isset($member_insert)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Member Created: ' . $valida_data['member_name'], [
                'member_id' => $valida_data['member_id'],
                'member_name' => $valida_data['member_name'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('member.index');
        } else {
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

        return view('pages.member.edit', compact('member_data', 'card_sub', 'use_card'));
    }
    public function update(Request $request, $id)
    {
        $valida_data = $request->validate([
            'member_name' => 'required',
            'member_license' => 'required|min:13|max:13',
            'member_expire' => 'required',
            'member_birthdate' => 'required',
            'member_addr' => 'required',
            'member_phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

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
        $member_update = DB::table('member_info')
            ->where('member_id', $id)
            ->update([
                'member_name' => $valida_data['member_name'],
                'member_license' => $valida_data['member_license'],
                'member_expiredate' => $member_expire,
                'member_birthdate' => $member_birthdate,
                'member_addr' => $valida_data['member_addr'],
                'member_phone' => $valida_data['member_phone'],
            ]);
        if (isset($member_update)) {
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
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Member Update Failed: ' . $valida_data['member_name'], [
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
        $delete_member = DB::table('member_info')
            ->where('member_id', $id)
            ->update([
                'activeflag' => 0,
            ]);
        if (isset($delete_member)) {
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
}
