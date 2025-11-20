<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jaspersoft\Client\Client;

use function Flasher\SweetAlert\Prime\sweetalert;

class ReportVendorController extends Controller
{
    public function index()
    {
        $report_name = DB::table('reportname_info')->where('report_group', '=', '2')->get();
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();

        return view('pages.reports.indexvendor', compact('report_name', 'filters'));
    }

    public function generateVendorReport(Request $request)
    {
        // Logic to generate vendor report based on request parameters

        $report_name_input = $request->input('report_name');
        $format = $request->input('format');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        switch ($report_name_input) {
            case 'rpt_sum_salecard_by_vendor':
                return redirect()->route('rpt_sum_salecard_by_vendor', [
                    'report_name' => $report_name_input,
                    'format' => $format,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
                break;
            case 'rpt_sum_salecard_by_groupvendor':
                return redirect()->route('rpt_sum_salecard_by_groupvendor', [
                    'report_name' => $report_name_input,
                    'format' => $format,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
                break;
            case 'rpt_sum_salecard_by_typeofcard':
                return redirect()->route('rpt_sum_salecard_by_typeofcard', [
                    'report_name' => $report_name_input,
                    'format' => $format,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
                break;
            default:
                sweetalert()
                    ->error(__('report.report_not_found') . __('report.report_select_again'));
                return redirect()->back();
        }
    }

    public function gen_rpt_sum_salecard_by_vendor($format, $start_date, $end_date, $report_name)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        $client = new Client(
            env('JRS_BASE_URL'),
            env('JRS_USERNAME'),
            env('JRS_PASSWORD')
        );
        $reportPath = '/backroomweb/vendor/rpt_sum_salecard_by_vendor';
        $outputFormat = $format;

        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'user_name' => session('auth_user.username'),

            ]);
            $filename = storage_path('app/reports/' . $report_name . time() . '.' . strtolower($outputFormat));

            file_put_contents($filename, $report);
            $displayName = $report_name . '_' . time() . '.' . strtolower($outputFormat);
            return response()->file($filename, [
                'Content-Disposition' => 'inline; filename="' . $displayName . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating report with client: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error_title'      => 'Failed to fetch report using client',
                'error' => $e->getMessage()
            ]);
            sweetalert()
                ->error(__('report.report_error') . __('report.report_error_desc'));
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_salecard_by_groupvendor($format, $start_date, $end_date, $report_name)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        $client = new Client(
            env('JRS_BASE_URL'),
            env('JRS_USERNAME'),
            env('JRS_PASSWORD')
        );
        $reportPath = '/backroomweb/vendor/rpt_sum_salecard_by_groupvendor';
        $outputFormat = $format;

        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'user_name' => session('auth_user.username'),

            ]);
            $filename = storage_path('app/reports/' . $report_name . time() . '.' . strtolower($outputFormat));

            file_put_contents($filename, $report);
            $displayName = $report_name . '_' . time() . '.' . strtolower($outputFormat);
            return response()->file($filename, [
                'Content-Disposition' => 'inline; filename="' . $displayName . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating report with client: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error_title'      => 'Failed to fetch report using client',
                'error' => $e->getMessage()
            ]);
            sweetalert()
                ->error(__('report.report_error') . __('report.report_error_desc'));
            return redirect()->back();
        }
    }

    public function gen_rpt_sum_salecard_by_typeofcard($format, $start_date, $end_date, $report_name)
    {
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        $client = new Client(
            env('JRS_BASE_URL'),
            env('JRS_USERNAME'),
            env('JRS_PASSWORD')
        );
        $reportPath = '/backroomweb/vendor/rpt_sum_salecard_by_typeofcard';
        $outputFormat = $format;

        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'batch_start' => $start_date,
                'batch_end' => $end_date,
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'user_name' => session('auth_user.username'),

            ]);
            $filename = storage_path('app/reports/' . $report_name . time() . '.' . strtolower($outputFormat));

            file_put_contents($filename, $report);
            $displayName = $report_name . '_' . time() . '.' . strtolower($outputFormat);
            return response()->file($filename, [
                'Content-Disposition' => 'inline; filename="' . $displayName . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating report with client: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error_title'      => 'Failed to fetch report using client',
                'error' => $e->getMessage()
            ]);
            sweetalert()
                ->error(__('report.report_error') . __('report.report_error_desc'));
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error generating report with client: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error_title'      => 'Failed to fetch report using client',
                'error' => $e->getMessage()
            ]);
            sweetalert()
                ->error(__('report.report_error') . __('report.report_error_desc'));
            return redirect()->back();
        }
    }
}
