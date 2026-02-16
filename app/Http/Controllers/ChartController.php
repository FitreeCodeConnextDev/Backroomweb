<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chartDaily()
    {
        // $product_details = DB::table('productdetail_info')
        //     ->join('product_info', 'product_info.product_id', '=', 'productdetail_info.product_id')
        //     ->join('unit_info', 'product_info.unit_id', '=', 'unit_info.unit_id')  // JOIN กับ unit_info
        //     ->where('vendor_id', '=', '100088')
        //     ->get();
        // dd($product_details);
        $sale_terminal_daily = DB::table('sale_terminal_daily')->select('vendor_info.vendor_name', 'vendor_info.vendor_id', DB::raw('SUM(amount) as total_amount'))
            ->join('vendor_info', 'vendor_info.vendor_id', '=', 'sale_terminal_daily.vendor_id')
            ->where('void_flag', 0)
            ->groupBy('vendor_info.vendor_id', 'vendor_name')
            ->orderBy('total_amount', 'DESC')
            ->get();

        $data = [];
        foreach ($sale_terminal_daily as $item) {
            $data[] = [
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $item->vendor_name,
                'total_amount' => $item->total_amount
            ];
        }
        $data_json = json_encode($data);
        // dd($data);
        $sale_terminal_daily_chart['vendor_name'] = " ";
        $sale_terminal_daily_chart['total_amount'] = " ";
        $sale_terminal_daily_chart['vendor_id'] = " ";
        foreach ($data as $item) {
            $sale_terminal_daily_chart['vendor_name'] .= "'" . $item['vendor_name'] . "'" . ', ';
            $sale_terminal_daily_chart['total_amount'] .= $item['total_amount'] . ', ';
            $sale_terminal_daily_chart['vendor_id'] .= $item['vendor_id'] . ', ';
        }


        // dd($data);

        return view('pages.charts.daily', compact('sale_terminal_daily_chart'));

        // Daily report
        // Sale teminal daily
        // select vendor sum(amout) where void = 0 group by vendor_id ชื่อก็ lookup vendor_info

        // Backup report
        // sum terminnal rpt
        // select vendor sum(amout) where bussinatedate between start and end  group by vendor_id and vendor_name


    }
    public function chartDailyBackup(Request $request)
    {
        // $start_date = date('Y-m-d', strtotime('yesterday'));
        // $end_date = date('Y-m-d', strtotime('yesterday'));
        // $start_date = '2024-01-01';
        // $end_date = '2024-01-31';
        // get the min and max batch values (scalars) to use in whereBetween
        $start_date = DB::table('closeendday')->max('batch');
        $end_date = DB::table('closeendday')->max('batch');
        $day_filter = DB::table('closeendday')->orderBy('batch', 'desc')->get();

        // if no batch values exist, return an empty collection to avoid errors
        if (is_null($start_date) || is_null($end_date)) {
            $sale_terminal_rpt = collect();
        } else {
            $sale_terminal_rpt = DB::table('sum_terminal_rpt')
                ->select('vendor_id', 'vendor_name', DB::raw('SUM(amount) as total_amount'))
                ->whereBetween('batch', [$start_date, $end_date])
                ->groupBy('vendor_id', 'vendor_name')
                ->orderBy('total_amount', 'DESC')
                ->get();
        }

        // เตรียมข้อมูลที่ส่งกลับ
        $data = [];
        foreach ($sale_terminal_rpt as $item) {
            $data[] = [
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $item->vendor_name,
                'total_amount' => $item->total_amount
            ];
        }
        $data_json = json_encode($data);

        $daily_chart_backup['vendor_name'] = " ";
        $daily_chart_backup['total_amount'] = " ";
        $daily_chart_backup['vendor_id'] = " ";
        foreach ($data as $item) {
            $daily_chart_backup['vendor_name'] .= "'" . $item['vendor_name'] . "'" . ', ';
            $daily_chart_backup['total_amount'] .= $item['total_amount'] . ', ';
            $daily_chart_backup['vendor_id'] .= $item['vendor_id'] . ', ';
        }


        // dd($data_json);

        return view('pages.charts.backupDaily', compact('data_json', 'start_date', 'end_date', 'day_filter', 'daily_chart_backup'));

        // sum terminnal rpt
        // select vendor_id sum(amout) where bussinatedate between start and end  group by vendor_id and vendor_name
    }
    public function showDailyChartBackup(Request $request)
    {
        // รับค่าจากฟอร์ม (ถ้าไม่มีค่า จะใช้ค่าดีฟอลต์)
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $day_filter = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        // dd($start, $end);

        // ตั้งค่าช่วงเวลาของวันที่ให้ครอบคลุมทั้งวัน
        // $start = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
        // $end = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');

        // ดึงข้อมูลจากฐานข้อมูล
        $sale_terminal_rpt = DB::table('sum_terminal_rpt')
            ->select('vendor_id', 'vendor_name', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('batch', [$start_date, $end_date])
            ->groupBy('vendor_id', 'vendor_name')
            ->orderBy('total_amount', 'DESC') // เรียงลำดับตามยอดรวมจากมากไปน้อย
            ->get();

        // เตรียมข้อมูลที่ส่งกลับ
        // dd($sale_terminal_rpt);
        $data = [];
        foreach ($sale_terminal_rpt as $item) {
            $data[] = [
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $item->vendor_name,
                'total_amount' => $item->total_amount
            ];
        }
        $data_json = json_encode($data);
        // dd($data);
        if ($sale_terminal_rpt->isEmpty()) {
            sweetalert()
                ->error(__('chart.sale_not_found') . ' ' . $start_date . ' - ' . $end_date,);
            return redirect()->back();
        }
        $count_data = count($sale_terminal_rpt);
        if ($count_data > 1500) {
            sweetalert()
                ->warning(__('chart.too_many_records') . ' ' . $start_date . ' - ' . $end_date);
            return redirect()->back();
        }


        // เตรียมข้อมูลที่ส่งกลับ
        $daily_chart_backup['vendor_name'] = " ";
        $daily_chart_backup['total_amount'] = " ";
        $daily_chart_backup['vendor_id'] = " ";
        foreach ($data as $item) {
            $daily_chart_backup['vendor_name'] .= '"' . $item['vendor_name'] . '"' . ', ';
            $daily_chart_backup['total_amount'] .= $item['total_amount'] . ', ';
            $daily_chart_backup['vendor_id'] .= $item['vendor_id'] . ', ';
        }
        // dd($daily_chart_backup);
        return view('pages.charts.backupDaily', compact('data_json', 'start_date', 'end_date', 'day_filter', 'daily_chart_backup'));
    }
}
