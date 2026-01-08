<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $format = $request->input('format');
        $type_date = $request->input('type_date');
        if ($start_date > $end_date) {
            sweetalert()
                ->error(__('report.report_error') . __('report.report_date_invalid'));
            return redirect()->back();
        }
        if ($report == 'rpt_sum_daily') {

            return redirect()->route(
                'rpt_sum_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_debt_daily') {

            return redirect()->route(
                'rpt_sum_debt_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_cashier_daily') {

            return redirect()->route(
                'rpt_sum_cashier_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_vendor_daily') {

            // dd($start_date, $end_date, $format , 'report_name' => $report );
            return redirect()->route(
                'rpt_sum_vendor_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_use_card_daily') {

            return redirect()->route(
                'rpt_sum_use_card_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type_date' => $type_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_refund_card_daily') {

            return redirect()->route(
                'rpt_sum_refund_card_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type_date' => $type_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_balance_advancecard_daily') {

            return redirect()->route(
                'rpt_sum_balance_advancecard_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type_date' => $type_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_invoicevendor_daily') {

            return redirect()->route(
                'rpt_invoicevendor_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_cardnotreturn') {

            return redirect()->route(
                'rpt_sum_cardnotreturn',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_cardexpire') {

            return redirect()->route(
                'rpt_cardexpire',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type_date' => $type_date,
                    'format' => $format,
                    'report_name' => $report,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_stockcard') {

            return redirect()->route(
                'rpt_stockcard',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } elseif ($report == 'rpt_sum_promotioncard_daily') {

            return redirect()->route(
                'rpt_sum_promotioncard_daily',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
                    'open_mode' => $request->input('open_mode')
                ]
            );
        } else if ($report == 'rpt_sum_expense_vendor') {

            return redirect()->route(
                'rpt_sum_expense_vendor',
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'format' => $format,
                    'report_name' => $report,
                    'type_date' => $type_date,
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

    public function gen_sum_daily_rpt($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_daily';
        $filename  = 'sum_daily_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated daily summary report');
    }

    public function gen_sum_debt_rpt($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_debt_daily';
        $filename  = 'sum_debt_rpt_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated debt daily report');
    }

    public function gen_rpt_sum_cashier_daily($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_cashier_daily';
        $filename  = 'sum_cashier_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated cashier daily report');
    }

    public function gen_rpt_sum_vendor_daily($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_vendor_daily';
        $filename  = 'sum_vendor_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'start_date' => $data['b_start'],
            'end_date' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated vendor daily report');
    }

    public function gen_rpt_sum_use_card_daily($start_date, $end_date, $type_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_use_card_daily';
        $filename  = 'sum_use_card_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
            'type_date' => $type_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated use card daily report');
    }

    public function gen_rpt_sum_refund_card_daily($start_date, $end_date, $type_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_refund_card_daily';
        $filename  = 'sum_refund_card_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'batch_start' => $start_date,
            'batch_end' => $end_date,
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'type_date' => $type_date,
            'format_limit' => $format
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated refund card daily report');
    }

    public function gen_rpt_sum_balance_advancecard_daily($start_date, $end_date, $type_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_balance_advancecard_daily';
        $filename  = 'sum_balance_advancecard_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'batch_start' => $start_date,
            'batch_end' => $end_date,
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'type_date' => $type_date,
            'format_limit' => $format
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated advancecard daily report');
    }

    public function gen_rpt_invoicevendor_daily($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_invoicevendor_daily';
        $filename  = 'invoice_vendor_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated invoice vendor daily report');
    }

    public function gen_rpt_sum_cardnotreturn($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_cardnotreturn';
        $filename  = 'sum_cardnotreturn_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated card not return report');
    }

    public function gen_rpt_cardexpire($start_date, $end_date, $type_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_cardexpire';
        $filename  = 'card_expire_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
            'type_date' => $type_date,
            'format_limit' => $format
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated card expire report');
    }

    public function gen_rpt_stockcard($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_stockcard';
        $filename  = 'stock_card_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated stock card report');
    }

    public function gen_rpt_sum_promotioncard_daily($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_promotioncard_daily';
        $filename  = 'sum_promotioncard_daily_report_' . date('Y-m-d');

        $params = [
            'branch_id' => session('auth_user.branch_id'),
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'user_id' => session('auth_user.user_id'),
            'b_start' => $data['b_start'],
            'b_end' => $data['b_end'],
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated promotion card daily report');
    }
    public function gen_rpt_sum_expense_vendor($start_date, $end_date, $format)
    {
        $data = $this->getBusinessDates($start_date, $end_date);
        $reportPath = '/daily/rpt_sum_expense_vendor';
        $filename  = 'sum_expense_vendor_report_' . date('Y-m-d');

        $params = [
            'branch_name' => $data['branch_name'],
            'user_name' => session('auth_user.user_name'),
            'b_start' => Carbon::createFromFormat('d/m/Y', $data['b_start'])->format('Y-m-d'),
            'b_end' => Carbon::createFromFormat('d/m/Y', $data['b_end'])->format('Y-m-d'),
            'batch_start' => $start_date,
            'batch_end' => $end_date,
        ];
        // dd($params);

        return $this->generateJasperReport($reportPath, $filename, $params, $format, 'Generated expense vendor report');
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
