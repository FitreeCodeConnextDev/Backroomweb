<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductSapController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 13)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product SAP Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product SAP Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $catproduct_info = DB::table('catproductgroup_info')
            ->select('catproduct_group', 'description')
            ->orderBy('catproduct_group', 'asc')
            ->get();
        return view("pages.product_sap.index", compact('catproduct_info'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 39)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product SAP Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product SAP Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view("pages.product_sap.create");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'catproduct_group' => 'required|max:10|unique:catproductgroup_info,catproduct_group',
                'description' => 'required',
                'ar_sap' => 'nullable',
                'ar_description' => 'nullable',
            ],
            [
                'catproduct_group.required' => __('product_sap.catproduct_group_valid'),
                'catproduct_group.max' => __('product_sap.catproduct_group_max'),
                'catproduct_group.unique' => __('product_sap.catproduct_group_unique'),
                'description.required' => __('product_sap.description_valid'),
            ]
        );

        $sap_insert = DB::table('catproductgroup_info')->insert([
            'catproduct_group' => $validatedData['catproduct_group'],
            'description' => $validatedData['description'],
            'ar_sap' => $validatedData['ar_sap'],
            'ar_description' => $validatedData['ar_description'],
        ]);

        if (isset($sap_insert)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Created new product sap: ' . $validatedData['catproduct_group'], [
                'catproduct_group' => $validatedData['catproduct_group'],
                'description' => $validatedData['description'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('product-sap.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create product sap: ' . $validatedData['catproduct_group'], [
                'catproduct_group' => $validatedData['catproduct_group'],
                'description' => $validatedData['description'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('product-sap.index');
        }
    }

    public function edit($catproduct_group)
    {
        if (!PermissionHelper::checkUserPermission('function', 40)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product SAP Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product SAP Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $catproduct_info = DB::table('catproductgroup_info')->where('catproduct_group', $catproduct_group)->first();
        Log::channel('activity')->info('Product SAP Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'product_sap' => $catproduct_info,
            'page' => 'Product SAP Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view("pages.product_sap.edit", compact('catproduct_info'));
    }

    public function update(Request $request, $catproduct_group)
    {
        $validatedData = $request->validate(
            [
                'description' => 'required',
                'ar_sap' => 'nullable',
                'ar_description' => 'nullable',
            ],
            [
                'description.required' => __('product_sap.description_valid'),
            ]
        );

        $sap_update = DB::table('catproductgroup_info')->where('catproduct_group', $catproduct_group)
            ->update([
                'description' => $validatedData['description'],
                'ar_sap' => $validatedData['ar_sap'],
                'ar_description' => $validatedData['ar_description'],
            ]);

        if (isset($sap_update)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Updated product sap: ' . $catproduct_group, [
                'catproduct_group' => $catproduct_group,
                'description' => $validatedData['description'],
                'action' => 'update',
                'update detail' => $validatedData,
                'Updated At' => Carbon::now()->toDateTimeString(),
                'Updated By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('product-sap.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to update product sap: ' . $catproduct_group, [
                'catproduct_group' => $catproduct_group,
                'description' => $validatedData['description'],
                'action' => 'update',
                'update detail' => $validatedData,
                'Updated At' => Carbon::now()->toDateTimeString(),
                'Updated By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('product-sap.index');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 41)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product SAP Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product SAP Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $sap_delete = DB::table('catproductgroup_info')->where('catproduct_group', $id)->delete();

        if (isset($sap_delete)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Deleted product sap: ' . $id, [
                'catproduct_group' => $id,
                'action' => 'delete',
                'Deleted At' => Carbon::now()->toDateTimeString(),
                'Deleted By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('product-sap.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to delete product sap: ' . $id, [
                'catproduct_group' => $id,
                'action' => 'delete',
                'Deleted At' => Carbon::now()->toDateTimeString(),
                'Deleted By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('product-sap.index');
        }
    }
}
