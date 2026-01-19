<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentGroupController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 15)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Group Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Group Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $payment_groups = DB::table('grouppaymenttype_info')
            ->where('activeflag', 1)
            ->orderBy('payment_group', 'asc')
            ->get();

        return view('pages.payment_group.index', compact('payment_groups'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 45)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Group Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Group Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.payment_group.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'payment_group' => 'required|max:2|unique:grouppaymenttype_info,payment_group',
                'description' => 'required',
                'show_tender' => 'required',
            ],
            [
                'payment_group.required' => __('payment_group.payment_group_valid'),
                'payment_group.max' => __('payment_group.payment_group_required_max'),
                'payment_group.unique' => __('payment_group.payment_group_unique'),
                'description.required' => __('payment_group.description_valid'),
                'show_tender.required' => __('payment_group.show_tender_valid'),
            ]
        );

        // dd($validateData);

        if (isset($validateData)) {
            DB::table('grouppaymenttype_info')->insert([
                'payment_group' => $validateData['payment_group'],
                'description' => $validateData['description'],
                'show_tender' => $validateData['show_tender'],
                'activeflag' => 1
            ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' created payment group: ' . $validateData['payment_group'], [
                'payment_group' => $validateData['payment_group'],
                'description' => $validateData['description'],
                'show_tender' => $validateData['show_tender'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('payment-group.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create payment group: ' . $validateData['payment_group'], [
                'payment_group' => $validateData['payment_group'],
                'description' => $validateData['description'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('payment-group.index');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 46)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Group Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Group Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $payment_group = DB::table('grouppaymenttype_info')->where('payment_group', $id)->first();
        Log::channel('activity')->info('Payment Group Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'payment_group' => $payment_group,
            'page' => 'Payment Group Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.payment_group.edit', compact('payment_group'));
    }
    public function update(Request $request, $id)
    {
        $validateData = $request->validate(
            [
                'description' => 'required',
                'show_tender' => 'required',
            ],
            [
                'description.required' => __('payment_group.description_valid'),
                'show_tender.required' => __('payment_group.show_tender_valid'),
            ]
        );

        if (isset($validateData)) {
            DB::table('grouppaymenttype_info')->where('payment_group', $id)
                ->update([
                    'description' => $validateData['description'],
                    'show_tender' => $validateData['show_tender'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated payment group: ' . $id, [
                'payment_group' => $id,
                'description' => $validateData['description'],
                'show_tender' => $validateData['show_tender'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('payment-group.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update payment group: ' . $id, [
                'payment_group' => $id,
                'description' => $validateData['description'],
                'show_tender' => $validateData['show_tender'],
                'action' => 'update',
                'update detail' => $validateData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('payment-group.index');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 47)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Payment Group Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Payment Group Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }


        if (isset($id)) {
            DB::table('grouppaymenttype_info')->where('payment_group', $id)
                ->update([
                    'activeflag' => 0
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted payment group: ' . $id, [
                'payment_group' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('payment-group.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete payment group: ' . $id, [
                'payment_group' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('payment-group.index');
        }
    }
}
