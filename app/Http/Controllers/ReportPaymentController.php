<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportPaymentController extends Controller
{
    public function index()
    {
        $report_name = DB::table('reportname_info')->where('report_group', '=', '5')->get();
        $filters = DB::table('closeendday')->orderBy('batch', 'desc')->get();
        return view('pages.reports.indexpayment', compact('report_name', 'filters'));
    }

    public function toReportPayment(Request $request)
    {
        // Logic to generate payment report based on request parameters
        $report = $request->input('report_name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');

        if ($start_date > $end_date) {
            sweetalert()
                ->error(__('report.report_error') . __('report.report_date_invalid'));
            return redirect()->back();
        }
        // Implement report generation logic here
        if ($report == 'rpt_sum_use_thaiqr') {
            return redirect()->route(
                'rpt_sum_use_thaiqr',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_thaiqr_by_vendor') {
            return redirect()->route(
                'rpt_sum_use_thaiqr_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_detail_use_thaiqr_by_vendor') {
            return redirect()->route(
                'rpt_detail_use_thaiqr_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_alipay') {
            return redirect()->route(
                'rpt_sum_use_alipay',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_alipay_by_vendor') {
            return redirect()->route(
                'rpt_sum_use_alipay_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_detail_use_alipay_by_vendor') {
            return redirect()->route(
                'rpt_detail_use_alipay_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_wechat') {
            return redirect()->route(
                'rpt_sum_use_wechat',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_wechat_by_vendor') {
            return redirect()->route(
                'rpt_sum_use_wechat_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_detail_use_wechat_by_vendor') {
            return redirect()->route(
                'rpt_detail_use_wechat_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_true') {
            return redirect()->route(
                'rpt_sum_use_wechat',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_use_true_by_vendor') {
            return redirect()->route(
                'rpt_sum_use_true_by_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_detail_use_true_by_vendor') {
            return redirect()->route(
                'rpt_detail_use_true_by_vendor',
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
        // Fetch businessdate values (as strings) for the given batch identifiers
        $b_start = DB::table('closeendday')->where('batch', $start_date)->value('businessdate');
        $b_end = DB::table('closeendday')->where('batch', $end_date)->value('businessdate');
        $branch_name = DB::table('branch_info')->select('branch_name')->where('branch_id', session('auth_user.branch_id'))->first();

        if ($branch_name == null) {
            $branch_name = (object) ['branch_name' => 'All Branch'];
        }

        // If both dates exist, compare their timestamps to ensure start is not after end
        // if ($b_start && $b_end && strtotime($b_start) > strtotime($b_end)) {
        //     sweetalert()
        //         ->error(__('report.report_error') . __('report.report_error_desc'));
        //     return redirect()->back();
        // }

        return [
            'b_start' => $b_start ? date('d/m/Y', strtotime($b_start)) : null,
            'b_end' => $b_end ? date('d/m/Y', strtotime($b_end)) : null,
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
            return response("<script>alert('Failed to fetch report'); window.close();</script>");
        }
        return redirect()->back();
    }

    public function gen_rpt_sum_use_thaiqr($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/thaiqr/rpt_sum_use_thaiqr';
        $filename  = 'rpt_sum_use_thaiqr_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_use_thaiqr_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/thaiqr/rpt_sum_use_thaiqr_by_vendor';
        $filename  = 'rpt_sum_use_thaiqr_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_detail_use_thaiqr_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/thaiqr/rpt_detail_use_thaiqr_by_vendor';
        $filename  = 'rpt_detail_use_thaiqr_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }

    public function gen_rpt_sum_use_alipay($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/alipay/rpt_sum_use_alipay';
        $filename  = 'rpt_sum_use_alipay_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_use_alipay_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/alipay/rpt_sum_use_alipay_by_vendor';
        $filename  = 'rpt_sum_use_alipay_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }

    public function gen_rpt_detail_use_alipay_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/alipay/rpt_detail_use_alipay_by_vendor';
        $filename  = 'rpt_detail_use_alipay_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }

    public function gen_rpt_sum_use_wechat($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/wechat/rpt_sum_use_wechat';
        $filename  = 'rpt_sum_use_wechat_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_use_wechat_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/wechat/rpt_sum_use_wechat_by_vendor';
        $filename  = 'rpt_sum_use_wechat_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_detail_use_wechat_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/wechat/rpt_detail_use_wechat_by_vendor';
        $filename  = 'rpt_detail_use_wechat_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }

    public function gen_rpt_sum_use_true($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/true/rpt_sum_use_true';
        $filename  = 'rpt_sum_use_true_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_sum_use_true_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/true/rpt_sum_use_true_by_vendor';
        $filename  = 'rpt_sum_use_true_by_vendor_' . date('Y-m-d');
        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);
        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
    public function gen_rpt_detail_use_true_by_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date, $format);
        $reportPath = '/true/rpt_detail_use_true_by_vendor';
        $filename  = 'rpt_detail_use_true_by_vendor_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated report: ' . $start_date . ' - ' . $end_date);
    }
}
