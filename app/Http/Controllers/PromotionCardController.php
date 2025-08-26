<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use App\Http\Requests\CardPromotionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionCardController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 4)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Promotion Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Promotion',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.permission_denied'));
            return redirect()->back();
        }

        $card_promo = DB::table('promotion_info')
            ->select('promo_code', 'promo_desc')
            ->where('activeflag', '=', 1)
            ->orderBy('promo_code', 'asc')
            ->get();

        return view('pages.card_promo.index', compact('card_promo'));
    }
    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 12)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Promotion Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Promotion Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        return view('pages.card_promo.create');
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'promo_code' => 'required|max:10|unique:promotion_info,promo_code',
            'promo_desc' => 'required|string',
            'promo_seq' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'expense_owner' => 'required',
            'req_refno' => 'required',
            'buy_amt' => 'required',
            'get_amt' => 'required',
            'get_point' => 'required',
            'adj_amt' => 'required',
            'adjget_amt' => 'required',
            'adjget_point' => 'required',
            'promo_topup_verify' => 'required',
            'mon_day' => 'required',
            'tue_day' => 'required',
            'wed_day' => 'required',
            'thu_day' => 'required',
            'fri_day' => 'required',
            'sat_day' => 'required',
            'sun_day' => 'required',
            'expire_day' => 'required',
            'priority' => 'required',
            'deposit' => 'required',
            'expire_checkby' => 'required',

        ], [
            'promo_code.required' => __('card_promo.promo_code_valid'),
            'promo_code.max' => __('card_promo.promo_code_max'),
            'promo_code.unique' => __('card_promo.promo_code_unique'),
            'promo_desc' => __('card_promo.promo_desc_valid'),
            'promo_seq' => __('card_promo.promo_seq_valid'),
            'start_date' => __('card_promo.start_date_valid'),
            'end_date' => __('card_promo.end_date_valid'),
            'start_time' => __('card_promo.start_time_valid'),
            'end_time' => __('card_promo.end_time_valid'),
            'expense_owner' => __('card_promo.expense_owner_valid'),
            'req_refno' => __('card_promo.req_refno_valid'),
            'buy_amt' => __('card_promo.buy_amt_valid'),
            'get_amt' => __('card_promo.get_amt_valid'),
            'get_point' => __('card_promo.get_point_valid'),
            'adj_amt' => __('card_promo.adj_amt_valid'),
            'adjget_amt' => __('card_promo.adjget_amt_valid'),
            'adjget_point' => __('card_promo.adjget_point_valid'),
            'promo_topup_verify' => __('card_promo.promo_topup_verify_required'),
            'mon_day' => __('card_promo.mon_day_required'),
            'tue_day' => __('card_promo.tue_day_required'),
            'wed_day' => __('card_promo.wed_day_required'),
            'thu_day' => __('card_promo.thu_day_required'),
            'fri_day' => __('card_promo.fri_day_required'),
            'sat_day' => __('card_promo.sat_day_required'),
            'sun_day' => __('card_promo.sun_day_required'),
            'expire_day' => __('card_promo.expire_day_required'),
            'piority' => __('card_promo.piority_required'),
            'deposit' => __('card_promo.deposit_required'),
            'expire_checkby' => __('card_promo.expire_checkby_required'),

        ]);

        $expire_opt = [
            'expire_weekday' => $request->input('expire_weekday') ?? null,
            'expire_date' => $request->input('expire_date') ?? null,
        ];

        // dd($validate_data, $expire_opt);

        $start_date = Carbon::parse($validate_data['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($validate_data['end_date'])->format('Y-m-d');

        // Combine the date with the time and convert to datetime format (Y-m-d H:i:s)
        $start_datetime = Carbon::parse($start_date . ' ' . $validate_data['start_time'])->format('Y-m-d H:i:s');
        $end_datetime = Carbon::parse($end_date . ' ' . $validate_data['end_time'])->format('Y-m-d H:i:s');

        $days_split = [
            'mon_day' => $validate_data['mon_day'],
            'tue_day' => $validate_data['tue_day'],
            'wed_day' => $validate_data['wed_day'],
            'thu_day' => $validate_data['thu_day'],
            'fri_day' => $validate_data['fri_day'],
            'sat_day' => $validate_data['sat_day'],
            'sun_day' => $validate_data['sun_day'],
        ];
        $days_use = implode($days_split);

        // dd($validate_data, $start_datetime, $end_datetime, $days_use);

        $card_promo_insert = DB::table('promotion_info')
            ->insert([
                'promo_code' => $validate_data['promo_code'],
                'promo_desc' => $validate_data['promo_desc'],
                'promo_seq' => $validate_data['promo_seq'],
                'start_date' => $start_date,
                'start_time' => $start_datetime,
                'end_date' => $end_date,
                'end_time' => $end_datetime,
                'expense_owner' => $validate_data['expense_owner'],
                'req_refno' => $validate_data['req_refno'],
                'buy_amt' => $validate_data['buy_amt'],
                'get_amt' => $validate_data['get_amt'],
                'get_point' => $validate_data['get_point'],
                'adj_amt' => $validate_data['adj_amt'],
                'adjget_amt' => $validate_data['adjget_amt'],
                'adjget_point' => $validate_data['adjget_point'],
                'promo_topup_verify' => $validate_data['promo_topup_verify'],
                'day_use' => $days_use,
                'activeflag' => 1
            ]);
        $expire_indsert = DB::table('promotionexpire_info')
            ->insert([
                'promo_code' => $validate_data['promo_code'],
                'expire_day' => $validate_data['expire_day'],
                'priority' => $validate_data['priority'],
                'deposit' => $validate_data['deposit'],
                'expire_checkby' => $validate_data['expire_checkby'],
                'expire_weekday' => $expire_opt['expire_weekday'],
                'expire_date' => $expire_opt['expire_date'],
            ]);

        if (isset($card_promo_insert, $expire_indsert)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Created new card promotion: ' . $validate_data['promo_code'], [
                'promo_code' => $validate_data['promo_code'],
                'promo_desc' => $validate_data['promo_desc'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('card-promotion.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create card promotion: ' . $validate_data['promo_code'], [
                'promo_code' => $validate_data['promo_code'],
                'promo_desc' => $validate_data['promo_desc'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('card-promotion.create');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 13)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Promotion Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Promotion Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $card_promo = DB::table('promotion_info')
            ->where('promotion_info.promo_code', '=', $id)
            ->first();
        $card_promo_expire = DB::table('promotionexpire_info')
            ->where('promotionexpire_info.promo_code', '=', $id)
            ->first();
        if (!$card_promo || !$card_promo_expire) {
            abort(404);
        }
        $days_all = str_split($card_promo->day_use);
        $day_split = [
            'mon_day' => $days_all[0],
            'tue_day' => $days_all[1],
            'wed_day' => $days_all[2],
            'thu_day' => $days_all[3],
            'fri_day' => $days_all[4],
            'sat_day' => $days_all[5],
            'sun_day' => $days_all[6],
        ];
        $promo_print = DB::table('promotionprint_info')
            ->where('promo_code', '=', $id)
            ->get();
        Log::channel('activity')->info('Card Promotion Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'card_promo' => $card_promo,
            'card_promo_expire' => $card_promo_expire,
            'day_split' => $day_split,
            'promo_print' => $promo_print,
            'page' => 'Card Promotion Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.card_promo.edit', compact('card_promo', 'card_promo_expire', 'day_split', 'promo_print'));
    }
    public function update(Request $request, $id)
    {
        $validate_data = $request->validate([
            'promo_desc' => 'required',
            'promo_seq' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'expense_owner' => 'required',
            'req_refno' => 'required',
            'buy_amt' => 'required',
            'get_amt' => 'required',
            'get_point' => 'required',
            'adj_amt' => 'required',
            'adjget_amt' => 'required',
            'adjget_point' => 'required',
            'promo_topup_verify' => 'required',
            'mon_day' => 'required',
            'tue_day' => 'required',
            'wed_day' => 'required',
            'thu_day' => 'required',
            'fri_day' => 'required',
            'sat_day' => 'required',
            'sun_day' => 'required',
            'expire_day' => 'required',
            'priority' => 'required',
            'deposit' => 'required',
            'expire_checkby' => 'required',

        ], [
            'promo_code.required' => __('card_promo.promo_code_valid'),
            'promo_code.max' => __('card_promo.promo_code_max'),
            'promo_code.unique' => __('card_promo.promo_code_unique'),
            'promo_desc' => __('card_promo.promo_desc_valid'),
            'promo_seq' => __('card_promo.promo_seq_valid'),
            'start_date' => __('card_promo.start_date_valid'),
            'end_date' => __('card_promo.end_date_valid'),
            'start_time' => __('card_promo.start_time_valid'),
            'end_time' => __('card_promo.end_time_valid'),
            'expense_owner' => __('card_promo.expense_owner_valid'),
            'req_refno' => __('card_promo.req_refno_valid'),
            'buy_amt' => __('card_promo.buy_amt_valid'),
            'get_amt' => __('card_promo.get_amt_valid'),
            'get_point' => __('card_promo.get_point_valid'),
            'adj_amt' => __('card_promo.adj_amt_valid'),
            'adjget_amt' => __('card_promo.adjget_amt_valid'),
            'adjget_point' => __('card_promo.adjget_point_valid'),
            'promo_topup_verify' => __('card_promo.promo_topup_verify_required'),
            'mon_day' => __('card_promo.mon_day_required'),
            'tue_day' => __('card_promo.tue_day_required'),
            'wed_day' => __('card_promo.wed_day_required'),
            'thu_day' => __('card_promo.thu_day_required'),
            'fri_day' => __('card_promo.fri_day_required'),
            'sat_day' => __('card_promo.sat_day_required'),
            'sun_day' => __('card_promo.sun_day_required'),
            'expire_day' => __('card_promo.expire_day_required'),
            'piority' => __('card_promo.piority_required'),
            'deposit' => __('card_promo.deposit_required'),
            'expire_checkby' => __('card_promo.expire_checkby_required'),

        ]);

        $days_split = [
            'mon_day' => $request->input('mon_day'),
            'tue_day' => $request->input('tue_day'),
            'wed_day' => $request->input('wed_day'),
            'thu_day' => $request->input('thu_day'),
            'fri_day' => $request->input('fri_day'),
            'sat_day' => $request->input('sat_day'),
            'sun_day' => $request->input('sun_day'),
        ];

        $days_use = implode($days_split);

        $start_date = Carbon::parse($validate_data['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($validate_data['end_date'])->format('Y-m-d');

        // Combine the date with the time and convert to datetime format (Y-m-d H:i:s)
        $start_datetime = Carbon::parse($start_date . ' ' . $validate_data['start_time'])->format('Y-m-d H:i:s');
        $end_datetime = Carbon::parse($end_date . ' ' . $validate_data['end_time'])->format('Y-m-d H:i:s');
        $card_promo_update = DB::table('promotion_info')
            ->where('promo_code', '=', $id)
            ->update([
                'promo_desc' => $validate_data['promo_desc'],
                'promo_seq' => $validate_data['promo_seq'],
                'start_date' => $start_date,
                'start_time' => $start_datetime,
                'end_date' => $end_date,
                'end_time' => $end_datetime,
                'expense_owner' => $validate_data['expense_owner'],
                'req_refno' => $validate_data['req_refno'],
                'buy_amt' => $validate_data['buy_amt'],
                'get_amt' => $validate_data['get_amt'],
                'get_point' => $validate_data['get_point'],
                'adj_amt' => $validate_data['adj_amt'],
                'adjget_amt' => $validate_data['adjget_amt'],
                'adjget_point' => $validate_data['adjget_point'],
                'promo_topup_verify' => $validate_data['promo_topup_verify'],
                'day_use' => $days_use,
            ]);

        $expire_opt = [
            'expire_weekday' => $request->input('expire_weekday') ?? null,
            'expire_date' => $request->input('expire_date') ?? null,
        ];

        $card_expire_update = DB::table('promotionexpire_info')
            ->where('promo_code', '=', $id)
            ->update([
                'expire_day' => $validate_data['expire_day'],
                'priority' => $validate_data['priority'],
                'deposit' => $validate_data['deposit'],
                'expire_checkby' => $validate_data['expire_checkby'],
                'expire_weekday' => $expire_opt['expire_weekday'],
                'expire_date' => $expire_opt['expire_date'],
            ]);

        if (isset($card_promo_update, $card_expire_update)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Updated card promotion: ' . $id, [
                'promo_code' => $id,
                'promo_desc' => $validate_data['promo_desc'],
                'action' => 'update',
                'update detail' => $validate_data,
                'Updated At' => Carbon::now()->toDateTimeString(),
                'Updated By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('card-promotion.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to update card promotion: ' . $id, [
                'promo_code' => $id,
                'promo_desc' => $validate_data['promo_desc'],
                'action' => 'update',
                'update detail' => $validate_data,
                'Updated At' => Carbon::now()->toDateTimeString(),
                'Updated By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('card-promotion.edit');
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('funtion', 14)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Card Promotion Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Card Promotion Delete',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $card_promo_delete = DB::table('promotion_info')
            ->where('promo_code', '=', $id)
            ->update([
                'activeflag' => 0,
            ]);
        // $card_promo_expire_delete = DB::table('promotionexpire_info')
        // ->where('promo_code', '=', $id)
        // ->delete();
        if (isset($card_promo_delete)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Deleted card promotion: ' . $id, [
                'promo_code' => $id,
                'action' => 'delete',
                'Deleted At' => Carbon::now()->toDateTimeString(),
                'Deleted By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('card-promotion.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to delete card promotion: ' . $id, [
                'promo_code' => $id,
                'action' => 'delete',
                'Deleted At' => Carbon::now()->toDateTimeString(),
                'Deleted By' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('card-promotion.index');
        }
    }

    public function store_print(Request $request, $id)
    {
        $promo_expire_print = [
            'promo_code' => $id,
            'start_date' => $request->input('start_date'),
            'valid_date' => $request->input('valid_date'),
            'description1' => $request->input('description1'),
            'description2' => $request->input('description2'),
            'barcode' => $request->input('barcode'),
        ];
        // dd($promo_expire_print);

        $count_seq = DB::table('promotionprint_info')
            ->select('promo_code')->count();
        $seq_t = $count_seq + 1;

        $promo_print_insert = DB::table('promotionprint_info')
            ->insert([
                'promo_code' => $promo_expire_print['promo_code'],
                'promo_seq' => $seq_t,
                'start_date' => $promo_expire_print['start_date'],
                'valid_date' => $promo_expire_print['valid_date'],
                'description1' => $promo_expire_print['description1'],
                'description2' => $promo_expire_print['description2'],
                'barcode' => $promo_expire_print['barcode'],
            ]);
        if (isset($promo_print_insert)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . 'Created new card promotion print: ' . $promo_expire_print['promo_code'], [
                'promo_code' => $promo_expire_print['promo_code'],
                'start_date' => $promo_expire_print['start_date'],
                'valid_date' => $promo_expire_print['valid_date'],
                'description1' => $promo_expire_print['description1'],
                'description2' => $promo_expire_print['description2'],
                'barcode' => $promo_expire_print['barcode'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            return response()->json(['message' => __('menu.save_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . 'Failed to create card promotion print: ' . $promo_expire_print['promo_code'], [
                'promo_code' => $promo_expire_print['promo_code'],
                'start_date' => $promo_expire_print['start_date'],
                'valid_date' => $promo_expire_print['valid_date'],
                'description1' => $promo_expire_print['description1'],
                'description2' => $promo_expire_print['description2'],
                'barcode' => $promo_expire_print['barcode'],
                'action' => 'create',
                'Created At' => Carbon::now()->toDateTimeString(),
                'Created By' => session('auth_user.user_id'),
            ]);
            return response()->json(['message' => __('menu.save_is_failed')]);
        }
    }
}
