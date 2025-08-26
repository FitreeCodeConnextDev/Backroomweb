<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitTest extends Controller
{
    public function index()
    {
        $customers = DB::table('user_info')
            ->select('user_id', 'user_name')
            ->where('activeflag', 1)
            ->get();
        return response()->json(['status' => true, 'message' => 'Customers retrieved successfully', 'data' => $customers], 200);
    }

    public function checkPermiss()
    {
        $user_id = 'admin1';
        $user_permiss = DB::table('user_info')
            ->select('user_id', 'back_permiss', 'function_permiss')
            ->where('user_id', $user_id)
            ->where('activeflag', 1)
            ->first();

        if (empty($user_permiss)) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'There is no user in the system yet.',
                'data' => null
            ], 422);
        }
        // dd(
        //     str_split($user_permiss->back_permiss,),
        //     str_split($user_permiss->function_permiss,)
        // );

        $split_back_permiss = str_split($user_permiss->back_permiss);
        $split_function_permiss = str_split($user_permiss->function_permiss);

        $count_back_permiss = count($split_back_permiss);
        $count_function_permiss = count($split_function_permiss);

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'User has been Loaded',
            'data' => [
                'user_id' => $user_permiss->user_id,
                'back_permiss' => $user_permiss->back_permiss,
                'function_permiss' => $user_permiss->function_permiss,
                'back_permiss_count' => $count_back_permiss,
                'function_permiss_count' => $count_function_permiss,
            ]
        ], 200);
    }
    public function CouponTest(Request $request)
    {
        // Validate request parameters
        $request->validate([
            'start' => 'nullable|integer|min:1',
            'end' => 'nullable|integer|min:1',
            'coupon_name' => 'nullable|string|max:50'
        ]);

        $start = $request->input('start', 1);
        $end = $request->input('end', 999);
        $coupon_name = $request->input('coupon_name', 'FRX');

        $numDigits = strlen((string)$end);

        $data = [];
        $now = Carbon::now();

        for ($i = $start; $i <= $end; $i++) {
            // $coupon_no = $coupon_name . str_pad($i, 4, '0', STR_PAD_LEFT). substr(str_shuffle('0123456789'), 0, 2) ;
            $coupon_no = $coupon_name . str_pad($i, $numDigits, '0', STR_PAD_LEFT);

            // Check if coupon_no already exists
            $exists = DB::table('coupondetail_info')
                ->where('coupon_no', $coupon_no)
                // ->where('coupon_id', 21321)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'code' => 422,
                    'message' => __('coupon.coupon_no_t1') . ' ' . $coupon_no . ' ' . __('coupon.coupon_no_t2'),
                ], 422);
            }

            $data[] = [
                'coupon_name' => $coupon_no . substr(str_shuffle('0123456789'), 0, 2),
                'start_date' => $now->toDateTimeString(),
                'valid_date' => $now->copy()->addDays(30)->toDateTimeString(),
                'created_at' => $now->toDateTimeString()
            ];
        }

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'Failed to generate coupons',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Coupons generated successfully',
            'data' => $data
        ], 200);
    }

    public function chartDaily()
    {
        // Daily report
        // Sale teminal daily
        // select vendor sum(amout) where void = 0 group by vendor_id ชื่อก็ lookup vendor_info
    }

    public function chartDailyBackup(Request $request)
    {
        // Backup report
        // sum terminnal rpt
        // select vendor_id sum(amout) where bussinatedate between start and end  group by vendor_id and vendor_name

        $start = $request->input('start_date', '2024-01-01');
        $end = $request->input('end_date', '2024-01-31');

        // Setting the start and end times to cover the full day range
        $startDate = Carbon::parse($start)->startOfDay()->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($end)->endOfDay()->format('Y-m-d H:i:s');

        $sale_terminal_rpt = DB::table('sum_terminal_rpt')
            ->select('vendor_id', 'vendor_name', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('businessdate', [$startDate, $endDate])
            ->groupBy('vendor_id', 'vendor_name')
            ->orderBy('vendor_id', 'ASC')  // Order by total amount descending
            ->get();

        $data = [];
        foreach ($sale_terminal_rpt as $item) {
            $data[] = [
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $item->vendor_name,
                'total_amount' => number_format($item->total_amount, 2)  // Format amount to 2 decimal places
            ];
        }

        if ($sale_terminal_rpt->isEmpty()) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'No sales data found for the specified period',
                'data' => null
            ], 404);
        }

        $daily_chart['vendor_name'] = " ";
        $daily_chart['total_amount'] = " ";

        foreach ($data as $item) {
            $daily_chart['vendor_name'] .= $item['vendor_name'] . ', ';
            $daily_chart['total_amount'] .= $item['total_amount'] . ', ';
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Daily report retrieved successfully',
            'daily' => $daily_chart['vendor_name'],
            'total_amount' => $daily_chart['total_amount'],
        ], status: 200);
    }
}
