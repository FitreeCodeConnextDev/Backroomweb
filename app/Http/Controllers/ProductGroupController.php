<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductGroupController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 2)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access to Product Group Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Group Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();

            // abort(401, 'You do not have access to this page.');
        }
        $groupproduct_info = DB::table('groupproduct_info')
            ->select('groupproduct_id', 'groupproduct_desc')
            ->where('activeflag', '=', '1')
            ->orderBy('groupproduct_id', 'asc')
            ->get();
        return view("pages.product_group.index", compact('groupproduct_info'));
    }
    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 6)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Create Product Group', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'create',
                'page' => 'Product Group Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view("pages.product_group.create");
    }
    public function store(Request $request)
    {
        $validate_groupproduct = $request->validate(
            [
                'groupproduct_id' => 'required|max:3|unique:groupproduct_info,groupproduct_id',
                'groupproduct_desc' => 'required',
                'discountrate' => 'required',
                'vatrate' => 'required',
                'use_point' => 'required',
                'add_point' => 'required',

            ],
            [
                'groupproduct_id.required' => __('product_group.groupproduct_id_valid'),
                'groupproduct_id.max' => __('product_group.groupproduct_id_max'),
                'groupproduct_id.unique' => __('product_group.groupproduct_id_unique'),
                'groupproduct_desc' => __('product_group.groupproduct_desc_valid'),
                'discountrate' => __('product_group.vatrate_valid'),
                'vatrate'  => __('product_group.discountrate_valid'),
                'use_point' => __('product_group.use_point_valid'),
                'add_point' => __('product_group.add_point_valid'),
            ]
        );

        $groupproduct_insert = DB::table('groupproduct_info')->insert([
            'groupproduct_id' => $validate_groupproduct['groupproduct_id'],
            'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
            'discountrate' => $validate_groupproduct['discountrate'],
            'vatrate' => $validate_groupproduct['vatrate'],
            'use_point' => $validate_groupproduct['use_point'],
            'add_point' => $validate_groupproduct['add_point'],
            'activeflag' => 1
        ]);
        if ($groupproduct_insert) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Created new product group: ' . $validate_groupproduct['groupproduct_id'], [
                'groupproduct_id' => $validate_groupproduct['groupproduct_id'],
                'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
                'action' => 'create',
                'Created at' => Carbon::now()->toDateTimeString(),
                'Created by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('products-groups.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create product group: ' . $validate_groupproduct['groupproduct_id'], [
                'groupproduct_id' => $validate_groupproduct['groupproduct_id'],
                'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
                'action' => 'create',
                'Created at' => Carbon::now()->toDateTimeString(),
                'Created by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('products-groups.create');
        }
    }
    public function edit($groupproduct_id)
    {
        if (!PermissionHelper::checkUserPermission('function', 7)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Edit Product Group', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'edit',
                'page' => 'Product Group Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $groupproduct_info = DB::table('groupproduct_info')
            ->where('groupproduct_id', $groupproduct_id)
            ->first();
        Log::channel('activity')->info('Product Group Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'product_group' => $groupproduct_info,
            'page' => 'Product Group Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view("pages.product_group.edit", compact('groupproduct_info'));
    }

    public function update(Request $request, $groupproduct_id)
    {
        $validate_groupproduct = $request->validate(
            [
                'groupproduct_desc' => 'required',
                'discountrate' => 'required',
                'vatrate' => 'required',
                'use_point' => 'required',
                'add_point' => 'required',

            ],
            [
                'groupproduct_desc' => __('product_group.groupproduct_desc_valid'),
                'discountrate' => __('product_group.vatrate_valid'),
                'vatrate'  => __('product_group.discountrate_valid'),
                'use_point' => __('product_group.use_point_valid'),
                'add_point' => __('product_group.add_point_valid'),
            ]
        );

        $update_groupproduct = DB::table('groupproduct_info')->where('groupproduct_id', '=', $groupproduct_id)->update([
            'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
            'discountrate' => $validate_groupproduct['discountrate'],
            'vatrate' => $validate_groupproduct['vatrate'],
            'use_point' => $validate_groupproduct['use_point'],
            'add_point' => $validate_groupproduct['add_point'],
        ]);
        if ($update_groupproduct) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Updated product group: ' . $groupproduct_id, [
                'groupproduct_id' => $groupproduct_id,
                'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
                'action' => 'update',
                'update detail' => $validate_groupproduct,
                'Updated at' => Carbon::now()->toDateTimeString(),
                'Updated by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('products-groups.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to update product group: ' . $groupproduct_id, [
                'groupproduct_id' => $groupproduct_id,
                'groupproduct_desc' => $validate_groupproduct['groupproduct_desc'],
                'action' => 'update',
                'update detail' => $validate_groupproduct,
                'Updated at' => Carbon::now()->toDateTimeString(),
                'Updated by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->back();
        }
    }
    public function destroy($groupproduct_id)
    {
        if (!PermissionHelper::checkUserPermission('function', 8)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Delete Product Group', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'delete',
                'page' => 'Product Group Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        // Attempt to delete the unit with the given unit_id
        $deleted = DB::table('groupproduct_info')
            ->where('groupproduct_id', $groupproduct_id)
            ->update([
                'activeflag' => 0, // Set the active flag to 0 to mark the unit as inactive
            ]);

        // Check if the deletion was successful
        if ($deleted) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Deleted product group: ' . $groupproduct_id, [
                'groupproduct_id' => $groupproduct_id,
                'action' => 'delete',
                'Deleted at' => Carbon::now()->toDateTimeString(),
                'Deleted by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('products-groups.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to delete product group: ' . $groupproduct_id, [
                'groupproduct_id' => $groupproduct_id,
                'action' => 'delete',
                'Deleted at' => Carbon::now()->toDateTimeString(),
                'Deleted by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('products-groups.index');
        }
    }
}
