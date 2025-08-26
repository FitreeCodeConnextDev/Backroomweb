<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
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
        return view('pages.staff.create');
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate(
            [
                'staff_id' => 'required|max:10|unique:staff_info,staff_id',
                'staff_name' => 'required',
                'staff_type' => 'nullable',
                'staff_license' => 'nullable|max:13',
                'staff_birthdate' => 'nullable',
                'staff_expiredate' => 'nullable',
                'staff_addr' => 'nullable',
                'staff_phone' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',
                'staff_limit' => 'nullable',
            ],
            [
                'staff_id' => __('staff.staff_id_required'),
                'staff_id.max' => __('staff.staff_id_valid_max'),
                'staff_id.unique' => __('staff.staff_id_valid_unique'),
                'staff_name' => __('staff.staff_name_required'),
                'staff_type' => __('staff.staff_type_required'),
                'staff_license' => __('staff.staff_license_required'),
                'staff_license.max' => __('staff.staff_license_max'),
                'staff_birthdate' => __('staff.staff_birthdate_required'),
                'staff_expiredate' => __('staff.staff_expiredate_required'),
                'staff_addr' => __('staff.staff_addr_required'),
                'staff_phone' => __('staff.staff_phone_required'),
                'staff_phone.regex' => __('staff.staff_phone_num'),
                'staff_limit' => __('staff.staff_limit_required'),
            ]
        );

        $staff_birthdate = Carbon::parse($validate_data['staff_birthdate'])->format('Y-m-d');
        $staff_expiredate = Carbon::parse($validate_data['staff_expiredate'])->format('Y-m-d');
        // dd($validate_data);
        $staff_insert = DB::table('staff_info')
            ->insert([
                'staff_id' => $validate_data['staff_id'],
                'staff_name' => $validate_data['staff_name'],
                'staff_type' => $validate_data['staff_type'],
                'staff_license' => $validate_data['staff_license'],
                'staff_birthdate' => $staff_birthdate,
                'staff_expiredate' =>  $staff_expiredate,
                'staff_addr' => $validate_data['staff_addr'],
                'staff_phone' => $validate_data['staff_phone'],
                'credit_limit' => $validate_data['staff_limit'],
                'activeflag' => 1,
            ]);

        if (isset($staff_insert)) {
            Log::channel('activity')
                ->notice(session('auth_user.user_id') .  'Created new staff: ' . $validate_data['staff_id'], [
                    'staff_id' => $validate_data['staff_id'],
                    'staff_name' => $validate_data['staff_name'],
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
                ->error(session('auth_user.user_id') .  'Failed to create staff: ' . $validate_data['staff_id'], [
                    'staff_id' => $validate_data['staff_id'],
                    'staff_name' => $validate_data['staff_name'],
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
        $staff_data = DB::table('staff_info')
            ->where('staff_id', $id)
            ->first();
        $card_sub = DB::table('cardsub_info')
            ->selectRaw('(cur_amt + adj_amt - use_amt) as net')
            ->where('card_no', '=', $staff_data->card_no)
            ->first();
        $use_card = DB::table('sale_terminal_backup as A')
            ->join('vendor_info as B', 'A.vendor_id', '=', 'B.vendor_id')
            ->join('member_info as M', 'A.card_no', '=', 'M.card_no')
            ->select('A.txndate', 'B.vendor_name', 'A.amount')
            ->where('A.void_flag', '=', '0')
            ->get();

        // dd($card_sub, $result);
        Log::channel('activity')->info('Staff Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'staff_data' => $staff_data,
            'card_sub' => $card_sub,
            'use_card' => $use_card,
            'page' => 'Staff Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.staff.edit', compact('staff_data', 'card_sub', 'use_card'));
    }

    public function update(Request $request, $id)
    {
        $validate_data = $request->validate(
            [
                'staff_name' => 'required',
                'staff_type' => 'required',
                'staff_license' => 'required|max:13',
                'staff_birthdate' => 'required',
                'staff_expiredate' => 'required',
                'staff_addr' => 'required',
                'staff_phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',
                'staff_limit' => 'required',
            ],
            [
                'staff_name' => __('staff.staff_name_required'),
                'staff_type' => __('staff.staff_type_required'),
                'staff_license' => __('staff.staff_license_required'),
                'staff_license.max' => __('staff.staff_license_max'),
                'staff_birthdate' => __('staff.staff_birthdate_required'),
                'staff_expiredate' => __('staff.staff_expiredate_required'),
                'staff_addr' => __('staff.staff_addr_required'),
                'staff_phone' => __('staff.staff_phone_required'),
                'staff_phone.regex' => __('staff.staff_phone_num'),
                'staff_limit' => __('staff.staff_limit_required'),
            ]
        );

        $staff_birthdate = Carbon::parse($validate_data['staff_birthdate'])->format('Y-m-d');
        $staff_expiredate = Carbon::parse($validate_data['staff_expiredate'])->format('Y-m-d');
        if (isset($validate_data)) {
            $db_update = DB::table('staff_info')
                ->where('staff_id', $id)
                ->update([
                    'staff_name' => $validate_data['staff_name'],
                    'staff_type' => $validate_data['staff_type'],
                    'staff_license' => $validate_data['staff_license'],
                    'staff_birthdate' => $staff_birthdate,
                    'staff_expiredate' => $staff_expiredate,
                    'staff_addr' => $validate_data['staff_addr'],
                    'staff_phone' => $validate_data['staff_phone'],
                    'credit_limit' => $validate_data['staff_limit'],
                ]);
            if (isset($db_update)) {
                Log::channel('activity')
                    ->notice(session('auth_user.user_id') .  'Updated staff: ' . $id, [
                        'staff_id' => $id,
                        'staff_name' => $validate_data['staff_name'],
                        'action' => 'update',
                        'update detail' => $validate_data,
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
                        'staff_name' => $validate_data['staff_name'],
                        'action' => 'update',
                        'update detail' => $validate_data,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                        'updated_by' => session('auth_user.user_id'),
                    ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.edit_is_failed'));
                return redirect()->route('staff.edit', ['id' => $id]);
            }
        } else {
            Log::channel('activity')
                ->error(session('auth_user.user_id') .  'Failed to validate staff data: ' . $id, [
                    'staff_id' => $id,
                    'action' => 'validate',
                    'validated_at' => Carbon::now()->toDateTimeString(),
                    'validated_by' => session('auth_user.user_id'),
                ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error('เกิดข้อผิดพลาดในการรับข้อมูล');
            return redirect()->route('staff.edit', ['id' => $id]);
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
}
