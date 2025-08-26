<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;

class CouponController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 14)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Coupon Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Coupon Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $coupons = DB::table('coupon_info')
            ->where('activeflag', 1)
            ->orderBy('coupon_id', 'asc')
            ->get();
        // dd($coupons);
        return view('pages.coupon.index', compact('coupons'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 42)) {
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
        $promo_code = DB::table('promotion_info')
            ->select('promo_code', 'promo_desc')
            ->where('activeflag', 1)
            ->orderBy('promo_code', 'asc')
            ->get();
        return view('pages.coupon.create', compact('promo_code'));
    }

    public function store(Request $request)
    {
        $form_data = $request->validate([
            'coupon_id' => 'required | unique:coupon_info,coupon_id',
            'coupon_promo_code' => 'nullable',
            'coupon_name' => 'required',
            'start_date' => 'required',
            'valid_date' => 'required',
            'coupon_countday' => 'required',
            'coupon_countall' => 'required',
            'coupon_limit' => 'required',
            'coupon_limitqty' => 'required',
            'coupon_limitall' => 'required',
            'coupon_limitallqty' => 'required',
            'print_tax' => 'required',
        ], [
            'coupon_id.required' => __('coupon.coupon_id_required'),
            'coupon_id.unique' => __('coupon.coupon_id_unique'),
            'coupon_name.required' => __('coupon.coupon_name_required'),
            'start_date.required' => __('coupon.coupon_start_date_required'),
            'valid_date.required' => __('coupon.coupon_valid_date_required'),
            'coupon_countday.required' => __('coupon.coupon_countday_required'),
            'coupon_countall.required' => __('coupon.coupon_countall_required'),
        ]);
        // dd($form_data);
        $start_date = Carbon::parse($form_data['start_date'])->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($form_data['valid_date'])->format('Y-m-d H:i:s');

        if ($form_data) {
            DB::table('coupon_info')
                ->insert([
                    'coupon_id' => $form_data['coupon_id'],
                    'coupon_name' => $form_data['coupon_name'],
                    'promo_code' => $form_data['coupon_promo_code'],
                    'start_date' => $start_date,
                    'valid_date' => $end_date,
                    'coupon_countday' => $form_data['coupon_countday'],
                    'coupon_countall' => $form_data['coupon_countall'],
                    'coupon_limit' => $form_data['coupon_limit'],
                    'coupon_limitqty' => $form_data['coupon_limitqty'],
                    'coupon_limitall' => $form_data['coupon_limitall'],
                    'coupon_limitallqty' => $form_data['coupon_limitallqty'],
                    'print_tax' => $form_data['print_tax'],
                    'activeflag' => 1,
                ]);

            Log::channel('activity')->notice(session('auth_user.user_id') . ' Coupon Created: ' . $form_data['coupon_name'], [
                'coupon_id' => $form_data['coupon_id'],
                'coupon_name' => $form_data['coupon_name'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->success(__('menu.save_is_success'));
            return redirect()->route('coupons.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Coupon Creation Failed: ' . $form_data['coupon_name'], [
                'coupon_id' => $form_data['coupon_id'],
                'coupon_name' => $form_data['coupon_name'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->error(__('menu.save_is_failed'));
            return redirect()->route('coupons.index');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 43)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Coupon Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Coupon Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $coupons = DB::table('coupon_info')
            ->where('activeflag', 1)
            ->where('coupon_id', $id)
            ->first();
        $promo_code = DB::table('promotion_info')
            ->select('promo_code', 'promo_desc')
            ->where('activeflag', 1)
            ->orderBy('promo_code', 'asc')
            ->get();
        $coupons_detail = DB::table('coupondetail_info')
            ->where('activeflag', 1)
            ->where('coupon_id', $id)
            ->orderBy('coupon_no', 'ASC')
            ->get();

        Log::channel('activity')->info(session('auth_user.user_id') . ' Accessed Coupon Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'access',
            'page' => 'Coupon Edit Page',
            'branch_data' => $coupons,
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.coupon.edit', compact('coupons', 'promo_code', 'coupons_detail'));
    }

    public function update(Request $request, $id)
    {
        $form_data = $request->validate([
            'coupon_promo_code' => 'nullable',
            'coupon_name' => 'required',
            'start_date' => 'required',
            'valid_date' => 'required',
            'coupon_countday' => 'required',
            'coupon_countall' => 'required',
            'coupon_limit' => 'required',
            'coupon_limitqty' => 'required',
            'coupon_limitall' => 'required',
            'coupon_limitallqty' => 'required',
            'print_tax' => 'required',
        ], [
            'coupon_name.required' => __('coupon.coupon_name_required'),
            'start_date.required' => __('coupon.coupon_start_date_required'),
            'valid_date.required' => __('coupon.coupon_valid_date_required'),
            'coupon_countday.required' => __('coupon.coupon_countday_required'),
            'coupon_countall.required' => __('coupon.coupon_countall_required'),
        ]);
        // dd($form_data);
        $start_date = Carbon::parse($form_data['start_date'])->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($form_data['valid_date'])->format('Y-m-d H:i:s');

        if ($form_data) {
            DB::table('coupon_info')
                ->where('coupon_id', $id)
                ->update([
                    'coupon_name' => $form_data['coupon_name'],
                    'promo_code' => $form_data['coupon_promo_code'],
                    'start_date' => $start_date,
                    'valid_date' => $end_date,
                    'coupon_countday' => $form_data['coupon_countday'],
                    'coupon_countall' => $form_data['coupon_countall'],
                    'coupon_limit' => $form_data['coupon_limit'],
                    'coupon_limitqty' => $form_data['coupon_limitqty'],
                    'coupon_limitall' => $form_data['coupon_limitall'],
                    'coupon_limitallqty' => $form_data['coupon_limitallqty'],
                    'print_tax' => $form_data['print_tax'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Coupon Updated: ' . $form_data['coupon_name'], [
                'coupon_id' => $id,
                'update detail' => array($form_data),
                'action' => 'update',
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->success(__('menu.edit_is_success'));
            return redirect()->route('coupons.index');
        } else {
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('coupons.index');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 44)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Coupon Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Coupon Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $coupons = DB::table('coupon_info')
            ->where('coupon_id', $id)
            ->update([
                'activeflag' => 0,
            ]);


        if ($coupons) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Coupon Deleted: ' . $id, [
                'coupon_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->success(__('menu.delete_is_success'));
            return redirect()->route('coupons.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Coupon Deletion Failed: ' . $id, [
                'coupon_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->option('position', 'bottom-right')
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('coupons.index');
        }
    }

    public function coupon_detail_insert(Request $request)
    {
        try {
            $check_c = $request->input('couponcheck');

            if ($check_c == 0) {
                $form_data = $request->validate(
                    [
                        'coupon_id' => 'required',
                        'coupon_no' => 'required',
                        'coupon_no_num1' => 'required',
                        'amount1' => 'required',
                    ],
                    [
                        'coupon_id.required' => __('coupon.coupon_id_required'),
                        'coupon_no.required' => __('coupon.coupon_no_required'),
                        'coupon_no_num1.required' => __('coupon.coupon_no_num'),
                        'amount1.required' => __('coupon.coupon_amout_required'),
                    ]
                );

                $start_date_input = $request->input('start_date');
                $valid_date_input = $request->input('valid_date');

                if (!$start_date_input || !$valid_date_input) {
                    throw new \Exception(__('menu.date_required'));
                }

                $start_date = Carbon::parse($start_date_input)->format('Y-m-d H:i:s');
                $end_date = Carbon::parse($valid_date_input)->format('Y-m-d H:i:s');

                $numrand = substr(str_shuffle('0123456789'), 0, 2);
                $coupon_no = $form_data['coupon_no'] . $form_data['coupon_no_num1'] . $numrand;

                $inserted = DB::table('coupondetail_info')
                    ->insert([
                        'coupon_id' => $form_data['coupon_id'],
                        'coupon_no' => $coupon_no,
                        'amount' => $form_data['amount1'],
                        'start_date' => $start_date,
                        'valid_date' => $end_date,
                        'coupon_lock' => 'N',
                        'activeflag' => 1,
                    ]);

                if (!$inserted) {
                    throw new \Exception(__('menu.save_is_failed'));
                }

                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            } else {
                $form_data = $request->validate(
                    [
                        'coupon_id' => 'required',
                        'coupon_no_start' => 'required|numeric',
                        'coupon_no_end' => 'required|numeric|gt:coupon_no_start',
                        'coupon_no_num2' => 'required',
                        'amount2' => 'required|numeric',
                    ],
                    [
                        'coupon_id.required' => __('coupon.coupon_id_required'),
                        'coupon_no_start.required' => __('coupon.coupon_start_required'),
                        'coupon_no_end.required' => __('coupon.coupon_end_required'),
                        'coupon_no_end.gt' => __('coupon.coupon_end_gt'),
                        'coupon_no_num2.required' => __('coupon.coupon_no_num'),
                        'amount2.required' => __('coupon.coupon_amout_required'),
                    ]
                );

                $start_date_input = $request->input('start_date');
                $valid_date_input = $request->input('valid_date');

                if (!$start_date_input || !$valid_date_input) {
                    throw new \Exception(__('menu.date_required'));
                }

                $start_date = Carbon::parse($start_date_input)->format('Y-m-d H:i:s');
                $end_date = Carbon::parse($valid_date_input)->format('Y-m-d H:i:s');



                $coupon_no_start = (int) $form_data['coupon_no_start'];
                $coupon_no_end = (int) $form_data['coupon_no_end'];
                $numDigits = strlen((string)$coupon_no_end);
                $data_coupon_no = [];
                for ($i = $coupon_no_start; $i <= $coupon_no_end; $i++) {
                    $coupon_no = $form_data['coupon_no_num2'] . str_pad($i, $numDigits, '0', STR_PAD_LEFT) . substr(str_shuffle('0123456789'), 0, 2);
                    // $coupon_no = $form_data['coupon_no_num2'] . str_pad($i, 4, '0', STR_PAD_LEFT);
                    $exists = DB::table('coupondetail_info')
                        ->where('coupon_no', $coupon_no)
                        ->exists();

                    if ($exists) {
                        return response()->json([
                            'status' => false,
                            'code' => 422,
                            'message' => __('coupon.coupon_no_t1') . $coupon_no . __('coupon.coupon_no_t2'),
                            'data' => null
                        ], 422);
                    }

                    $data_coupon_no[] = [
                        'coupon_id' => $form_data['coupon_id'],
                        'coupon_no' => $coupon_no,
                        'amount' => $form_data['amount2'],
                        'start_date' => $start_date,
                        'valid_date' => $end_date,
                        'coupon_lock' => 'N',
                        'activeflag' => 1,
                    ];
                }

                if (empty($data_coupon_no)) {
                    throw new \Exception(__('menu.save_is_failed'));
                }

                $inserted = DB::table('coupondetail_info')->insert($data_coupon_no);

                if (!$inserted) {
                    throw new \Exception(__('menu.save_is_failed'));
                }

                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function coupon_detail_destroy($coupon_id)
    {
        $coupons = DB::table('coupondetail_info')
            ->where('coupon_no', $coupon_id)
            ->update([
                'activeflag' => 0,
            ]);

        if ($coupons) {
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }
    public function coupon_detail_lock(Request $request, $coupon_no)
    {
        $coupon_lock = $request->input('coupon_lock');

        $coupons = DB::table('coupondetail_info')
            ->where('coupon_no', $coupon_no)
            ->update([
                'coupon_lock' => $coupon_lock,
            ]);
        if ($coupons) {
            sweetalert()
                ->success(__('coupon.coupon_lock_success'));
            return redirect()->back();
        } else {
            sweetalert()
                ->error(__('coupon.coupon_lock_failed'));
            return redirect()->back();
        }
    }

    public function coupon_lockall(Request $request, $coupon_id)
    {
        $coupon_lock = $request->input('coupon_lock');

        // dd($coupon_lock, $coupon_id);
        $coupons = DB::table('coupondetail_info')
            ->where('coupon_id', $coupon_id)
            ->update([
                'coupon_lock' => $coupon_lock,
            ]);
        if ($coupons) {
            if ($coupon_lock == 'Y') {
                sweetalert()
                    ->success(__('coupon.coupon_lockall_success'));
                return redirect()->back();
            } else {
                sweetalert()
                    ->success(__('coupon.coupon_unlockall_success'));
                return redirect()->back();
            }
        } else {
            if ($coupon_lock == 'Y') {
                sweetalert()
                    ->success(__('coupon.coupon_lockall_failed'));
                return redirect()->back();
            } else {
                sweetalert()
                    ->success(__('coupon.coupon_unlockall_failed'));
                return redirect()->back();
            }
        }
    }
}
