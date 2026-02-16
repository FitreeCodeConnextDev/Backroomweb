<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function index()
    {

        try {
            if (!PermissionHelper::checkUserPermission('back', null, 5)) {
                Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access User Page ', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'User Page',
                    'timestamp' => Carbon::now()->toDateTimeString(),

                ]);
                sweetalert()
                    ->error(__('menu.is_permission_denied'));
                return redirect()->back();
            }
            $session_branch_id = session('auth_user.branch_id');
            if ($session_branch_id == 000000) {
                $user_data = DB::table('user_info')
                    ->select('user_id', 'user_name', 'branch_id')
                    ->where('activeflag', 1)
                    ->orderBy('user_id', 'DESC')
                    ->get();
                return view('pages.users.index', compact('user_data'));
            } else {
                $user_data = DB::table('user_info')
                    ->select('user_id', 'user_name')
                    ->where('branch_id', $session_branch_id)
                    ->where('activeflag', 1)
                    ->orderBy('user_id', 'DESC')
                    ->get();
                return view('pages.users.index', compact('user_data'));
            }
        } catch (\Exception $e) {
            Log::error(__('menu.is_catch') . ' ' . $e->getMessage());
            return response()->view('errors.503', ['message' => __('menu.is_catch'),]);
        }
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 15)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access User Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'User Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $form =  $request->validate(
            [
                'user_id' => 'required|max:6|unique:user_info,user_id',
                'user_name' => 'required',
                'user_pass' => 'required',
                'branch_id' => 'required',
                'city_license' => 'nullable',
                'card_no' => 'nullable',
                'needresetpass' => 'required',
                'resetpass_day' => 'required',
            ],
            [
                'user_id.required' => __('users.user_id_required'),
                'user_id.max' => __('users.user_id_max'),
                'user_id.unique' => __('users.user_id_unique'),
                'user_name.required' => __('users.user_name_required'),
                'user_pass.required' => __('users.user_pass_required'),
                'branch_id.required' => __('users.branch_id_required'),
            ]
        );

        $form_front = [
            'front_1' => $request->input('front_1'),
            'front_2' => $request->input('front_2'),
            'front_3' => $request->input('front_3'),
            'front_4' => $request->input('front_4'),
            'front_5' => $request->input('front_5'),
            'front_6' => $request->input('front_6'),
            'front_7' => $request->input('front_7'),
            'front_8' => $request->input('front_8'),
            'front_9' => $request->input('front_9'),
            'front_10' => $request->input('front_10'),
        ];

        $form_back = [
            // Vendor Permissions
            'back_1' => $request->input('back_1') ?? 0, // 0
            // Member Permissions
            'back_2' => $request->input('back_2') ?? 0, // 1
            // ProductGroup Permissions
            'back_3' => $request->input('back_3') ?? 0, // 2
            // Vendor Promotions Permissions
            'back_4' => $request->input('back_4') ?? 0, // 3
            // Card Promotions Permissions
            'back_5' => $request->input('back_5') ?? 0, // 4
            // User Permissions
            'back_6' => $request->input('back_6') ?? 0, // 5
            // Branch Permissions
            'back_7' => $request->input('back_7') ?? 0, // 6
            // Card Permissions
            'back_8' => $request->input('back_8') ?? 0, // 7
            // CardType Permissions
            'back_9' => $request->input('back_9') ?? 0, // 8
            // Product Permissions
            'back_10' => $request->input('back_10') ?? 0, // 9
            // Reward Permissions
            'back_11' => $request->input('back_11') ?? 0, // 10
            // Staff Permissions
            'back_12' => $request->input('back_12') ?? 0, // 11
            // ProductUnit Permissions
            'back_13' => $request->input('back_13') ?? 0, // 12
            // ProductGroup SAP Permissions
            'back_14' => $request->input('back_14') ?? 0, // 13
            // Coupon Permissions
            'back_15' => $request->input('back_15') ?? 0, // 14
            // PaymentGroup Permissions
            'back_16' => $request->input('back_16') ?? 0, // 15
            // PaymentType Permissions
            'back_17' => $request->input('back_17') ?? 0, // 16

            'back_18' => $request->input('back_18') ?? 0, // 17
            'back_19' => $request->input('back_19') ?? 0, // 18
            'back_20' => $request->input('back_20') ?? 0, // 19
            // Report Permissions
            'back_21' => $request->input('back_21') ?? 0, // 20
            'back_22' => $request->input('back_22') ?? 0, // 21
            'back_23' => $request->input('back_23') ?? 0, // 22
            'back_24' => $request->input('back_24') ?? 0, // 23
            'back_25' => $request->input('back_25') ?? 0, // 24
            'back_26' => $request->input('back_26') ?? 0, // 25
            'back_27' => $request->input('back_27') ?? 0, // 26
            'back_28' => $request->input('back_28') ?? 0, // 27
            'back_29' => $request->input('back_29') ?? 0, // 28
            'back_30' => $request->input('back_30') ?? 0, // 29
            'back_31' => $request->input('back_31') ?? 0, // 30
            'back_32' => $request->input('back_32') ?? 0, // 31
            'back_33' => $request->input('back_33') ?? 0, // 32
            'back_34' => $request->input('back_34') ?? 0, // 33
            'back_35' => $request->input('back_35') ?? 0, // 34
            'back_36' => $request->input('back_36') ?? 0, // 35
            'back_37' => $request->input('back_37') ?? 0, // 36
            'back_38' => $request->input('back_38') ?? 0, // 37
            'back_39' => $request->input('back_39') ?? 0, // 38
            'back_40' => $request->input('back_40') ?? 0, // 39
            'back_41' => $request->input('back_41') ?? 0, // 40
            'back_42' => $request->input('back_42') ?? 0, // 41
            'back_43' => $request->input('back_43') ?? 0, // 42
            'back_44' => $request->input('back_44') ?? 0, // 43
            'back_45' => $request->input('back_45') ?? 0, // 44
            'back_46' => $request->input('back_46') ?? 0, // 45
            'back_47' => $request->input('back_47') ?? 0, // 46
            'back_48' => $request->input('back_48') ?? 0, // 47
            'back_49' => $request->input('back_49') ?? 0, // 48
            'back_50' => $request->input('back_50') ?? 0, // 49
            'back_51' => $request->input('back_51') ?? 0, // 50
            'back_52' => $request->input('back_52') ?? 0, // 51

        ];
        $form_vendor = [
            'vendor_1' => $request->input('vendor_1'),
            'vendor_2' => $request->input('vendor_2'),
        ];
        $form_permiss = [
            'permiss_1_1' => $request->input('permiss_1_1') ?? 0, // 0
            'permiss_1_2' => $request->input('permiss_1_2') ?? 0, // 1
            'permiss_1_3' => $request->input('permiss_1_3') ?? 0, // 2
            'permiss_2_1' => $request->input('permiss_2_1') ?? 0, // 3
            'permiss_2_2' => $request->input('permiss_2_2') ?? 0, // 4
            'permiss_2_3' => $request->input('permiss_2_3') ?? 0, // 5
            'permiss_3_1' => $request->input('permiss_3_1') ?? 0, // 6
            'permiss_3_2' => $request->input('permiss_3_2') ?? 0, // 7
            'permiss_3_3' => $request->input('permiss_3_3') ?? 0, // 8
            'permiss_4_1' => $request->input('permiss_4_1') ?? 0, // 9
            'permiss_4_2' => $request->input('permiss_4_2') ?? 0, // 10
            'permiss_4_3' => $request->input('permiss_4_3') ?? 0, // 11
            'permiss_5_1' => $request->input('permiss_5_1') ?? 0, // 12
            'permiss_5_2' => $request->input('permiss_5_2') ?? 0, // 13
            'permiss_5_3' => $request->input('permiss_5_3') ?? 0, // 14
            'permiss_6_1' => $request->input('permiss_6_1') ?? 0, // 15
            'permiss_6_2' => $request->input('permiss_6_2') ?? 0, // 16
            'permiss_6_3' => $request->input('permiss_6_3') ?? 0, // 17
            'permiss_7_1' => $request->input('permiss_7_1') ?? 0, // 18
            'permiss_7_2' => $request->input('permiss_7_2') ?? 0, // 19
            'permiss_7_3' => $request->input('permiss_7_3') ?? 0, // 20
            'permiss_8_1' => $request->input('permiss_8_1') ?? 0, // 21
            'permiss_8_2' => $request->input('permiss_8_2') ?? 0, // 22
            'permiss_8_3' => $request->input('permiss_8_3') ?? 0, // 23
            'permiss_9_1' => $request->input('permiss_9_1') ?? 0, // 24
            'permiss_9_2' => $request->input('permiss_9_2') ?? 0, // 25
            'permiss_9_3' => $request->input('permiss_9_3') ?? 0, // 26
            'permiss_10_1' => $request->input('permiss_10_1') ?? 0, // 27
            'permiss_10_2' => $request->input('permiss_10_2') ?? 0, // 28
            'permiss_10_3' => $request->input('permiss_10_3') ?? 0, // 29
            'permiss_11_1' => $request->input('permiss_11_1') ?? 0, // 30
            'permiss_11_2' => $request->input('permiss_11_2') ?? 0, // 31
            'permiss_11_3' => $request->input('permiss_11_3') ?? 0, // 32
            'permiss_12_1' => $request->input('permiss_12_1') ?? 0, // 33
            'permiss_12_2' => $request->input('permiss_12_2') ?? 0, // 34 
            'permiss_12_3' => $request->input('permiss_12_3') ?? 0, // 35
            'permiss_13_1' => $request->input('permiss_13_1') ?? 0, // 36
            'permiss_13_2' => $request->input('permiss_13_2') ?? 0, // 37
            'permiss_13_3' => $request->input('permiss_13_3') ?? 0, // 38
            'permiss_14_1' => $request->input('permiss_14_1') ?? 0, // 39
            'permiss_14_2' => $request->input('permiss_14_2') ?? 0, // 40
            'permiss_14_3' => $request->input('permiss_14_3') ?? 0, // 41
            'permiss_15_1' => $request->input('permiss_15_1') ?? 0, // 42
            'permiss_15_2' => $request->input('permiss_15_2') ?? 0, // 43
            'permiss_15_3' => $request->input('permiss_15_3') ?? 0, // 44
            'permiss_16_1' => $request->input('permiss_16_1') ?? 0, // 45
            'permiss_16_2' => $request->input('permiss_16_2') ?? 0, // 46
            'permiss_16_3' => $request->input('permiss_16_3') ?? 0, // 47
            'permiss_17_1' => $request->input('permiss_17_1') ?? 0, // 48
            'permiss_17_2' => $request->input('permiss_17_2') ?? 0, // 49
            'permiss_17_3' => $request->input('permiss_17_3') ?? 0, // 50
            'permiss_18_1' => $request->input('permiss_18_1') ?? 0, // 51
            'permiss_18_2' => $request->input('permiss_18_2') ?? 0, // 52
            'permiss_18_3' => $request->input('permiss_18_3') ?? 0, // 53
            'permiss_19_1' => $request->input('permiss_19_1') ?? 0, // 54
            'permiss_19_2' => $request->input('permiss_19_2') ?? 0, // 55
            'permiss_19_3' => $request->input('permiss_19_3') ?? 0, // 56
            'permiss_20_1' => $request->input('permiss_20_1') ?? 0, // 57
            'permiss_20_2' => $request->input('permiss_20_2') ?? 0, // 58
            'permiss_20_3' => $request->input('permiss_20_3') ?? 0, // 59
            'permiss_21_1' => $request->input('permiss_21_1') ?? 0, // 60
            'permiss_21_2' => $request->input('permiss_21_2') ?? 0, // 61
            'permiss_21_3' => $request->input('permiss_21_3') ?? 0, // 62
            'permiss_22_1' => $request->input('permiss_22_1') ?? 0, // 63
            'permiss_22_2' => $request->input('permiss_22_2') ?? 0, // 64

        ];
        // dd($form, $form_front, $form_back, $form_vendor, $form_permiss);
        $front_merge = implode($form_front);
        $back_merge = implode($form_back);
        $vendor_merge = implode($form_vendor);
        $permiss_merge = implode($form_permiss);
        // dd($front_merge, $back_merge, $vendor_merge, $permiss_merge);
        if ($form && $form_front && $form_back && $form_vendor && $form_permiss) {
            $insert_user = DB::table('user_info')->insert([
                'user_id' => $form['user_id'],
                'user_name' => $form['user_name'],
                'user_pass' => $form['user_pass'],
                'branch_id' => $form['branch_id'],
                'city_license' => $form['city_license'],
                'card_no' => $form['card_no'],
                'needresetpass' => $form['needresetpass'],
                'resetpass_day' => $form['resetpass_day'],
                'front_permiss' => $front_merge,
                'back_permiss' => $back_merge,
                'term_permiss' => $vendor_merge,
                'function_permiss' => $permiss_merge,
                'activeflag' => 1,
                'user_lock' => 0,

            ]);
            if ($insert_user) {
                Log::channel('activity')->notice(session('auth_user.user_id') . 'Created a new user: ' . $form['user_id'], [
                    'user_id' => $form['user_id'],
                    'user_name' => $form['user_name'],
                    'branch_id' => $form['branch_id'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.delete_is_success'));
                return redirect()->route('users.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create a new user: ' . $form['user_id'], [
                    'user_id' => $form['user_id'],
                    'user_name' => $form['user_name'],
                    'branch_id' => $form['branch_id'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.save_is_failed'));
                return redirect()->route('users.create');
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create a new user due to validation errors: ' . $form['user_id'], [
                'user_id' => $form['user_id'],
                'user_name' => $form['user_name'],
                'branch_id' => $form['branch_id'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.is_failed'));
            return redirect()->route('users.create');
        }
    }

    public function edit($id)
    {
        try {
            if (!PermissionHelper::checkUserPermission('function', 16)) {
                Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access User Edit Page ', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'access',
                    'page' => 'User Edit Page',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
                sweetalert()
                    ->error(__('menu.is_permission_denied'));
                return redirect()->back();
            }
            $user_data = DB::table('user_info')
                ->where('user_id', $id)
                ->where('activeflag', 1)
                ->first();
            $front_permiss = $user_data->front_permiss;
            $back_permiss = $user_data->back_permiss;
            $term_permiss = $user_data->term_permiss;
            $function_permiss = $user_data->function_permiss;
            $front_permiss_edit = str_split($front_permiss);
            $back_permiss_edit = str_split($back_permiss);
            $term_permiss_edit = str_split($term_permiss);
            $function_permiss_edit = str_split($function_permiss);
            // dd( $front_permiss_edit, $back_permiss_edit, $term_permiss_edit, $function_permiss_edit);
            Log::channel('activity')->info('User Edit Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'edit',
                'user_data' => $user_data,
                'page' => 'User Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            return view('pages.users.edit', compact('user_data', 'front_permiss_edit', 'back_permiss_edit', 'term_permiss_edit', 'function_permiss_edit'));
        } catch (\Exception $e) {
            Log::error(__('menu.is_catch') . ' ' . $e->getMessage());
            return response()->view('errors.503', ['message' => __('menu.is_catch'),]);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->input());
        $form =  $request->validate(
            [
                'user_name' => 'required',
                'user_pass' => 'required',
                'branch_id' => 'required',
                'city_license' => 'nullable',
                'card_no' => 'nullable',
                'needresetpass' => 'required',
                'resetpass_day' => 'required',
            ],
            [
                'user_id.max' => __('users.user_id_max'),
                'user_id.unique' => __('users.user_id_unique'),
                'user_name.required' => __('users.user_name_required'),
                'user_pass.required' => __('users.user_pass_required'),
                'branch_id.required' => __('users.branch_id_required'),
            ]
        );

        $form_front = [
            'front_1' => $request->input('front_1'),
            'front_2' => $request->input('front_2'),
            'front_3' => $request->input('front_3'),
            'front_4' => $request->input('front_4'),
            'front_5' => $request->input('front_5'),
            'front_6' => $request->input('front_6'),
            'front_7' => $request->input('front_7'),
            'front_8' => $request->input('front_8'),
            'front_9' => $request->input('front_9'),
            'front_10' => $request->input('front_10'),
        ];
        $form_back = [
            // Vendor Permissions
            'back_1' => $request->input('back_1') ?? 0, // 0
            // Member Permissions
            'back_2' => $request->input('back_2') ?? 0, // 1
            // ProductGroup Permissions
            'back_3' => $request->input('back_3') ?? 0, // 2
            // Vendor Promotions Permissions
            'back_4' => $request->input('back_4') ?? 0, // 3
            // Card Promotions Permissions
            'back_5' => $request->input('back_5') ?? 0, // 4
            // User Permissions
            'back_6' => $request->input('back_6') ?? 0, // 5
            // Branch Permissions
            'back_7' => $request->input('back_7') ?? 0, // 6
            // Card Permissions
            'back_8' => $request->input('back_8') ?? 0, // 7
            // CardType Permissions
            'back_9' => $request->input('back_9') ?? 0, // 8
            // Product Permissions
            'back_10' => $request->input('back_10') ?? 0, // 9
            // Reward Permissions
            'back_11' => $request->input('back_11') ?? 0, // 10
            // Staff Permissions
            'back_12' => $request->input('back_12') ?? 0, // 11
            // ProductUnit Permissions
            'back_13' => $request->input('back_13') ?? 0, // 12
            // ProductGroup SAP Permissions
            'back_14' => $request->input('back_14') ?? 0, // 13
            // Coupon Permissions
            'back_15' => $request->input('back_15') ?? 0, // 14
            // PaymentGroup Permissions
            'back_16' => $request->input('back_16') ?? 0, // 15
            // PaymentType Permissions
            'back_17' => $request->input('back_17') ?? 0, // 16

            'back_18' => $request->input('back_18') ?? 0, // 17
            'back_19' => $request->input('back_19') ?? 0, // 18
            'back_20' => $request->input('back_20') ?? 0, // 19
            // Report Permissions
            'back_21' => $request->input('back_21') ?? 0, // 20
            'back_22' => $request->input('back_22') ?? 0, // 21
            'back_23' => $request->input('back_23') ?? 0, // 22
            'back_24' => $request->input('back_24') ?? 0, // 23
            'back_25' => $request->input('back_25') ?? 0, // 24
            'back_26' => $request->input('back_26') ?? 0, // 25
            'back_27' => $request->input('back_27') ?? 0, // 26
            'back_28' => $request->input('back_28') ?? 0, // 27
            'back_29' => $request->input('back_29') ?? 0, // 28
            'back_30' => $request->input('back_30') ?? 0, // 29
            'back_31' => $request->input('back_31') ?? 0, // 30
            'back_32' => $request->input('back_32') ?? 0, // 31
            'back_33' => $request->input('back_33') ?? 0, // 32
            'back_34' => $request->input('back_34') ?? 0, // 33
            'back_35' => $request->input('back_35') ?? 0, // 34
            'back_36' => $request->input('back_36') ?? 0, // 35
            'back_37' => $request->input('back_37') ?? 0, // 36
            'back_38' => $request->input('back_38') ?? 0, // 37
            'back_39' => $request->input('back_39') ?? 0, // 38
            'back_40' => $request->input('back_40') ?? 0, // 39
            'back_41' => $request->input('back_41') ?? 0, // 40
            'back_42' => $request->input('back_42') ?? 0, // 41
            'back_43' => $request->input('back_43') ?? 0, // 42
            'back_44' => $request->input('back_44') ?? 0, // 43
            'back_45' => $request->input('back_45') ?? 0, // 44
            'back_46' => $request->input('back_46') ?? 0, // 45
            'back_47' => $request->input('back_47') ?? 0, // 46
            'back_48' => $request->input('back_48') ?? 0, // 47
            'back_49' => $request->input('back_49') ?? 0, // 48
            'back_50' => $request->input('back_50') ?? 0, // 49
            'back_51' => $request->input('back_51') ?? 0, // 50
            'back_52' => $request->input('back_52') ?? 0, // 51

        ];
        $form_vendor = [
            'vendor_1' => $request->input('vendor_1'),
            'vendor_2' => $request->input('vendor_2'),
        ];
        $form_permiss = [
            // Verdor Permissions
            'permiss_1_1' => $request->input('permiss_1_1') ?? 0, // 0
            'permiss_1_2' => $request->input('permiss_1_2') ?? 0, // 1
            'permiss_1_3' => $request->input('permiss_1_3') ?? 0, // 2
            // Member Permissions
            'permiss_2_1' => $request->input('permiss_2_1') ?? 0, // 3
            'permiss_2_2' => $request->input('permiss_2_2') ?? 0, // 4
            'permiss_2_3' => $request->input('permiss_2_3') ?? 0, // 5
            // ProductGroup Permissions
            'permiss_3_1' => $request->input('permiss_3_1') ?? 0, // 6
            'permiss_3_2' => $request->input('permiss_3_2') ?? 0, // 7
            'permiss_3_3' => $request->input('permiss_3_3') ?? 0, // 8
            // Vendor Promotions Permissions
            'permiss_4_1' => $request->input('permiss_4_1') ?? 0, // 9
            'permiss_4_2' => $request->input('permiss_4_2') ?? 0, // 10
            'permiss_4_3' => $request->input('permiss_4_3') ?? 0, // 11
            // Card Promotions Permissions
            'permiss_5_1' => $request->input('permiss_5_1') ?? 0, // 12
            'permiss_5_2' => $request->input('permiss_5_2') ?? 0, // 13
            'permiss_5_3' => $request->input('permiss_5_3') ?? 0, // 14
            // User Permissions
            'permiss_6_1' => $request->input('permiss_6_1') ?? 0, // 15
            'permiss_6_2' => $request->input('permiss_6_2') ?? 0, // 16
            'permiss_6_3' => $request->input('permiss_6_3') ?? 0, // 17
            // Branch Permissions
            'permiss_7_1' => $request->input('permiss_7_1') ?? 0, // 18
            'permiss_7_2' => $request->input('permiss_7_2') ?? 0, // 19
            'permiss_7_3' => $request->input('permiss_7_3') ?? 0, // 20
            // Card Permissions
            'permiss_8_1' => $request->input('permiss_8_1') ?? 0, // 21
            'permiss_8_2' => $request->input('permiss_8_2') ?? 0, // 22
            'permiss_8_3' => $request->input('permiss_8_3') ?? 0, // 23
            // CardType Permissions
            'permiss_9_1' => $request->input('permiss_9_1') ?? 0, // 24
            'permiss_9_2' => $request->input('permiss_9_2') ?? 0, // 25
            'permiss_9_3' => $request->input('permiss_9_3') ?? 0, // 26
            // Product Permissions
            'permiss_10_1' => $request->input('permiss_10_1') ?? 0, // 27
            'permiss_10_2' => $request->input('permiss_10_2') ?? 0, // 28
            'permiss_10_3' => $request->input('permiss_10_3') ?? 0, // 29
            // Reward Permissions
            'permiss_11_1' => $request->input('permiss_11_1') ?? 0, // 30
            'permiss_11_2' => $request->input('permiss_11_2') ?? 0, // 31
            'permiss_11_3' => $request->input('permiss_11_3') ?? 0, // 32
            // Staff Permissions
            'permiss_12_1' => $request->input('permiss_12_1') ?? 0, // 33
            'permiss_12_2' => $request->input('permiss_12_2') ?? 0, // 34 
            'permiss_12_3' => $request->input('permiss_12_3') ?? 0, // 35
            // ProductUnit Permissions
            'permiss_13_1' => $request->input('permiss_13_1') ?? 0, // 36
            'permiss_13_2' => $request->input('permiss_13_2') ?? 0, // 37
            'permiss_13_3' => $request->input('permiss_13_3') ?? 0, // 38
            // ProductSAP Permissions
            'permiss_14_1' => $request->input('permiss_14_1') ?? 0, // 39
            'permiss_14_2' => $request->input('permiss_14_2') ?? 0, // 40
            'permiss_14_3' => $request->input('permiss_14_3') ?? 0, // 41
            // Coupon Permissions
            'permiss_15_1' => $request->input('permiss_15_1') ?? 0, // 42
            'permiss_15_2' => $request->input('permiss_15_2') ?? 0, // 43
            'permiss_15_3' => $request->input('permiss_15_3') ?? 0, // 44
            // PaymentGroup Permissions
            'permiss_16_1' => $request->input('permiss_16_1') ?? 0, // 45
            'permiss_16_2' => $request->input('permiss_16_2') ?? 0, // 46
            'permiss_16_3' => $request->input('permiss_16_3') ?? 0, // 47
            // PaymentType Permissions
            'permiss_17_1' => $request->input('permiss_17_1') ?? 0, // 48
            'permiss_17_2' => $request->input('permiss_17_2') ?? 0, // 49
            'permiss_17_3' => $request->input('permiss_17_3') ?? 0, // 50

            'permiss_18_1' => $request->input('permiss_18_1') ?? 0, // 51
            'permiss_18_2' => $request->input('permiss_18_2') ?? 0, // 52
            'permiss_18_3' => $request->input('permiss_18_3') ?? 0, // 53
            'permiss_19_1' => $request->input('permiss_19_1') ?? 0, // 54
            'permiss_19_2' => $request->input('permiss_19_2') ?? 0, // 55
            'permiss_19_3' => $request->input('permiss_19_3') ?? 0, // 56
            'permiss_20_1' => $request->input('permiss_20_1') ?? 0, // 57
            'permiss_20_2' => $request->input('permiss_20_2') ?? 0, // 58
            'permiss_20_3' => $request->input('permiss_20_3') ?? 0, // 59
            'permiss_21_1' => $request->input('permiss_21_1') ?? 0, // 60
            'permiss_21_2' => $request->input('permiss_21_2') ?? 0, // 61
            'permiss_21_3' => $request->input('permiss_21_3') ?? 0, // 62
            'permiss_22_1' => $request->input('permiss_22_1') ?? 0, // 63
            'permiss_22_2' => $request->input('permiss_22_2') ?? 0, // 64
        ];
        $front_merge = implode($form_front);
        $back_merge = implode($form_back);
        $vendor_merge = implode($form_vendor);
        $permiss_merge = implode($form_permiss);

        if ($form && $form_front && $form_back && $form_vendor && $form_permiss) {
            $update_user = DB::table('user_info')->where('user_id', $id)
                ->update([
                    'user_name' => $form['user_name'],
                    'user_pass' => $form['user_pass'],
                    'branch_id' => $form['branch_id'],
                    'city_license' => $form['city_license'],
                    'card_no' => $form['card_no'],
                    'needresetpass' => $form['needresetpass'],
                    'resetpass_day' => $form['resetpass_day'],
                    'front_permiss' => $front_merge,
                    'back_permiss' => $back_merge,
                    'term_permiss' => $vendor_merge,
                    'function_permiss' => $permiss_merge,
                ]);
            if ($update_user) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated user: ' . $id, [
                    'user_id' => $id,
                    'user_name' => $form['user_name'],
                    'branch_id' => $form['branch_id'],
                    'action' => 'update',
                    'update detail' => $form,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.edit_is_success'));
                return redirect()->route('users.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to update user: ' . $id, [
                    'user_id' => $id,
                    'user_name' => $form['user_name'],
                    'branch_id' => $form['branch_id'],
                    'action' => 'update',
                    'update detail' => $form,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.update_is_failed'));
                return redirect()->route('users.edit', ['id' => $id]);
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to update user due to validation errors: ' . $id, [
                'user_id' => $id,
                'user_name' => $form['user_name'],
                'branch_id' => $form['branch_id'],
                'action' => 'update',
                'update detail' => $form,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.is_failed'));
            return redirect()->route('users.edit', ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 17)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access User Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'User Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $dele_user = DB::table('user_info')->where('user_id', $id)
            ->update(['activeflag' => 0]);

        if (isset($dele_user)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Deleted user: ' . $id, [
                'user_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('users.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to delete user: ' . $id, [
                'user_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('users.index');
        }
    }

    public function changePassword(Request $request)
    {

        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|confirmed',
            ],
            [
                'current_password.required' => __('users.current_password_required'),
                'new_password.required' => __('users.new_password_required'),
                'new_password.confirmed' => __('users.new_password_confirmed'),
            ]
        );


        $userId = session('auth_user.user_id');
        $user = DB::table('user_info')->where('user_id', $userId)->first();

        if ($request->input('current_password') !== $user->user_pass) {
            return back()->with('swal_error', __('users.current_password_incorrect'));
        }

        try {
            DB::table('user_info')->where('user_id', $userId)
                ->update(['user_pass' => $request->input('new_password')]);

            return back()->with('swal_success', __('users.password_change_success'));
        } catch (\Exception $e) {
            return back()->with('swal_error', __('users.password_change_failed'));
        }
    }
}
