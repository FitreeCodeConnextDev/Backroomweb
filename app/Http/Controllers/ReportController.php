<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jaspersoft\Client\Client;

use function Symfony\Component\String\s;

class ReportController extends Controller
{

    public function index()
    {
        // $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        // dd($filters);
        $report_name = DB::table('reportname_info')->where('report_group', '=', '1')->get();
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        return view('pages.reports.index', compact('report_name', 'filters'));
    }
    public function toReportName(Request $request)
    {
        $report = $request->input('report_name');
        if ($report == 'rpt_sum_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_debt_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_debt_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_cashier_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_cashier_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_vendor_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            // dd($start_date, $end_date, $format);
            return redirect()->route('rpt_sum_vendor_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_use_card_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type_date = $request->input('type_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_use_card_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'type_date' => $type_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_refund_card_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type_date = $request->input('type_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_refund_card_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'type_date' => $type_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_balance_advancecard_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type_date = $request->input('type_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_balance_advancecard_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'type_date' => $type_date, 'format' => $format]);
        } elseif ($report == 'rpt_invoicevendor_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_invoicevendor_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_cardnotreturn') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_cardnotreturn', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_cardexpire') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type_date = $request->input('type_date');
            $format = $request->input('format');
            return redirect()->route('rpt_cardexpire', ['start_date' => $start_date, 'end_date' => $end_date, 'type_date' => $type_date, 'format' => $format]);
        } elseif ($report == 'rpt_stockcard') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_stockcard', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } elseif ($report == 'rpt_sum_promotioncard_daily') {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $format = $request->input('format');
            return redirect()->route('rpt_sum_promotioncard_daily', ['start_date' => $start_date, 'end_date' => $end_date, 'format' => $format]);
        } else {
            sweetalert()
                ->error(__('report.report_not_found') . __('report.report_select_again'));
            return redirect()->back();
        }
    }
    public function gen_sum_daily_rpt($start_date, $end_date, $format)
    {

        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        // dd($b_start,$b_end);
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_sum_daily'; // JasperReports Server path
        $filename  = 'sum_daily_rpt_report_' . date('Y-m-d');
        // dd($reportPath);
        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated daily summary report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }
    public function gen_sum_debt_rpt($start_date, $end_date, $format)
    {

        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_sum_debt_daily'; // JasperReports Server path
        $filename  = 'sum_debt_rpt_report_' . date('Y-m-d');

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated debt daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }
    public function gen_rpt_sum_cashier_daily($start_date, $end_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        $reportPath = '/daily/rpt_sum_cashier_daily'; // JasperReports Server path
        $filename  = 'sum_cashier_daily_report_' . date('Y-m-d');

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated cashier daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_vendor_daily($start_date, $end_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        // dd($branch_name);
        $reportPath = '/daily/rpt_sum_vendor_daily'; // JasperReports Server path
        $filename  = 'sum_vendor_daily_report_' . date('Y-m-d');

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);
            // dd($client);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated vendor daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_use_card_daily($start_date, $end_date, $type_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        $reportPath = '/daily/rpt_sum_use_card_daily'; // JasperReports Server path
        $filename  = 'sum_use_card_daily_report_' . date('Y-m-d');
        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'type_date' => $type_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated use card daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_refund_card_daily($start_date, $end_date, $type_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_sum_refund_card_daily'; // JasperReports Server path
        $filename  = 'sum_refund_card_daily_report_' . date('Y-m-d');
        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'type_date' => $type_date,
                'format_limit' => $format
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated refund card daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }
    public function gen_rpt_sum_balance_advancecard_daily($start_date, $end_date, $type_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        // dd($branch_name);
        $reportPath = '/daily/rpt_sum_balance_advancecard_daily'; // JasperReports Server path
        $filename  = 'sum_balance_advancecard_daily_report_' . date('Y-m-d');
        // dd($start_date, $end_date, $type_date, $format);    

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'type_date' => $type_date,
                'format_limit' => $format
            ], $format);
            // dd($client);
            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated advancecard daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_invoicevendor_daily($start_date, $end_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_invoicevendor_daily'; // JasperReports Server path
        $filename  = 'invoice_vendor_daily_report_' . date('Y-m-d');

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated invoice vendor daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_cardnotreturn($start_date, $end_date, $format)
    {
        try {
            $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
            $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
            $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
            if ($branch_name == null) {
                $branch_name = (object) ['branch_name' => 'All Branch'];
            }
            $reportPath = '/daily/rpt_sum_cardnotreturn'; // JasperReports Server path
            $filename  = 'sum_cardnotreturn_report_' . date('Y-m-d');
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);
            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated card not return report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_cardexpire($start_date, $end_date, $type_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_cardexpire'; // JasperReports Server path
        $filename  = 'card_expire_report_' . date('Y-m-d');
        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'type_date' => $type_date,
                'format_limit' => $format
            ], $format);
            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated card expire report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_stockcard($start_date, $end_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_stockcard'; // JasperReports Server path
        $filename  = 'stock_card_report_' . date('Y-m-d');
        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);
            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated stock card report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_promotioncard_daily($start_date, $end_date, $format)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/daily/rpt_sum_promotioncard_daily'; // JasperReports Server path
        $filename  = 'sum_promotioncard_daily_report_' . date('Y-m-d');

        try {
            $client = jasper_generate($reportPath, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'user_id' => session('auth_user.user_id'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'batch_start' => $start_date,
                'batch_end' => $end_date,
            ], $format);

            if ($client['status'] === 200 && !empty($client['content'])) {
                Log::channel('activity')->info('Generated promotion card daily report', [
                    'branch_id' => session('auth_user.branch_id'),
                    'user_id' => session('auth_user.user_id'),
                    'start_date' => date('d/m/Y', strtotime($b_start->businessdate)),
                    'end_date' => date('d/m/Y', strtotime($b_end->businessdate)),
                    'batch_start' => $start_date,
                    'batch_end' => $end_date,
                    'output_format' => $format,
                ]);
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
            return redirect()->back();
        }
    }

    public function testReport()
    {
        $format = 'pdf'; // รูปแบบรายงานที่ต้องการ (pdf, html, xlsx, etc.)
        $res = jasper_generate('/test_report', [
            'start_date' => '2025-09-01',
            'end_date'   => '2025-09-23'
        ], $format);
        // dd($res);

        if ($res['status'] === 200 && !empty($res['content'])) {
            // mapping MIME type
            $mimeMap = [
                'pdf'  => 'application/pdf',
                'html' => 'text/html',
                'xml'  => 'application/xml',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'xls'  => 'application/vnd.ms-excel',
                'rtf'  => 'application/rtf',
                'csv'  => 'text/csv',
                'odt'  => 'application/vnd.oasis.opendocument.text',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
                'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ];

            $mime = $mimeMap[strtolower($format)] ?? 'application/octet-stream';

            return response($res['content'], 200, [
                'Content-Type'        => $mime,
                'Content-Disposition' => "inline; filename=report.$format",
            ]);
        }

        return response()->json([
            'error' => 'Failed to fetch report',
            'status' => $res['status'],
            'curl_error' => $res['error'],
            'url' => $res['url'],
        ], 500);
    }

    public function test_report_client()
    {
        $client = new Client(
            env('JRS_BASE_URL'),
            env('JRS_USERNAME'),
            env('JRS_PASSWORD')
        );
        $reportPath = '/backroomweb/test_report'; // JasperReports Server path
        $outputFormat = 'pdf';

        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'branch_id' => '000000',
            ]);
            $filename = storage_path('app/reports/test_report_client_' . time() . '.pdf');

            file_put_contents($filename, $report);
            return response()->file($filename);
        } catch (\Exception $e) {
            Log::error('Error generating report with client: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error_title'      => 'Failed to fetch report using client',
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkConnection()
    {
        return jasper_test_connection();
    }
}
