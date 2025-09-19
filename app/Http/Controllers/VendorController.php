<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if (!PermissionHelper::checkUserPermission('back', null, 0)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access to Vendor Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Vendor Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $user_branch = session('auth_user.branch_id');
        // dd($user_session_id);
        $search = $request->input('search', '');

        if ($user_branch == 000000) {
            $vendor_data = DB::table('vendor_info')
                ->select('vendor_id', 'vendor_name')
                ->where('activeflag', '=', 1)
                ->where(function ($query) use ($search) {
                    // If search term is provided, filter by product description or product id
                    if ($search) {
                        $query->where('vendor_name', 'like', '%' . $search . '%')
                            ->orWhere('vendor_id', 'like', '%' . $search . '%');
                    }
                })
                ->orderBy('vendor_id', 'desc')
                ->paginate(15);
            // dd($vendor_data);

            return view('pages.vendors.index', compact('vendor_data', 'search'));
        } else {
            $vendor_data = DB::table('vendor_info')
                ->select('vendor_id', 'vendor_name')
                ->where('activeflag', '=', 1)
                ->where('branch_id', '=', $user_branch)
                ->where(function ($query) use ($search) {
                    // If search term is provided, filter by product description or product id
                    if ($search) {
                        $query->where('vendor_name', 'like', '%' . $search . '%')
                            ->orWhere('vendor_id', 'like', '%' . $search . '%');
                    }
                })
                ->orderBy('vendor_id', 'desc')
                ->paginate(15);
            return view('pages.vendors.index', compact('vendor_data', 'search'));
        }
    }

    public function show(Request $request, $id)
    {
        $vendor_data = DB::table('vendor_info')
            ->where('vendor_id', $id)
            ->first();
        // dd($vendor_data);
        $vendor_user = DB::table('vendoruser_info')
            ->join('user_info', 'vendoruser_info.user_id', '=', 'user_info.user_id')
            ->where('vendoruser_info.vendor_id', $id)
            ->select('user_info.user_id', 'user_info.user_name')
            ->groupBy('user_info.user_id', 'user_info.user_name')
            ->get();
        return view('pages.vendors.show', compact('vendor_data', 'vendor_user'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 0)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access to Vendor Create Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Vendor Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.vendors.create');
    }
    public function store(Request $request)
    {
        $validate_data = $request->validate(
            [
                'vendor_id' => 'required|max:10|unique:vendor_info,vendor_id',
                'branch_id' => 'required',
                'term_id' => 'required',
                'term_seq' => 'required',
                'vendor_name' => 'required',
                'vendor_food' => 'required',
                'issuedate' => 'required',
                'validdate' => 'required',
                'vendor_subfood' => 'nullable',
                'ar_sap' => 'nullable',
                'vendorno' => 'required',
                'productno' => 'required',
                'pmino' => 'nullable',
                'taxbranch' => 'nullable',
                'owner_shop' => 'required',
                'vendor_locate' => 'nullable',
                'serialno' => 'nullable',
                'ipaddress' => 'nullable|ip',
                'txnno' => 'required',
                'vendor_batchno' => 'required',
                'billcount' => 'required',
            ],
            [
                'vendor_id.required' => __('vendor.vendor_id_required'),
                'vendor_id.max' => __('vendor.vendor_id_max'),
                'vendor_id.unique' => __('vendor.vendor_id_unique'),
                'branch_id.required' => __('vendor.brand_id_required'),
                'term_id.required' => __('vendor.term_id_required'),
                'term_seq.required' => __('vendor.term_seq_required'),
                'vendor_name.required' => __('vendor.vendor_name_required'),
                'vendor_food.required' => __('vendor.vendor_food_required'),
                'issuedate.required' => __('vendor.issuedate_required'),
                'validdate.required' => __('vendor.validdate_required'),
                'vendorno.required' => __('vendor.vendorno_required'),
                'productno.required' => __('vendor.productno_required'),
                'owner_shop.required' => __('vendor.owner_shop_required'),
                'txnno.required' => __('vendor.txnno_required'),
                'vendor_batchno.required' => __('vendor.vendor_batchno_required'),
                'billcount.required' => __('vendor.vendor_billcount_required'),
            ]
        );
        // dd($validate_data);
        if (isset($validate_data)) {
            DB::table('vendor_info')->insert([
                'vendor_id' => $validate_data['vendor_id'],
                'branch_id' => $validate_data['branch_id'],
                'term_id' => $validate_data['term_id'],
                'term_seq' => $validate_data['term_seq'],
                'vendor_name' => $validate_data['vendor_name'],
                'vendor_food' => $validate_data['vendor_food'],
                'issuedate' => Carbon::parse($validate_data['issuedate'],)->format('Y-m-d'),
                'validdate' => Carbon::parse($validate_data['validdate'],)->format('Y-m-d'),
                'vendor_subfood' => $validate_data['vendor_subfood'],
                'ar_sap' => $validate_data['ar_sap'],
                'vendorno' => $validate_data['vendorno'],
                'productno' => $validate_data['productno'],
                'pmino' => $validate_data['pmino'],
                'taxbranch' => $validate_data['taxbranch'],
                'owner_shop' => $validate_data['owner_shop'],
                'vendor_locate' => $validate_data['vendor_locate'],
                'serialno' => $validate_data['serialno'],
                'ipaddress' => $validate_data['ipaddress'],
                'txnno' => $validate_data['txnno'],
                'vendor_batchno' => $validate_data['vendor_batchno'],
                'billcount' => $validate_data['billcount'],
                'activeflag' => 1,
            ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Created Vendor', [
                'action' => 'create',
                'vendor_id' => $validate_data['vendor_id'],
                'vendor_name' => $validate_data['vendor_name'],
                'branch_id' => $validate_data['branch_id'],
                'create_at' => Carbon::now()->toDateTimeString(),
                'ceate_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 5000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('vendor-page.index');
        }
        Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Create Vendor', [
            'action' => 'create',
            'create_at' => Carbon::now()->toDateTimeString(),
            'create_by' => session('auth_user.user_id'),
        ]);
        flash()
            ->option('position', 'bottom-right')
            ->option('timeout', 5000)
            ->error(__('menu.save_is_failed'));
        return redirect()->route('vendor-page.index');
    }
    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 1)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access to Vendor Edit Page', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Vendor Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $branch_session = session('auth_user.branch_id');
        $vendor_data = DB::table('vendor_info')
            ->where('vendor_id', $id)
            ->first();
        // dd($vendor_data);
        $vendor_user = DB::table('vendoruser_info')
            ->join('user_info', 'vendoruser_info.user_id', '=', 'user_info.user_id')
            ->where('vendoruser_info.vendor_id', $id)
            ->select('user_info.user_id', 'user_info.user_name')
            ->groupBy('user_info.user_id', 'user_info.user_name')
            ->get();
        if ($branch_session == 000000) {
            $terminal = DB::table('terminal_info')
                ->select('term_id')
                ->orderBy('branch_id', 'asc')
                ->get();
        } else {
            $terminal = DB::table('terminal_info')
                ->select('term_id')
                ->where('branch_id', $branch_session)
                ->orderBy('branch_id', 'asc')
                ->get();
        }
        Log::channel('activity')->info('Vendor Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'vendor_data' => $vendor_data,
            'page' => 'Vendor Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.vendors.edit', compact('vendor_data', 'vendor_user', 'terminal'));
    }
    public function update(Request $request, $id)
    {
        $validate_data = $request->validate(
            [
                'branch_id' => 'required',
                'term_id' => 'required',
                'term_seq' => 'required',
                'vendor_name' => 'required',
                'vendor_food' => 'required',
                'issuedate' => 'required',
                'validdate' => 'required',
                'vendor_subfood' => 'nullable',
                'ar_sap' => 'nullable',
                'vendorno' => 'required',
                'productno' => 'required',
                'pmino' => 'nullable',
                'taxbranch' => 'nullable',
                'owner_shop' => 'required',
                'vendor_locate' => 'nullable',
                'serialno' => 'nullable',
                'ipaddress' => 'nullable|ip',
                'txnno' => 'required',
                'vendor_batchno' => 'required',
                'billcount' => 'required',
            ],
            [
                'branch_id.required' => __('vendor.brand_id_required'),
                'term_id.required' => __('vendor.term_id_required'),
                'term_seq.required' => __('vendor.term_seq_required'),
                'vendor_name.required' => __('vendor.vendor_name_required'),
                'vendor_food.required' => __('vendor.vendor_food_required'),
                'issuedate.required' => __('vendor.issuedate_required'),
                'validdate.required' => __('vendor.validdate_required'),
                'vendorno.required' => __('vendor.vendorno_required'),
                'productno.required' => __('vendor.productno_required'),
                'owner_shop.required' => __('vendor.owner_shop_required'),
                'txnno.required' => __('vendor.txnno_required'),
                'vendor_batchno.required' => __('vendor.vendor_batchno_required'),
                'billcount.required' => __('vendor.vendor_billcount_required'),
            ]
        );
        // dd($validate_data);
        if (isset($validate_data)) {
            DB::table('vendor_info')
                ->where('vendor_id', $id)
                ->update([
                    'branch_id' => $validate_data['branch_id'],
                    'term_id' => $validate_data['term_id'],
                    'term_seq' => $validate_data['term_seq'],
                    'vendor_name' => $validate_data['vendor_name'],
                    'vendor_food' => $validate_data['vendor_food'],
                    'issuedate' => Carbon::parse($validate_data['issuedate'],)->format('Y-m-d'),
                    'validdate' => Carbon::parse($validate_data['validdate'],)->format('Y-m-d'),
                    'vendor_subfood' => $validate_data['vendor_subfood'],
                    'ar_sap' => $validate_data['ar_sap'],
                    'vendorno' => $validate_data['vendorno'],
                    'productno' => $validate_data['productno'],
                    'pmino' => $validate_data['pmino'],
                    'taxbranch' => $validate_data['taxbranch'],
                    'owner_shop' => $validate_data['owner_shop'],
                    'vendor_locate' => $validate_data['vendor_locate'],
                    'serialno' => $validate_data['serialno'],
                    'ipaddress' => $validate_data['ipaddress'],
                    'txnno' => $validate_data['txnno'],
                    'vendor_batchno' => $validate_data['vendor_batchno'],
                    'billcount' => $validate_data['billcount'],
                    'activeflag' => 1,
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor', [
                'action' => 'update',
                'update detail' => $validate_data,
                'vendor_id' => $id,
                'vendor_name' => $validate_data['vendor_name'],
                'branch_id' => $validate_data['branch_id'],
                'update_at' => Carbon::now()->toDateTimeString(),
                'update_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->showConfirmButton(false)
                ->success(__('menu.save_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor', [
                'action' => 'update',
                'update detail' => $validate_data,
                'vendor_id' => $id,
                'update_at' => Carbon::now()->toDateTimeString(),
                'update_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->showConfirmButton(false)
                ->error(__('menu.save_is_failed'));
            return redirect()->back();
        }
    }
    public function destroy($id) {}

    public function vendor_user(Request $request)
    {
        $vendor_user_data =  $request->validate(
            [
                'vendor_id' => 'required',
                'user_id' => 'required',
            ],
            [
                'vendor_id.required' => __('vendor.vendor_id_required'),
                'user_id.required' => __('vendor.user_id_required'),
            ]
        );
        // dd($vendor_user_data);
        if (!$vendor_user_data == null) {
            DB::table('vendoruser_info')
                ->insert([
                    'vendor_id' => $vendor_user_data['vendor_id'],
                    'user_id' => $vendor_user_data['user_id'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Added User to Vendor', [
                'action' => 'add_user',
                'vendor_id' => $vendor_user_data['vendor_id'],
                'user_id' => $vendor_user_data['user_id'],
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['success' => true]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Add User to Vendor', [
                'action' => 'add_user',
                'vendor_id' => $vendor_user_data['vendor_id'],
                'user_id' => $vendor_user_data['user_id'],
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['error' => true]);
        }
    }
    public function vendor_user_delete($vendor_id, $user_id)
    {

        // dd($vendor_user_data);
        $delete_vendor_user = DB::table('vendoruser_info')
            ->where('vendor_id', $vendor_id)
            ->where('user_id', $user_id)
            ->delete();
        if (isset($delete_vendor_user)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Removed User from Vendor', [
                'action' => 'remove_user',
                'vendor_id' => $vendor_id,
                'user_id' => $user_id,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            // return response()->json(['success' => true]);
            sweetalert()

                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Remove User from Vendor', [
                'action' => 'remove_user',
                'vendor_id' => $vendor_id,
                'user_id' => $user_id,
                'action_by' => session('auth_user.user_id'),

            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
            // return response()->json(['error' => true]);
        }
    }
    public function vendor_function_update(Request $request, $id)
    {
        $vendor_function_data =  [
            '0' => 0,
            '1' => $request->input('vendor_function_1'),
            '2' => $request->input('vendor_function_2'),
            '3' => $request->input('vendor_function_3'),
            '4' => $request->input('vendor_function_4'),
            '5' => $request->input('vendor_function_5'),
            '6' => $request->input('vendor_function_6'),

        ];
        // $vendor_func = DB::table('vendor_info')->select('vendor_id','vendor_function')->where('vendor_id', $id)->first();
        $data_im = implode($vendor_function_data);
        // dd($data_im, $id, $vendor_func);
        if (isset($vendor_function_data)) {
            DB::table('vendor_info')
                ->where('vendor_id', $id)
                ->update([
                    'vendor_function' => $data_im,
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor Functions', [
                'action' => 'update_functions',
                'vendor_id' => $id,
                'functions' => $data_im,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            // return redirect()->back()->with('success','ข้อมูลถูกอัพเดทเรียบร้อยแล้ว');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor Functions', [
                'action' => 'update_functions',
                'vendor_id' => $id,
                'functions' => $data_im,
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
            // return redirect()->back()->with('error','ไม่สามารถอัพเดทข้อมูลได้');
        }
    }
    public function vendor_promo_dis(Request $request, $id)
    {
        $form_data = [
            'typediscount' => $request->input('typediscount'),
            'discountamt' => $request->input('discountamt'),
            'cur_discount' => $request->input('cur_discount'),
            'def_discount' => $request->input('def_discount'),
            'use_discount' => $request->input('use_discount'),
            'discount_bdate' => $request->input('discount_bdate'),
            'discount_edate' => $request->input('discount_edate'),
            'discount_btime' => $request->input('discount_btime'),
            'discount_etime' => $request->input('discount_etime'),
        ];
        // dd($form_data, $id);
        // return response()->json($form_data,$id);
        $bdate = Carbon::parse($form_data['discount_bdate'])->format('Y-m-d');
        $edate = Carbon::parse($form_data['discount_edate'])->format('Y-m-d');
        $btime = Carbon::parse($bdate . ' ' . $form_data['discount_btime'])->format('Y-m-d H:i:s');
        $etime = Carbon::parse($edate . ' ' . $form_data['discount_etime'])->format('Y-m-d H:i:s');
        if (isset($form_data)) {
            DB::table('vendor_info')
                ->where('vendor_id', $id)
                ->update([
                    'typediscount' => $form_data['typediscount'],
                    'discountamt' => $form_data['discountamt'],
                    'cur_discount' => $form_data['cur_discount'],
                    'def_discount' => $form_data['def_discount'],
                    'use_discount' => $form_data['use_discount'],
                    'discount_bdate' => $bdate,
                    'discount_edate' => $edate,
                    'discount_btime' => $btime,
                    'discount_etime' => $etime,
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor Discount Promotion', [
                'action' => 'update_discount',
                'vendor_id' => $id,
                'typediscount' => $form_data['typediscount'],
                'discountamt' => $form_data['discountamt'],
                'cur_discount' => $form_data['cur_discount'],
                'def_discount' => $form_data['def_discount'],
                'use_discount' => $form_data['use_discount'],
                'bdate' => $bdate,
                'edate' => $edate,
                'btime' => $btime,
                'etime' => $etime,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor Discount Promotion', [
                'action' => 'update_discount',
                'vendor_id' => $id,
                'bdate' => $bdate,
                'edate' => $edate,
                'btime' => $btime,
                'etime' => $etime,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
        }
    }

    public function vendor_rabbit_update(Request $request, $id)
    {
        $vendor_rabbit = DB::table('vendorpromotionrabbit_info')
            ->where('vendor_id', $id)
            ->first();
        $form_data = [
            'start_date' => $request->input('start_date'),
            'start_time' => $request->input('start_time'),
            'valid_date' => $request->input('valid_date'),
            'valid_time' => $request->input('valid_time'),
            'amount_use' => $request->input('amount_use'),
            'product_id' => $request->input('product_id'),

        ];
        $allday = [
            'monday' => $request->input('monday'),
            'tuesday' => $request->input('tuesday'),
            'wednesday' => $request->input('wednesday'),
            'thursday' => $request->input('thursday'),
            'friday' => $request->input('friday'),
            'saturday' => $request->input('saturday'),
            'sunday' => $request->input('sunday'),
        ];
        // dd($form_data, $id);
        $start_date = Carbon::parse($form_data['start_date'])->format('Y-m-d');
        $valid_date = Carbon::parse($form_data['valid_date'])->format('Y-m-d');
        $date_start = Carbon::parse($start_date . ' ' . $form_data['start_time'])->format('Y-m-d H:i:s');
        $date_valid = Carbon::parse($valid_date . ' ' . $form_data['valid_time'])->format('Y-m-d H:i:s');

        $day_use = implode($allday);
        if (isset($form_data)) {
            if ($vendor_rabbit) {
                // ถ้ามีข้อมูลในฐานข้อมูล
                DB::table('vendorpromotionrabbit_info')
                    ->where('vendor_id', $id)
                    ->update([
                        'start_date' => $date_start,
                        'valid_date' => $date_valid,
                        'day_use' => $day_use,
                        'amount_use' => $form_data['amount_use'],
                        'product_id' => $form_data['product_id'],
                    ]);
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor Rabbit Promotion', [
                    'action' => 'update_rabbit',
                    'vendor_id' => $id,
                    'start_date' => $date_start,
                    'valid_date' => $date_valid,
                    'day_use' => $day_use,
                    'amount_use' => $form_data['amount_use'],
                    'product_id' => $form_data['product_id'],
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'action_by' => session('auth_user.user_id'),

                ]);
                return response()->json(['success' => true, 'message' => __('menu.edit_is_success')]);
            } else {
                // ถ้าไม่มีข้อมูลในฐานข้อมูล
                DB::table('vendorpromotionrabbit_info')
                    ->insert([
                        'vendor_id' => $id,
                        'start_date' => $date_start,
                        'valid_date' => $date_valid,
                        'day_use' => $day_use,
                        'amount_use' => $form_data['amount_use'],
                        'product_id' => $form_data['product_id'],
                    ]);
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Created Vendor Rabbit Promotion', [
                    'action' => 'create_rabbit',
                    'vendor_id' => $id,
                    'start_date' => $date_start,
                    'valid_date' => $date_valid,
                    'day_use' => $day_use,
                    'amount_use' => $form_data['amount_use'],
                    'product_id' => $form_data['product_id'],
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'action_by' => session('auth_user.user_id'),

                ]);
                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor Rabbit Promotion', [
                'action' => 'update_rabbit',
                'vendor_id' => $id,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
        }
    }

    public function vendor_linepay_update(Request $request, $id)
    {
        $vendor_linepay = DB::table('vendorpromotionlinepay_info')
            ->where('vendor_id', $id)
            ->first();
        $form_data = [
            'start_date' => $request->input('start_date'),
            'start_time' => $request->input('start_time'),
            'valid_date' => $request->input('valid_date'),
            'valid_time' => $request->input('valid_time'),
            'amount_use' => $request->input('amount_use'),
            'product_id' => $request->input('product_id'),

        ];
        $allday = [
            'monday' => $request->input('monday'),
            'tuesday' => $request->input('tuesday'),
            'wednesday' => $request->input('wednesday'),
            'thursday' => $request->input('thursday'),
            'friday' => $request->input('friday'),
            'saturday' => $request->input('saturday'),
            'sunday' => $request->input('sunday'),
        ];
        // dd($form_data, $id);
        $start_date = Carbon::parse($form_data['start_date'])->format('Y-m-d');
        $valid_date = Carbon::parse($form_data['valid_date'])->format('Y-m-d');
        $date_start = Carbon::parse($start_date . ' ' . $form_data['start_time'])->format('Y-m-d H:i:s');
        $date_valid = Carbon::parse($valid_date . ' ' . $form_data['valid_time'])->format('Y-m-d H:i:s');

        $day_use = implode($allday);
        if (isset($form_data)) {
            if ($vendor_linepay) {
                DB::table('vendorpromotionlinepay_info')
                    ->where('vendor_id', $id)
                    ->update([
                        'start_date' => $date_start,
                        'valid_date' => $date_valid,
                        'day_use' => $day_use,
                        'amount_use' => $form_data['amount_use'],
                        'product_id' => $form_data['product_id'],
                    ]);
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor LinePay Promotion', [
                    'action' => 'update_linepay',
                    'vendor_id' => $id,
                    'start_date' => $date_start,
                    'valid_date' => $date_valid,
                    'day_use' => $day_use,
                    'amount_use' => $form_data['amount_use'],
                    'product_id' => $form_data['product_id'],
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'action_by' => session('auth_user.user_id'),

                ]);
                return response()->json(['success' => true, 'message' => __('menu.edit_is_success')]);
            } else {
                DB::table('vendorpromotionlinepay_info')
                    ->insert([
                        'vendor_id' => $id,
                        'start_date' => $date_start,
                        'valid_date' => $date_valid,
                        'day_use' => $day_use,
                        'amount_use' => $form_data['amount_use'],
                        'product_id' => $form_data['product_id'],
                    ]);
                Log::channel('activity')->notice(session('auth_user.user_id') . ' Created Vendor LinePay Promotion', [
                    'action' => 'create_linepay',
                    'vendor_id' => $id,
                    'start_date' => $date_start,
                    'valid_date' => $date_valid,
                    'day_use' => $day_use,
                    'amount_use' => $form_data['amount_use'],
                    'product_id' => $form_data['product_id'],
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'action_by' => session('auth_user.user_id'),

                ]);
                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor LinePay Promotion', [
                'action' => 'update_linepay',
                'vendor_id' => $id,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
        }
    }

    public function vendor_invoice_update(Request $request, $id)
    {
        $invoice_form = [
            'invoicename' => $request->input('invoicename'),
            'invoiceaddr1' => $request->input('invoiceaddr1'),
            'invoiceaddr2' => $request->input('invoiceaddr2'),
            'invoiceduedate' => $request->input('invoiceduedate'),
            'invoicepaydate' => $request->input('invoicepaydate'),
            'invoiceprint' => $request->input('invoiceprint'),
            'vendor_paymenttype' => $request->input('vendor_paymenttype'),
        ];

        if ($invoice_form) {
            DB::table('vendor_info')
                ->where('vendor_id', $id)
                ->update([
                    'invoicename' => $invoice_form['invoicename'],
                    'invoiceaddr1' => $invoice_form['invoiceaddr1'],
                    'invoiceaddr2' => $invoice_form['invoiceaddr2'],
                    'invoiceduedate' => $invoice_form['invoiceduedate'],
                    'invoicepaydate' => $invoice_form['invoicepaydate'],
                    'invoiceprint' => $invoice_form['invoiceprint'],
                    'vendor_paymenttype' => $invoice_form['vendor_paymenttype'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Updated Vendor Invoice Information', [
                'action' => 'update_invoice',
                'vendor_id' => $id,
                'invoicename' => $invoice_form['invoicename'],
                'invoiceaddr1' => $invoice_form['invoiceaddr1'],
                'invoiceaddr2' => $invoice_form['invoiceaddr2'],
                'invoiceduedate' => $invoice_form['invoiceduedate'],
                'invoicepaydate' => $invoice_form['invoicepaydate'],
                'invoiceprint' => $invoice_form['invoiceprint'],
                'vendor_paymenttype' => $invoice_form['vendor_paymenttype'],
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['success' => true, 'message' => __('menu.edit_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Update Vendor Invoice Information', [
                'action' => 'update_invoice',
                'vendor_id' => $id,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['message' => __('menu.edit_is_failed')]);
        }
        // dd($invoice_form);
    }


    public function vendor_gp_insert(Request $request)
    {
        $formData = $request->validate(
            [
                'vendor_id' => 'required',
                'gp_code' => 'required',
                'start_date' => 'required|date',
                'valid_date' => 'required|date',
                'gp_min' => 'nullable|numeric',
                'gp_normal' => 'nullable|numeric',
                'gp_promotion' => 'nullable|numeric',
                'gp_member' => 'nullable|numeric',
                'gp_staff' => 'nullable|numeric',
                'gp_rabbit' => 'nullable|numeric',
                'gp_qr' => 'nullable|numeric',
                'gp_sp1' => 'nullable|numeric',
                'gp_sp2' => 'nullable|numeric',
                'gp_sp3' => 'nullable|numeric',
                'gp_sp4' => 'nullable|numeric',
                'gp_sp5' => 'nullable|numeric',
                'gp_edc' => 'nullable|numeric',
            ],
            [
                'vendor_id.required' => __('vendor.vendor_id_required'),
                'gp_code.required' => __('vendor.gp_code_required'),
                'start_date.required' => __('vendor.gp_start_date_required'),
                'start_date.date' => __('vendor.start_date_invalid'),
                'valid_date.required' => __('vendor.gp_valid_date_required'),
                'valid_date.date' => __('vendor.valid_date_invalid'),
                'gp_min.numeric' => __('vendor.gp_min_numeric'),
                'gp_normal.numeric' => __('vendor.gp_normal_numeric'),
                'gp_promotion.numeric' => __('vendor.gp_promotion_numeric'),
                'gp_member.numeric' => __('vendor.gp_member_numeric'),
                'gp_staff.numeric' => __('vendor.gp_staff_numeric'),
                'gp_rabbit.numeric' => __('vendor.gp_rabbit_numeric'),
                'gp_qr.numeric' => __('vendor.gp_qr_numeric'),
                'gp_sp1.numeric' => __('vendor.gp_sp1_numeric'),
                'gp_sp2.numeric' => __('vendor.gp_sp2_numeric'),
                'gp_sp3.numeric' => __('vendor.gp_sp3_numeric'),
                'gp_sp4.numeric' => __('vendor.gp_sp4_numeric'),
                'gp_sp5.numeric' => __('vendor.gp_sp5_numeric'),
                'gp_edc.numeric' => __('vendor.gp_edc_numeric'),
                // Add other validation messages as needed
            ]
        );
        $start_date = Carbon::parse($formData['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($formData['valid_date'])->format('Y-m-d');
        $gp_seq = DB::table('vendorgp_info')->where('vendor_id', $formData['vendor_id'])->max('gp_seq');
        if ($formData) {
            DB::table('vendorgp_info')
                ->insert([
                    'vendor_id' => $formData['vendor_id'],
                    'gp_seq' => $gp_seq + 1,
                    'gp_code' => $formData['gp_code'],
                    'start_date' => $start_date,
                    'valid_date' => $end_date,
                    'gp_min' => $formData['gp_min'],
                    'gp_normal' => $formData['gp_normal'],
                    'gp_promotion' => $formData['gp_promotion'],
                    'gp_member' => $formData['gp_member'],
                    'gp_staff' => $formData['gp_staff'],
                    'gp_rabbit' => $formData['gp_rabbit'],
                    'gp_qr' => $formData['gp_qr'],
                    'gp_sp1' => $formData['gp_sp1'],
                    'gp_sp2' => $formData['gp_sp2'],
                    'gp_sp3' => $formData['gp_sp3'],
                    'gp_sp4' => $formData['gp_sp4'],
                    'gp_sp5' => $formData['gp_sp5'],
                    'gp_edc' => $formData['gp_edc'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Created Vendor GP', [
                'action' => 'create_gp',
                'vendor_id' => $formData['vendor_id'] ?? null,
                'gp_code' => $formData['gp_code'] ?? null,
                'start_date' => $start_date ?? null,
                'valid_date' => $end_date ?? null,
                'gp_min' => $formData['gp_min'] ?? null,
                'gp_normal' => $formData['gp_normal'] ?? null,
                'gp_promotion' => $formData['gp_promotion'] ?? null,
                'gp_member' => $formData['gp_member'] ?? null,
                'gp_staff' => $formData['gp_staff'] ?? null,
                'gp_rabbit' => $formData['gp_rabbit'] ?? null,
                'gp_qr' => $formData['gp_qr'] ?? null,
                'gp_sp1' => $formData['gp_sp1'] ?? null,
                'gp_sp2' => $formData['gp_sp2'] ?? null,
                'gp_sp3' => $formData['gp_sp3'] ?? null,
                'gp_sp4' => $formData['gp_sp4'] ?? null,
                'gp_sp5' => $formData['gp_sp5'] ?? null,
                'gp_edc' => $formData['gp_edc'] ?? null,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Create Vendor GP', [
                'action' => 'create_gp',
                'vendor_id' => $formData['vendor_id'] ?? null,
                'gp_code' => $formData['gp_code'] ?? null,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
        }
    }
    public function vendor_gp_del($gp_seq, $vendor_id)
    {
        if (isset($gp_seq)) {
            DB::table('vendorgp_info')
                ->where('vendor_id', $vendor_id)
                ->where('gp_seq', $gp_seq)
                ->delete();
            Log::channel('activity')->notice(session('auth_user.user_id') . ' Deleted Vendor GP', [
                'action' => 'delete_gp',
                'vendor_id' => $vendor_id,
                'gp_seq' => $gp_seq,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Failed to Delete Vendor GP', [
                'action' => 'delete_gp',
                'vendor_id' => $vendor_id,
                'gp_seq' => $gp_seq,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'action_by' => session('auth_user.user_id'),

            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }
}
