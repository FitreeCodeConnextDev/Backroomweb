<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VendorPromoController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 3)) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') . 'Permission Denied: Access Vendor Promotion Page', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'Vendor Promotion',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $vendor_promo = DB::table('vendorpromotion_info')
            ->select('promo_code', 'promo_desc')
            ->where('activeflag', '=', '1')
            ->orderBy('promo_code', 'asc')
            ->get();
        return view('pages.vendor_promo.index', compact('vendor_promo'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 9)) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') . 'Permission Denied: Access Vendor Promotion Create Page', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'Vendor Promotion Create',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.vendor_promo.create');
    }
    public function store(Request $request)
    {
        $validate_data = $request->validate(
            [
                'promo_code' => 'required|max:10|unique:vendorpromotion_info,promo_code',
                'promo_desc' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'use_discount' => 'required',
                'discountrate' => 'required',
                'discountamt' => 'required',
                'use_point' => 'required',
                'use_min' => 'required',
                'add_point' => 'required',
            ],
            [
                'promo_code.required' => __('card_promo.promo_code_valid'),
                'promo_code.max' => __('card_promo.promo_code_max'),
                'promo_code.unique' => __('card_promo.promo_code_unique'),
                'promo_desc.required' => __('card_promo.promo_desc_valid'),
                'start_date.required' => __('card_promo.start_date_valid'),
                'end_date.required' => __('card_promo.end_date_valid'),
                'start_time.required' => __('card_promo.start_time_valid'),
                'end_time.required' => __('card_promo.end_time_valid'),
                'use_discount.required' => __('card_promo.discountrate_valid'),
                'discountrate.required' => __('card_promo.promo_code_unique'),
                'discountamt.required' => __('card_promo.discountamt_valid'),
                'use_point.required' => __('card_promo.use_point_valid'),
                'use_min.required' => __('card_promo.use_min_valid'),
                'add_point.required' => __('card_promo.add_point_valid'),

            ]
        );

        $start_date = Carbon::parse($validate_data['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($validate_data['end_date'])->format('Y-m-d');

        // Combine the date with the time and convert to datetime format (Y-m-d H:i:s)
        $start_datetime = Carbon::parse($start_date . ' ' . $validate_data['start_time'])->format('Y-m-d H:i:s');
        $end_datetime = Carbon::parse($end_date . ' ' . $validate_data['end_time'])->format('Y-m-d H:i:s');

        $user_session = session('auth_user');
        // dd($start_date, $end_date, $start_datetime, $end_datetime);ด
        $promotionvendor_insert = DB::table('vendorpromotion_info')->insert([
            'promo_code' => $validate_data['promo_code'],
            'promo_desc' => $validate_data['promo_desc'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $start_datetime,
            'end_time' => $end_datetime,
            'use_discount' => $validate_data['use_discount'],
            'discountrate' => $validate_data['discountrate'],
            'discountamt' => $validate_data['discountamt'],
            'use_point' => $validate_data['use_point'],
            'use_min' => $validate_data['use_min'],
            'add_point' => $validate_data['add_point'],
            'activeflag' => $user_session['activeflag'],
        ]);

        if (isset($promotionvendor_insert)) {
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('vendor-promotion.index');
        } else {
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('vendor-promotion.create');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 10)) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') . 'Permission Denied: Access Vendor Promotion Edit Page', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'Vendor Promotion Edit',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $vendor_promo = DB::table('vendorpromotion_info')->where('promo_code', '=', $id)->first();
        Log::channel('activity')->info('Vendor Promotion Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'vendor_promo' => $vendor_promo,
            'page' => 'Vendor Promotion Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.vendor_promo.edit', compact('vendor_promo'));
    }
    public function update($id, Request $request)
    {
        $validate_data = $request->validate([
            'promo_desc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'use_discount' => 'required',
            'discountrate' => 'required',
            'discountamt' => 'required',
            'use_point' => 'required',
            'use_min' => 'required',
            'add_point' => 'required',
        ], [
            'promo_desc.required' => __('card_promo.promo_desc_valid'),
            'start_date.required' => __('card_promo.start_date_valid'),
            'end_date.required' => __('card_promo.end_date_valid'),
            'start_time.required' => __('card_promo.start_time_valid'),
            'end_time.required' => __('card_promo.end_time_valid'),
            'use_discount.required' => __('card_promo.discountrate_valid'),
            'discountrate.required' => __('card_promo.promo_code_unique'),
            'discountamt.required' => __('card_promo.discountamt_valid'),
            'use_point.required' => __('card_promo.use_point_valid'),
            'use_min.required' => __('card_promo.use_min_valid'),
            'add_point.required' => __('card_promo.add_point_valid'),
        ]);

        $start_date = Carbon::parse($validate_data['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($validate_data['end_date'])->format('Y-m-d');

        // Combine the date with the time and convert to datetime format (Y-m-d H:i:s)
        $start_datetime = Carbon::parse($start_date . ' ' . $validate_data['start_time'])->format('Y-m-d H:i:s');
        $end_datetime = Carbon::parse($end_date . ' ' . $validate_data['end_time'])->format('Y-m-d H:i:s');

        // dd($start_date, $end_date, $start_datetime, $end_datetime);ด
        $promotionvendor_update = DB::table('vendorpromotion_info')->where('promo_code', $id)->update([
            'promo_code' => $validate_data['promo_code'],
            'promo_desc' => $validate_data['promo_desc'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $start_datetime,
            'end_time' => $end_datetime,
            'use_discount' => $validate_data['use_discount'],
            'discountrate' => $validate_data['discountrate'],
            'discountamt' => $validate_data['discountamt'],
            'use_point' => $validate_data['use_point'],
            'use_min' => $validate_data['use_min'],
            'add_point' => $validate_data['add_point'],
            'activeflag' => 1
        ]);

        if (isset($promotionvendor_update)) {
            Log::channel('activity')->info('Vendor Promotion Update Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'update',
                'vendor_promo' => $validate_data,
                'page' => 'Vendor Promotion Update Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('vendor-promotion.index');
        } else {
            Log::channel('activity')->error('Vendor Promotion Update Failed Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'update',
                'vendor_promo' => $validate_data,
                'page' => 'Vendor Promotion Update Failed Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 11)) {
            Log::channel('activity')
                ->error(session('auth_user.user_id') . 'Permission Denied: Access Vendor Promotion Delete Page', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'Vendor Promotion Delete',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $destroy =  DB::table('vendorpromotion_info')
            ->where('promo_code', $id)
            ->update([
                'activeflag' => 0,
            ]);
        if (isset($destroy)) {
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('vendor-promotion.index');
        } else {
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('vendor-promotion.index');
        }
    }
}
