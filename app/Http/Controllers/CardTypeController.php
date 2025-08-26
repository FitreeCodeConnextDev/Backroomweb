<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CardTypeController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 8)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Type Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Type Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $card_type = DB::table('sub_info')
            ->select('subno', 'subdesc')
            ->where('activeflag', "=", '1')
            ->get();
        return view('pages.card_type.index', compact('card_type'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 24)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Branch Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Branch Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.card_type.create');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'subno' => 'required|max:3|unique:sub_info,subno',
                'subdesc' => 'required',
                'expire_day' => 'required|numeric',
                'deposit' => 'required|numeric',

            ],
            [
                'subno.required' => __('card_type.subno_valid'),
                'subno.max' => __('card_type.subno_valid_max'),
                'subno.unique' => __('card_type.subno_valid_unique'),
                'subdesc.required' => __('card_type.expire_day_valid'),
                'expire_day.required' => __('card_type.expire_day_valid'),
                'expire_day.numeric' => __('card_type.expire_num_valid'),
                'deposit.required' => __('card_type.deposit_valid'),
                'deposit.numeric' => __('card_type.deposit_num_valid'),

            ]
        );
        $card_type = DB::table('sub_info')->insert([
            'subno' => $validateData['subno'],
            'subdesc' => $validateData['subdesc'],
            'expire_day' => $validateData['expire_day'],
            'deposit' => $validateData['deposit'],
            'uselevel1' => 'N',
            'uselevel2' => 'N',
            'uselevel3' => 'N',
            'uselevel4' => 'N',
            'uselevel5' => 'N',
            'limit_level2' => 0,
            'limit_level3' => '0.00',
            'limit_level4btime' => Carbon::now(),
            'limit_level4etime' => Carbon::now(),
            'limit_level5bdate' => Carbon::now(),
            'limit_level5edate' => Carbon::now(),
            'activeflag' => 1,
        ]);

        if (isset($card_type)) {
            Log::channel('card_type')->notice(session('auth_user.user_id') . ' Card Type Created: ' . $validateData['subdesc'], [
                'subno' => $validateData['subno'],
                'subdesc' => $validateData['subdesc'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()

                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('card-type.index');
        } else {
            Log::channel('card_type')->error(session('auth_user.user_id') . ' Card Type Create Failed: ' . $validateData['subdesc'], [
                'subno' => $validateData['subno'],
                'subdesc' => $validateData['subdesc'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('card-type.create');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 25)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Type Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Type Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $card_type = DB::table('sub_info')->where('subno', $id)->first();
        log::channel('activity')->info(session('auth_user.user_id') . ' Accessed Card Type Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'access',
            'page' => 'Card type Edit Page',
            'branch_data' => $card_type,
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.card_type.edit', compact('card_type'));
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate(
            [
                'subdesc' => 'required',
                'expire_day' => 'required|numeric',
                'deposit' => 'required|numeric',

            ],
            [
                'subdesc.required' => __('card_type.expire_day_valid'),
                'expire_day.required' => __('card_type.expire_day_valid'),
                'expire_day.numeric' => __('card_type.expire_num_valid'),
                'deposit.required' => __('card_type.deposit_valid'),
                'deposit.numeric' => __('card_type.deposit_num_valid'),

            ]
        );
        $card_type_update = DB::table('sub_info')
            ->where('subno', $id)
            ->update([
                'subdesc' => $validateData['subdesc'],
                'expire_day' => $validateData['expire_day'],
                'deposit' => $validateData['deposit'],
            ]);
        if ($card_type_update) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Card Type Updated: ' . $validateData['subdesc'], [
                'subno' => $id,
                'subdesc' => $validateData['subdesc'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('card-type.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Card Type Update Failed: ' . $validateData['subdesc'], [
                'subno' => $id,
                'subdesc' => $validateData['subdesc'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('card-type.index');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 26)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Type Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Type Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $card_type_delete = DB::table('sub_info')->where('subno', $id)->update([
            'activeflag' => 0,
        ]);
        if ($card_type_delete) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Card Type Deleted: ' . $id, [
                'subno' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('card-type.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Card Type Delete Failed: ' . $id, [
                'subno' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('card-type.index');
        }
    }
}
