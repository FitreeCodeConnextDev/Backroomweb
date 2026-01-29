<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportItemController extends Controller
{
    public function index()
    {
        $report_name = DB::table('reportname_info')->where('report_group', '=', '3')->get();
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        return view('pages.reports.indexitem', compact('report_name', 'filters'));
    }
    public function toReportItem(Request $request)
    {
        $report = $request->input('report_name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');
        $type_date = $request->input('type_date');
        // dd($report, $start_date, $end_date, $format, $type_date);
        if ($start_date > $end_date) {
            sweetalert()
                ->error(__('report.report_error') . __('report.report_date_invalid'));
            return redirect()->back();
        }
        if ($report == 'rpt_sum_item_by_product') {
            return redirect()->route(
                'rpt_sum_item_by_product',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_item_by_groupproduct') {

            return redirect()->route(
                'rpt_sum_item_by_groupproduct',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_item_by_vendor') {

            return redirect()->route(
                'rpt_sum_item_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_item_by_groupvendor') {

            return redirect()->route(
                'rpt_sum_item_by_groupvendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_stock_by_vendor_product') {
            return redirect()->route(
                'rpt_stock_by_vendor_product',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_stock_balance_daily') {
            return redirect()->route(
                'rpt_stock_balance_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_item_by_typevendor') {
            return redirect()->route(
                'rpt_sum_item_by_typevendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_itembest_by_vendor') {
            return redirect()->route(
                'rpt_sum_itembest_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else {
            sweetalert()
                ->error(__('report.report_not_found') . __('report.report_select_again'));
            return redirect()->back();
        }
    }
    private function getBusinessDates($start_date, $end_date)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();

        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        return [
            'b_start' => $b_start ? date('d/m/Y', strtotime($b_start->businessdate)) : null,
            'b_end' => $b_end ? date('d/m/Y', strtotime($b_end->businessdate)) : null,
            'branch_name' => $branch_name->branch_name
        ];
    }

    private function generateJasperReport($reportPath, $filename, $params, $format, $logMessage = null)
    {
        try {
            $client = jasper_generate($reportPath, $params, $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                if ($logMessage) {
                    Log::channel('activity')->info($logMessage, array_merge([
                        'branch_id' => session('auth_user.branch_id'),
                        'user_id' => session('auth_user.user_id'),
                        'output_format' => $format,
                    ], $params));
                }

                return response($client['content'], 200, [
                    'Content-Type'        => $client['mime'],
                    'Content-Disposition' => "inline; filename=$filename.$format",
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $format,
                'error_title'      => 'Failed to fetch report',
                'error' => $e->getMessage()
            ]);
        }
        if (request('open_mode') === 'popup') {
            return response("<script>alert('" . __('report.report_failed_fetch') . "'); window.close();</script>");
        }
        return response()->json([
            'error' => 'Failed to fetch report',
            'status' => $client['status'] ?? 'unknown',
            'curl_error' => $client['error'] ?? 'unknown',
        ], 500);
    }

    public function gen_rpt_sum_item_by_product($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_item_by_product';
        $filename  = 'sum_item_by_product_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_item_by_groupproduct($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_item_by_groupproduct';
        $filename  = 'sum_item_by_groupproduct_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_item_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_item_by_vendor';
        $filename  = 'sum_item_by_vendor_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_item_by_groupvendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_item_by_groupvendor';
        $filename  = 'sum_item_by_groupvendor_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_stock_by_vendor_product($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_stock_by_vendor_product';
        $filename  = 'rpt_stock_by_vendor_product' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_stock_balance_daily($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_stock_balance_daily';
        $filename  = 'stock_balance_daily_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_item_by_typevendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_item_by_typevendor';
        $filename  = 'sum_item_by_typevendor_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_itembest_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/item/rpt_sum_itembest_by_vendor';
        $filename  = 'sum_itembest_by_vendor_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
}
