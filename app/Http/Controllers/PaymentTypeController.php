<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentTypeController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 16)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Type Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Type Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $paymentType = DB::table('paymenttype_info')
            ->select('payment_code', 'payment_desc')
            ->where('activeflag', '=', 1)
            ->orderBy('payment_code', 'asc')
            ->get();

        return view('pages.payment_type.index', compact('paymentType',));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 48)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Type Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Type Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $payment_g = DB::table('grouppaymenttype_info')
            ->select('payment_group', 'description')
            ->orderBy('payment_group', 'asc')
            ->where('activeflag', '=', 1)
            ->get();
        return view('pages.payment_type.create', compact('payment_g'));
    }

    public function store(Request $request)
    {
        $validateData =  $request->validate([
            'payment_code' => 'required|max:10|unique:paymenttype_info,payment_code',
            'payment_desc' => 'required',
            'payment_group' => 'required',
            'acc_sap' => 'nullable',
            'refund' => 'required',
            'payment_seq' => 'required',
            'interface_type' => 'required',
            'interface_port' => 'required',
            'interface_header' => 'nullable'
        ], [
            'payment_code.required' => __('payment_type.payment_code_valid'),
            'payment_code.max' => __('payment_type.payment_code_max'),
            'payment_code.unique' => __('payment_type.payment_code_unique'),
            'payment_desc.required' => __('payment_type.payment_group_valid'),
            'payment_group.required' => __('payment_type.payment_desc_valid'),
            'payment_seq.required' => __('payment_type.payment_seq_valid'),
            'interface_type.required' => __('payment_type.interface_type'),
            'interface_port.required' => __('payment_type.interface_port'),

        ]);
        // dd($validateData);

        $paymenttype_insert = DB::table('paymenttype_info')
            ->insert([
                'payment_code' => $validateData['payment_code'],
                'payment_desc' => $validateData['payment_desc'],
                'payment_group' => $validateData['payment_group'],
                'acc_sap' => $validateData['acc_sap'],
                'refund' => $validateData['refund'],
                'payment_seq' => $validateData['payment_seq'],
                'prefix_length' => 0,
                'subfix_length' => 0,
                'interface_type' => $validateData['interface_type'],
                'interface_port' => $validateData['interface_port'],
                'interface_header' => $validateData['interface_header'],
                'activeflag' => 1
            ]);
        if (isset($paymenttype_insert)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' created payment type: ' . $validateData['payment_code'], [
                'payment_code' => $validateData['payment_code'],
                'payment_desc' => $validateData['payment_desc'],
                'action' => 'create',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('payment_type.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create payment type: ' . $validateData['payment_code'], [
                'payment_code' => $validateData['payment_code'],
                'payment_desc' => $validateData['payment_desc'],
                'action' => 'create',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('payment_type.index');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 49)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Type Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Type Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $payment_type = DB::table('paymenttype_info')
            ->where('payment_code', '=', $id)
            ->first();
        $payment_g = DB::table('grouppaymenttype_info')
            ->select('payment_group', 'description')
            ->orderBy('payment_group', 'asc')
            ->where('activeflag', '=', 1)
            ->get();
        Log::channel('activity')->info('Payment Type Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'payment_type' => $payment_type,
            'page' => 'Payment Type Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.payment_type.edit', compact('payment_type', 'payment_g'));
    }

    public function update(Request $request, $id)
    {

        $validateData =  $request->validate([
            'payment_desc' => 'required',
            'payment_group' => 'required',
            'acc_sap' => 'nullable',
            'refund' => 'required',
            'payment_seq' => 'required',
            'interface_type' => 'required',
            'interface_port' => 'required',
            'interface_header' => 'nullable'
        ], [
            'payment_desc.required' => __('payment_type.payment_group_valid'),
            'payment_group.required' => __('payment_type.payment_desc_valid'),
            'payment_seq.required' => __('payment_type.payment_seq_valid'),
            'interface_type.required' => __('payment_type.interface_type'),
            'interface_port.required' => __('payment_type.interface_port'),

        ]);

        $paymenttype_update = DB::table('paymenttype_info')
            ->where('payment_code', '=', $id)
            ->update([
                'payment_desc' => $validateData['payment_desc'],
                'payment_group' => $validateData['payment_group'],
                'acc_sap' => $validateData['acc_sap'],
                'refund' => $validateData['refund'],
                'payment_seq' => $validateData['payment_seq'],
                'interface_type' => $validateData['interface_type'],
                'interface_port' => $validateData['interface_port'],
                'interface_header' => $validateData['interface_header'],
            ]);

        if (isset($paymenttype_update)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated payment type: ' . $id, [
                'payment_code' => $id,
                'payment_desc' => $validateData['payment_desc'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('payment_type.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update payment type: ' . $id, [
                'payment_code' => $id,
                'payment_desc' => $validateData['payment_desc'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('payment_type.index');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 50)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Type Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Type Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $paymenttype_delete = DB::table('paymenttype_info')
            ->where('payment_code', '=', $id)
            ->update(['activeflag' => 0]);

        if (isset($paymenttype_delete)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted payment type: ' . $id, [
                'payment_code' => $id,
                'action' => 'delete',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('payment_type.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete payment type: ' . $id, [
                'payment_code' => $id,
                'action' => 'delete',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('payment_type.index');
        }
    }
}
