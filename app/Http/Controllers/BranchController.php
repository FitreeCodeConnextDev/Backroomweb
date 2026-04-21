<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use App\Http\Requests\BranchRequest;
use App\Models\BranchModel;
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
        $close_batch = DB::table('closeendday')
            ->select('batch', 'businessdate', 'batchdate')
            ->orderBy('batch', 'desc')
            ->limit(1)
            ->get();
        return view('pages.branch.create', compact('close_batch'));
    }
    public function store(BranchRequest $request)
    {
        try {
            $branch = new BranchModel();
            $branch->branch_id = $request->branch_id;
            $branch->branch_name = $request->branch_name;
            $branch->online = $request->online;
            $branch->branch_addr1 = $request->branch_addr1;
            $branch->branch_addr2 = $request->branch_addr2;
            $branch->branch_tel = $request->branch_tel;
            $branch->tax_id = $request->tax_id;
            $branch->tax_name = $request->tax_name;
            $branch->tax_addr1 = $request->tax_addr1;
            $branch->tax_addr2 = $request->tax_addr2;
            $branch->tax_name_e = $request->tax_name_e;
            $branch->tax_addr1_e = $request->tax_addr1_e;
            $branch->tax_addr2_e = $request->tax_addr2_e;
            $branch->tax_branchseq = $request->tax_branchseq;
            $branch->ipaddress = $request->ipaddress;
            $branch->batchno = $request->batchno;
            $branch->businessdate = $request->businessdate;
            $branch->batchdate = $request->batchdate;
            $branch->message_1 = $request->message_1;
            $branch->message_2 = $request->message_2;
            $branch->message_3 = $request->message_3;
            $branch->message_4 = $request->message_4;
            $branch->activeflag = 1;
            $branch->save();
            DB::table('system_info')
                ->insert([
                    'branch_id' => $request->branch_id,
                    'expire_card' => 0,
                    'expire_membercard' => 0,
                    'expire_staffcard' => 0,
                    'useonly_branch' => 'Y',
                    'expire_checkby' => 1,
                    'lengthcard' => 9,
                    'deposit' => $request->deposit,
                    'balance_amt' => 0,
                    'balance_point' => 0,
                    'balancedebt_amt' => 0,
                    'balancedebt_point' => 0,
                    'vatrate' => $request->vatrate,
                    'erp_file1' => null,
                    'erp_file2' => null,
                    'erp_branch' => null,
                    'erp_drive' => null,
                    'postvendor' => '000000',
                ]);

            Log::channel('activity')->notice(session('auth_user.user_id') . ' created branch: ' . $request->branch_name . json_encode([
                'branch_id' => $branch->id,
                'branch_name' => $request->branch_name,
                'action' => 'create',
                'details create' => $request->all(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.create_is_success'));
            return redirect()->route('branch.index');
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Error creating branch: ' . $e->getMessage() . json_encode([
                'action' => 'create',
                'details create' => $request->all(),
                'error' => $e->getMessage(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.create_is_failed'));
            return redirect()->back();
        }
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

    public function update(BranchRequest $request, $id)
    {
        try {
            $branch = BranchModel::where('branch_id', $id)->first();
            $branch->branch_name = $request->branch_name;
            $branch->online = $request->online;
            $branch->branch_addr1 = $request->branch_addr1;
            $branch->branch_addr2 = $request->branch_addr2;
            $branch->branch_tel = $request->branch_tel;
            $branch->tax_id = $request->tax_id;
            $branch->tax_name = $request->tax_name;
            $branch->tax_addr1 = $request->tax_addr1;
            $branch->tax_addr2 = $request->tax_addr2;
            $branch->tax_name_e = $request->tax_name_e;
            $branch->tax_addr1_e = $request->tax_addr1_e;
            $branch->tax_addr2_e = $request->tax_addr2_e;
            $branch->tax_branchseq = $request->tax_branchseq;
            $branch->ipaddress = $request->ipaddress;
            $branch->batchno = $request->batchno;
            $branch->businessdate = $request->businessdate;
            $branch->message_1 = $request->message_1;
            $branch->message_2 = $request->message_2;
            $branch->message_3 = $request->message_3;
            $branch->message_4 = $request->message_4;
            $branch->activeflag = 1;
            $branch->save();
            DB::table('system_info')
                ->where('branch_id', $id)
                ->update([
                    'deposit' => $request->deposit,
                    'vatrate' => $request->vatrate,
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated branch: ' . $request->branch_name . json_encode([
                'branch_id' => $branch->id,
                'branch_name' => $request->branch_name,
                'action' => 'update',
                'details update' => $request->input(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('branch.index');
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Error updating branch: ' . $e->getMessage() . json_encode([
                'action' => 'update',
                'details update' => $request->all(),
                'error' => $e->getMessage(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->back();
        }
    }
    public function destroy(Request $request, $id)
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

        try {
            $branch = BranchModel::findOrFail($id);
            $branch->activeflag = 0;
            $branch->save();
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
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Error deleting branch: ' . $e->getMessage() . json_encode([
                'action' => 'delete',
                'details delete' => $request->all(),
                'error' => $e->getMessage(),
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }
}
