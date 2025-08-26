<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jaspersoft\Client\Client;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.reports.index');
    }

    public function testReport()
    {
        $client = new Client(
            env('JASPER_URL'),
            env('JASPER_USER'),
            env('JASPER_PASSWORD')
        );
        $reportPath = '/Test_web_backroom/report_test2'; // JasperReports Server path
        $outputFormat = 'pdf';

        try {
            $report = $client->reportService()->runReport($reportPath, $outputFormat, null, null, [
                'branch_id' => '000891',
                'title_report' => 'รายงานผู้ใช้งาน',
                'user_id_c' => 'รหัส',
                'user_name_c' => 'ชื่อผู้ใช้งาน',
                'user_lock_c' => 'สถานะ',
                'activeflag_c' => 'สถานะการใช้งาน'
            ]);
            $reportsDir = storage_path('app\reports');
            if (!is_dir($reportsDir)) {
                mkdir($reportsDir, 0755, true);
            }
            $filename = $reportsDir . '\test_user_report_' . time() . '.pdf';

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
    
}
