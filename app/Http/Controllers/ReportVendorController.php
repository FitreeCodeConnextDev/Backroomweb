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
        if ($start_date > $end_date) {
            sweetalert()
                ->error(__('report.report_error') . __('report.report_date_invalid'));
            return redirect()->back();
        }
        if ($report_name_input == 'rpt_sum_salecard_by_vendor') {
            return redirect()->route('rpt_sum_salecard_by_vendor', [
                'format' => $format,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'report_name' => $report_name_input,
                'open_mode' => $request->input('open_mode')
            ]);
        } else if ($report_name_input == 'rpt_sum_salecard_by_groupvendor') {
            return redirect()->route('rpt_sum_salecard_by_groupvendor', [
                'format' => $format,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'report_name' => $report_name_input,
                'open_mode' => $request->input('open_mode')
            ]);
        } else if ($report_name_input == 'rpt_sum_salecard_by_groupvendor') {
            return redirect()->route('rpt_sum_salecard_by_groupvendor', [
                'format' => $format,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'report_name' => $report_name_input,
                'open_mode' => $request->input('open_mode')
            ]);
        } else if ($report_name_input == 'rpt_sum_salecard_by_groupvendor') {
            return redirect()->route('rpt_sum_salecard_by_groupvendor', [
                'format' => $format,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'report_name' => $report_name_input,
                'open_mode' => $request->input('open_mode')
            ]);
        } else if ($report_name_input == 'rpt_sum_salecard_by_groupvendor') {
            return redirect()->route('rpt_sum_salecard_by_groupvendor', [
                'format' => $format,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'report_name' => $report_name_input,
                'open_mode' => $request->input('open_mode')
            ]);
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
        return redirect()->back();
    }

    public function gen_rpt_sum_salecard_by_vendor($format, $start_date, $end_date, $report_name)
    {
        $params = $this->getBusinessDates($start_date, $end_date);
        $filename = $report_name . '_' . time() . '.' . strtolower($format);
        return $this->generateJasperReport('/vendor/rpt_sum_salecard_by_vendor', $filename, $params, $format, 'Generate Report');
    }

    public function gen_rpt_sum_salecard_by_groupvendor($format, $start_date, $end_date, $report_name)
    {
        $params = $this->getBusinessDates($start_date, $end_date);
        $filename = $report_name . '_' . time() . '.' . strtolower($format);
        return $this->generateJasperReport('/vendor/rpt_sum_salecard_by_groupvendor', $filename, $params, $format, 'Generate Report');
    }

    public function gen_rpt_sum_salecard_by_typeofcard($format, $start_date, $end_date, $report_name)
    {
        $params = $this->getBusinessDates($start_date, $end_date);
        $filename = $report_name . '_' . time() . '.' . strtolower($format);
        return $this->generateJasperReport('/vendor/rpt_sum_salecard_by_typeofcard', $filename, $params, $format, 'Generate Report');
    }

    public function gen_rpt_sum_salecard_by_refcode($format, $start_date, $end_date, $report_name)
    {
        $params = $this->getBusinessDates($start_date, $end_date);
        $filename = $report_name . '_' . time() . '.' . strtolower($format);
        return $this->generateJasperReport('/vendor/rpt_sum_salecard_by_refcode', $filename, $params, $format, 'Generate Report');
    }
}
