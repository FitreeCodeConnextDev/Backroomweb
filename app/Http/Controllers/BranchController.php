<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 6)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Branch Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Branch Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $branch_data = DB::table('branch_info')->where('activeflag', 1)->get();
        return view('pages.branch.index', compact('branch_data'));
    }
    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 18)) {
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
        return view('pages.branch.create');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'branch_id' => 'required|max:6|unique:branch_info,branch_id',
            'branch_name' => 'required',
            'online' => 'required',
            'branch_addr1' => 'required',
            'branch_addr2' => 'nullable',
            'branch_tel' => 'required',
            'tax_id' => 'required',
            'tax_name' => 'required',
            'tax_addr1' => 'required',
            'tax_addr2' => 'nullable',
            'tax_name_e' => 'nullable',
            'tax_addr1_e' => 'nullable',
            'tax_addr2_e' => 'nullable',
            'ipaddress' => 'nullable',
            'batchno' => 'required',
            'businessdate' => 'required',
            'deposit' => 'required',
            'vatrate' => 'required',
            'message1' => 'nullable',
            'message2' => 'nullable',
            'message3' => 'nullable',
            'message4' => 'nullable',
        ], [
            'branch_id.required' => __('branch.branch_id_required'),
            'branch_id.max' => __('branch.branch_id_max'),
            'branch_id.unique' => __('branch.branch_id_unique'),
            'branch_name.required' => __('branch.branch_name_required'),
            'online.required' => __('branch.online_required'),
            'branch_addr1.required' => __('branch.branch_addr1_required'),
            'branch_tel.required' => __('branch.branch_tel_required'),
            'tax_id.required' => __('branch.tax_id_required'),
            'tax_name.required' => __('branch.tax_name_required'),
            'tax_addr1.required' => __('branch.tax_addr1_required'),
            'batchno.required' => __('branch.batchno_required'),
            'businessdate.required' => __('branch.businessdate_required'),
            'deposit.required' => __('branch.deposit_required'),
            'vatrate.required' => __('branch.vatrate_required'),
        ]);

        if (isset($validateData)) {
            $insert_branch = DB::table('branch_info')
                ->insert([
                    'branch_id' => $validateData['branch_id'],
                    'branch_name' => $validateData['branch_name'],
                    'online' => $validateData['online'],
                    'branch_addr1' => $validateData['branch_addr1'],
                    'branch_addr2' => $validateData['branch_addr2'],
                    'branch_tel' => $validateData['branch_tel'],
                    'tax_id' => $validateData['tax_id'],
                    'tax_name' => $validateData['tax_name'],
                    'tax_addr1' => $validateData['tax_addr1'],
                    'tax_addr2' => $validateData['tax_addr2'],
                    'tax_name_e' => $validateData['tax_name_e'],
                    'tax_addr1_e' => $validateData['tax_addr1_e'],
                    'tax_addr2_e' => $validateData['tax_addr2_e'],
                    'ipaddress' => $validateData['ipaddress'],
                    'batchno' => $validateData['batchno'],
                    'businessdate' => Carbon::parse($validateData['businessdate'])->format('Y-m-d H:i:s'),
                    'activeflag' => 1,
                    'message_1' => $validateData['message1'],
                    'message_2' => $validateData['message2'],
                    'message_3' => $validateData['message3'],
                    'message_4' => $validateData['message4'],
                ]);
            $inser_system = DB::table('system_info')
                ->insert([
                    'branch_id' => $validateData['branch_id'],
                    'expire_card' => 0,
                    'expire_membercard' => 0,
                    'expire_staffcard' => 0,
                    'useonly_branch' => 'Y',
                    'expire_checkby' => 1,
                    'lengthcard' => 9,
                    'deposit' => $validateData['deposit'],
                    'balance_amt' => 0,
                    'balance_point' => 0,
                    'balancedebt_amt' => 0,
                    'balancedebt_point' => 0,
                    'vatrate' => $validateData['vatrate'],
                    'erp_file1' => null,
                    'erp_file2' => null,
                    'erp_branch' => null,
                    'erp_drive' => null,
                    'postvendor' => '000000',
                ]);
            if ($insert_branch && $inser_system) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' created a new branch: ' . $validateData['branch_name'] . json_encode([
                    'branch_id' => $validateData['branch_id'],
                    'branch_name' => $validateData['branch_name'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]));
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.save_is_success'));
                return redirect()->route('branch.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create a new branch: ' . $validateData['branch_name'] . json_encode([
                    'branch_id' => $validateData['branch_id'],
                    'branch_name' => $validateData['branch_name'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]));
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.save_is_failed'));
                return redirect()->route('branch.create');
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create a new branch due to validation errors: ' . json_encode([
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('branch.create');
        }

        // dd($validateData);
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 19)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Branch Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Branch Index',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $branch = DB::table('branch_info')
            ->join('system_info', 'branch_info.branch_id', '=', 'system_info.branch_id')
            ->where('branch_info.branch_id', $id)
            ->first();
        log::channel('activity')->info(session('auth_user.user_id') . ' Accessed Branch Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'access',
            'page' => 'Branch Edit Page',
            'branch_id' => $id,
            'branch_data' => $branch, 
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        // dd($branch);
        return view('pages.branch.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'branch_name' => 'required',
            'online' => 'required',
            'branch_addr1' => 'required',
            'branch_addr2' => 'nullable',
            'branch_tel' => 'required',
            'tax_id' => 'required',
            'tax_name' => 'required',
            'tax_addr1' => 'required',
            'tax_addr2' => 'nullable',
            'tax_name_e' => 'nullable',
            'tax_addr1_e' => 'nullable',
            'tax_addr2_e' => 'nullable',
            'ipaddress' => 'nullable',
            'batchno' => 'required',
            'businessdate' => 'required',
            'deposit' => 'required',
            'vatrate' => 'required',
            'message1' => 'nullable',
            'message2' => 'nullable',
            'message3' => 'nullable',
            'message4' => 'nullable',
        ]);
        // dd($validateData);

        $branch_update = DB::table('branch_info')
            ->where('branch_id', $id)
            ->update([
                'branch_name' => $validateData['branch_name'],
                'online' => $validateData['online'],
                'branch_addr1' => $validateData['branch_addr1'],
                'branch_addr2' => $validateData['branch_addr2'],
                'branch_tel' => $validateData['branch_tel'],
                'tax_id' => $validateData['tax_id'],
                'tax_name' => $validateData['tax_name'],
                'tax_addr1' => $validateData['tax_addr1'],
                'tax_addr2' => $validateData['tax_addr2'],
                'tax_name_e' => $validateData['tax_name_e'],
                'tax_addr1_e' => $validateData['tax_addr1_e'],
                'tax_addr2_e' => $validateData['tax_addr2_e'],
                'ipaddress' => $validateData['ipaddress'],
                'batchno' => $validateData['batchno'],
                'message_1' => $validateData['message1'],
                'message_2' => $validateData['message2'],
                'message_3' => $validateData['message3'],
                'message_4' => $validateData['message4'],
            ]);

        $system_info_update = DB::table('system_info')
            ->where('branch_id', $id)
            ->update([
                'deposit' => $validateData['deposit'],
                'vatrate' => $validateData['vatrate'],
            ]);

        if (isset($branch_update, $system_info_update)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated branch: ' . $validateData['branch_name'] . json_encode([
                'branch_id' => $id,
                'branch_name' => $validateData['branch_name'],
                'action' => 'update',
                'details update' => $validateData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('branch.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update branch: ' . $validateData['branch_name'] . json_encode([
                'branch_id' => $id,
                'branch_name' => $validateData['branch_name'],
                'action' => 'update',
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('branch.index');
        }
    }
    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 20)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Branch Delete', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Branch Index',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }

        $delete_branch = DB::table('branch_info')->where('branch_id', $id)
            ->update(['activeflag' => 0]);

        if (isset($delete_branch)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Deleted branch: ' . $id . json_encode([
                'branch_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('branch.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete branch: ' . $id . json_encode([
                'branch_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('branch.index');
        }
    }
}
