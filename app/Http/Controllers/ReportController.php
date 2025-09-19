<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jaspersoft\Client\Client;

class ReportController extends Controller
{
    public function index()
    {
        // $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        // dd($filters);
        $report_name = DB::table('reportname_info')->get();
        return view('pages.reports.index', compact('report_name'));
    }

    public function sum_daily_rpt()
    {
        $filters = DB::table('sum_daily_rpt')->orderBy('batch', 'desc')->get();
        return view('pages.reports.sum_daily.index', compact('filters'));
    }
    public function gen_sum_daily_rpt(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        // dd($b_start,$b_end);
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        // dd($format);
        $client = new Client(
            env('JASPER_URL'),
            env('JASPER_USER'),
            env('JASPER_PASSWORD')
        );

        $reportPath = '/backroomweb/rpt_sum_daily'; // JasperReports Server path
        $outputFormat = $format;
        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            $reportsDir = storage_path('app/reports');
            if (!is_dir($reportsDir)) {
                mkdir($reportsDir, 0755, true);
            }
            $filename = $reportsDir . '/sum_daily_rpt_report_' . date('Y-m-d') . '.' . $format;

            file_put_contents($filename, $report);
            Log::channel('activity')->info('Report generated successfully: ' . $filename, [
                'Report_file' => $filename,
                'output_format' => $outputFormat,
                'generated_at' => now()->toDateTimeString(),
                'generated_by' => session('auth_user.user_name'),
            ]);

            return response()->file($filename);
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sum_debt_rpt()
    {
        $filters = DB::table('sum_debt_rpt')->orderBy('batch', 'desc')->get();
        return view('pages.reports.sum_debt.index', compact('filters'));
    }
    public function gen_sum_debt_rpt(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        // dd($b_start,$b_end);
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        // dd($format);
        $client = new Client(
            env('JASPER_URL'),
            env('JASPER_USER'),
            env('JASPER_PASSWORD')
        );
        // dd($client);
        $reportPath = '/backroomweb/rpt_sum_debt_daily'; // JasperReports Server path
        $outputFormat = $format;
        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'branch_id' => session('auth_user.branch_id'),
                'branch_name' => $branch_name->branch_name,
                'user_name' => session('auth_user.user_name'),
                'b_start' => date('d/m/Y', strtotime($b_start->businessdate)),
                'b_end' => date('d/m/Y', strtotime($b_end->businessdate)),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            $reportsDir = storage_path('app\reports');
            if (!is_dir($reportsDir)) {
                mkdir($reportsDir, 0755, true);
            }
            $filename = $reportsDir . '\sum_debt_rpt_report_' . date('Y-m-d') . '.' . $format;

            file_put_contents($filename, $report);
            Log::channel('activity')->info('Report generated successfully: ' . $filename, [
                'Report_file' => $filename,
                'output_format' => $outputFormat,
                'generated_at' => now()->toDateTimeString(),
                'generated_by' => session('auth_user.user_name'),
            ]);

            return response()->file($filename);
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $outputFormat,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function testReport()
    {
        $client = new Client(
            env('JASPER_URL'),
            env('JASPER_USER'),
            env('JASPER_PASSWORD')
        );
        // $controls = [
        //     'branch_id' => session('auth_user.branch_id'),
        //     'user_name' => session('auth_user.user_name')
            
        // ];
        $report = $client->reportService()->runReport('/backroomweb/test_report', 'pdf', null, null, null);
        return $report;
    }
    public function daily()
    {
        $branch_id  = "000973";
        $start_date = "1";
        $end_date   = "3";

        $url = "http://10.10.1.81:8088/jasperserver/rest_v2/reports/backroomweb/rpt_sum_daily.pdf"
            . "?branch_id={$branch_id}&start_date={$start_date}&end_date={$end_date}"
            . "&j_username=code&j_password=ccooddee";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $pdfContent = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200 && !empty($pdfContent)) {

            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=report.pdf");
            echo $pdfContent;
        } else {

            echo "Cannot connect to JasperServer or report not found. (HTTP Code: $httpCode)";
        }
    }
}
