<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jaspersoft\Client\Client;
use JSRClient;
use App\Helpers\JasperReportHelper;

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
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
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
        $reportPath = '/rpt_sum_daily'; // JasperReports Server path
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
                return response($client['content'], 200, [
                    'Content-Type'        => $client['mime'],
                    'Content-Disposition' => "inline; filename=$filename.$format",
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $format,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error'      => 'Failed to fetch report',
                'status'     => $client['status'],
                'curl_error' => $client['error'],
                'url'        => $client['url'],
            ], 500);
        }
    }

    public function sum_debt_rpt()
    {
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        return view('pages.reports.sum_debt.index', compact('filters'));
    }
    public function gen_sum_debt_rpt(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');
        $b_start = DB::table('closeendday')->select('businessdate')->where('batch', $start_date)->first();
        $b_end = DB::table('closeendday')->select('businessdate')->where('batch', $end_date)->first();
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();
        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }
        $reportPath = '/rpt_sum_debt_daily'; // JasperReports Server path
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
                return response($client['content'], 200, [
                    'Content-Type'        => $client['mime'],
                    'Content-Disposition' => "inline; filename=$filename.$format",
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage(), [
                'report_path' => $reportPath,
                'output_format' => $format,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error'      => 'Failed to fetch report',
                'status'     => $client['status'],
                'curl_error' => $client['error'],
                'url'        => $client['url'],
            ], 500);
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
    public function checkConnection()
    {
        return jasper_test_connection();
    }

    // public function daily()
    // {
    //     $branch_id  = "000973";
    //     $start_date = "1";
    //     $end_date   = "3";

    //     $url = "http://10.10.1.81:8088/jasperserver/rest_v2/reports/backroomweb/rpt_sum_daily.pdf"
    //         . "?branch_id={$branch_id}&start_date={$start_date}&end_date={$end_date}"
    //         . "&j_username=code&j_password=ccooddee";

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    //     $pdfContent = curl_exec($ch);
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);

    //     if ($httpCode == 200 && !empty($pdfContent)) {

    //         header("Content-Type: application/pdf");
    //         header("Content-Disposition: inline; filename=report.pdf");
    //         echo $pdfContent;
    //     } else {

    //         echo "Cannot connect to JasperServer or report not found. (HTTP Code: $httpCode)";
    //     }
    // }
}
