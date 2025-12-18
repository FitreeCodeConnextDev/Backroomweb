<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class ExpenseVendorController extends Controller
{
    public function index()
    {
        $expense_vendor = DB::table('expensevendor_info')->orderBy('exp_code', 'asc')->where('activeflag', '1')->get();
        return view('pages.expense_vendor.index', compact('expense_vendor'));
    }

    public function create()
    {
        return view('pages.expense_vendor.create');
    }

    public function store(Request $request)
    {
        $form_data = $request->validate([
            'exp_code' => 'required',
            'description' => 'required',
            'price_rate' => 'required',
        ], [
            'exp_code.required' => __('expense_vendor.exp_code_required'),
            'description.required' => __('expense_vendor.description_required'),
            'price_rate.required' => __('expense_vendor.price_rate_required'),
        ]);

        if ($form_data) {
            DB::table('expensevendor_info')->insert([
                'exp_code' => $request->exp_code,
                'description' => $request->description,
                'price_rate' => $request->price_rate,
                'activeflag' => '1',
            ]);
            Log::channel('activity')->notice('Create Expense Vendor', [
                'action' => 'Create Expense Vendor',
                'form_data' => [
                    'exp_code' => $request->exp_code,
                    'description' => $request->description,
                    'price_rate' => $request->price_rate,

                ],
                'Created By' => session('auth_user.user_name'),
                'Created At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));

            return redirect()->route('expense_vendor.index');
        } else {
            Log::channel('activity')->error('Create Expense Vendor', [
                'action' => 'Create Expense Vendor',
                'form_data' => [
                    'exp_code' => $request->exp_code,
                    'description' => $request->description,
                    'price_rate' => $request->price_rate,
                ],
                'Created By' => session('auth_user.user_name'),
                'Created At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));

            return redirect()->route('expense_vendor.index');
        }
    }

    public function edit($exp_code)
    {
        $expense_vendor = DB::table('expensevendor_info')->where('exp_code', $exp_code)->first();

        Log::channel('activity')->info('Edit Expense Vendor', [
            'action' => 'Edit Expense Vendor',
            'form_data' => [
                'exp_code' => $expense_vendor->exp_code,
                'description' => $expense_vendor->description,
                'price_rate' => $expense_vendor->price_rate,
            ],
            'Edited By' => session('auth_user.user_name'),
            'Edited At' => now(),
        ]);
        return view('pages.expense_vendor.edit', compact('expense_vendor'));
    }

    public function update(Request $request, $exp_code)
    {
        $form_data = $request->validate([
            'description' => 'required',
            'price_rate' => 'required',
        ], [
            'description.required' => __('expense_vendor.description_required'),
            'price_rate.required' => __('expense_vendor.price_rate_required'),
        ]);

        if ($form_data) {
            DB::table('expensevendor_info')->where('exp_code', $exp_code)->update([
                'description' => $request->description,
                'price_rate' => $request->price_rate,
            ]);
            Log::channel('activity')->notice('Update Expense Vendor', [
                'action' => 'Update Expense Vendor',
                'form_data' => [
                    'exp_code' => $request->exp_code,
                    'description' => $request->description,
                    'price_rate' => $request->price_rate,

                ],
                'Updated By' => session('auth_user.user_name'),
                'Updated At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));

            return redirect()->route('expense_vendor.index');
        } else {
            Log::channel('activity')->error('Update Expense Vendor', [
                'action' => 'Update Expense Vendor',
                'form_data' => [
                    'exp_code' => $request->exp_code,
                    'description' => $request->description,
                    'price_rate' => $request->price_rate,
                ],
                'Updated By' => session('auth_user.user_name'),
                'Updated At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));

            return redirect()->route('expense_vendor.index');
        }
    }
    public function destroy($exp_code)
    {
        DB::table('expensevendor_info')->where('exp_code', $exp_code)->update([
            'activeflag' => '0',
        ]);
        Log::channel('activity')->notice('Delete Expense Vendor', [
            'action' => 'Delete Expense Vendor',
            'form_data' => [
                'exp_code' => $exp_code,
            ],
            'Deleted By' => session('auth_user.user_name'),
            'Deleted At' => now(),
        ]);

        flash()
            ->option('position', 'bottom-right')
            ->option('timeout', 3000)
            ->success(__('menu.delete_is_success'));

        return redirect()->route('expense_vendor.index');
    }

    public function  expensevendor_other()
    {
        $vendor_info = DB::table('vendor_info')->select('vendor_id', 'vendor_name')->where('activeflag', '1')->orderBy('vendor_id', 'asc')->get();
        $expense_vendor = DB::table('expensevendor_info')->select('exp_code', 'description')->where('activeflag', '1')->orderBy('exp_code', 'asc')->get();
        $currentMonth = date('n');
        $thaiMonths = [
            1 => 'มกราคม', // January
            2 => 'กุมภาพันธ์', // February
            3 => 'มีนาคม', // March
            4 => 'เมษายน', // April
            5 => 'พฤษภาคม', // May
            6 => 'มิถุนายน', // June
            7 => 'กรกฎาคม', // July
            8 => 'สิงหาคม', // August
            9 => 'กันยายน', // September
            10 => 'ตุลาคม', // October
            11 => 'พฤศจิกายน', // November
            12 => 'ธันวาคม', // December
        ];
        return view('pages.expensevendor_other.index', compact('vendor_info', 'expense_vendor', 'thaiMonths', 'currentMonth'));
    }
    public function store_other(Request $request)
    {
        $form_data = $request->validate([
            'txnyear' => 'required',
            'txnmonth' => 'required',
            'txndate' => 'required',
            'duedate' => 'required',
            'vendor_id' => 'required',
            'exp_code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_no' => 'required',
            'end_no' => 'required',
            'price_rate' => 'required',
            'total' => 'required',
        ], [
            'txnyear.required' => __('expense_vendor.txnyear_required'),
            'txnmonth.required' => __('expense_vendor.txnmonth_required'),
            'txndate.required' => __('expense_vendor.txndate_required'),
            'duedate.required' => __('expense_vendor.duedate_required'),
            'vendor_id.required' => __('expense_vendor.vendor_id_required'),
            'exp_code.required' => __('expense_vendor.exp_code_required'),
            'start_date.required' => __('expense_vendor.start_date_required'),
            'end_date.required' => __('expense_vendor.end_date_required'),
            'start_no.required' => __('expense_vendor.start_no_required'),
            'end_no.required' => __('expense_vendor.end_no_required'),
            'price_rate.required' => __('expense_vendor.price_rate_required'),
            'total.required' => __('expense_vendor.total_required'),
        ]);

        $existing_vendor_record = DB::table('sum_expense_rpt')
            ->where('txnyear', $form_data['txnyear'])
            ->where('txnmonth', $form_data['txnmonth'])
            ->where('vendor_id', $form_data['vendor_id'])
            ->first();

        if ($existing_vendor_record) {
            $invoinceno = $existing_vendor_record->invoiceno;
        } else {
            $max_invoinceno = DB::table('sum_expense_rpt')
                ->where('txnyear', $form_data['txnyear'])
                ->where('txnmonth', $form_data['txnmonth'])
                ->max('invoiceno');

            if ($max_invoinceno) {
                $sequence = intval(substr($max_invoinceno, -3)) + 1;
            } else {
                $sequence = 1;
            }
            $invoinceno = $form_data['txnyear'] . $form_data['txnmonth'] . sprintf('%03d', $sequence);
        }

        $sum_expense_exists = DB::table('sum_expense_rpt')
            ->where('txnyear', $form_data['txnyear'])
            ->where('txnmonth', $form_data['txnmonth'])
            ->where('vendor_id', $form_data['vendor_id'])
            ->where('exp_code', $form_data['exp_code'])
            ->first();

        if ($sum_expense_exists) {
            DB::table('sum_expense_rpt')
                ->where('txnyear', $sum_expense_exists->txnyear)
                ->where('txnmonth', $sum_expense_exists->txnmonth)
                ->where('vendor_id', $sum_expense_exists->vendor_id)
                ->where('exp_code', $sum_expense_exists->exp_code)
                ->update([
                    'start_no' => $form_data['start_no'],
                    'end_no' => $form_data['end_no'],
                    'qty' => $form_data['end_no'] - $form_data['start_no'] + 1,
                    'price_rate' => $form_data['price_rate'],
                    'total' => $form_data['total'],
                    'txndate' => $form_data['txndate'],
                    'duedate' => $form_data['duedate'],
                    'start_date' => $form_data['start_date'],
                    'end_date' => $form_data['end_date'],
                ]);

            Log::channel('activity')->notice('Update Sum Expense Report', [
                'action' => 'Update Sum Expense Report',
                'form_data' => $form_data,
                'Updated By' => session('auth_user.user_name'),
                'Updated At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));

            return redirect()->route('expensevendor_other_index');
        } else {
            DB::table('sum_expense_rpt')->insert([
                'txnyear' => $form_data['txnyear'],
                'txnmonth' => $form_data['txnmonth'],
                'exp_code' => $form_data['exp_code'],
                'vendor_id' => $form_data['vendor_id'],
                'vendor_name' => DB::table('vendor_info')->where('vendor_id', $form_data['vendor_id'])->value('vendor_name'),
                'start_no' => $form_data['start_no'],
                'end_no' => $form_data['end_no'],
                'qty' => $form_data['end_no'] - $form_data['start_no'] + 1,
                'price_rate' => $form_data['price_rate'],
                'total' => $form_data['total'],
                'txndate' => $form_data['txndate'],
                'duedate' => $form_data['duedate'],
                'invoiceno' => $invoinceno,
                'start_date' => $form_data['start_date'],
                'end_date' => $form_data['end_date'],
            ]);

            Log::channel('activity')->notice('Create Sum Expense Report', [
                'action' => 'Create Sum Expense Report',
                'form_data' => $form_data,
                'invoinceno' => $invoinceno,
                'Created By' => session('auth_user.user_name'),
                'Created At' => now(),
            ]);
        }

        flash()
            ->option('position', 'bottom-right')
            ->option('timeout', 3000)
            ->success(__('menu.save_is_success'));

        return redirect()->route('expensevendor_other_index');
    }

    public function destroy_expensevendor_other($txnyear, $txnmonth, $vendor_id, $exp_code)
    {
        if (DB::table('sum_expense_rpt')
            ->where('txnyear', $txnyear)
            ->where('txnmonth', $txnmonth)
            ->where('vendor_id', $vendor_id)
            ->where('exp_code', $exp_code)
            ->exists()
        ) {
            DB::table('sum_expense_rpt')
                ->where('txnyear', $txnyear)
                ->where('txnmonth', $txnmonth)
                ->where('vendor_id', $vendor_id)
                ->where('exp_code', $exp_code)
                ->delete();

            Log::channel('activity')->notice('Delete Sum Expense', [
                'action' => 'Delete Sum Expense',
                'txnyear' => $txnyear,
                'txnmonth' => $txnmonth,
                'vendor_id' => $vendor_id,
                'exp_code' => $exp_code,
                'Deleted By' => session('auth_user.user_name'),
                'Deleted At' => now(),
            ]);

            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));

            return redirect()->route('expensevendor_other_index');
        } else {
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));

            return redirect()->route('expensevendor_other_index');
        }
    }
}
