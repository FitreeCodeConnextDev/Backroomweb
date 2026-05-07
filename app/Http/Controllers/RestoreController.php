<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RestoreController extends Controller
{
    public function index()
    {
        return view('pages.restore.index');
    }


    public function restoreMasterData(Request $request)
    {
        // 1. ระบุชื่อ Master Tables ทั้งหมดที่ต้องการ Restore
        $masterTables = [
            'branch_info',
            'changeuser_info',
            'client_info',
            'coupon_info',
            'coupondetail_info',
            'expensevendor_info',
            'grouppaymenttype_info',
            'groupproduct_info',
            'grouptypeproduct_info',
            'guide_info',
            'member_info',
            'paymenttype_info',
            'product_info',
            'promotion_info',
            'redeemitem_info',
            'staff_info',
            'sub_info',
            'terminal_info',
            'timecrossbranch_info',
            'typeproduct_info',
            'unit_info',
            'user_info',
            'userprofile_info',
            'vendor_info',
            'vendorproduct_info',
            'vendorproduct_temp_info',
            'vendorprogress_info',
            'vendorprogressmonth_info',
            'vendorpromotion_info'
        ];

        $restoreSummary = []; // สำหรับเก็บ List สรุปผล
        $totalRestored = 0;   // สำหรับเก็บยอดรวมทั้งหมด

        // เริ่มต้น Transaction เพื่อความปลอดภัยของข้อมูล
        DB::beginTransaction();

        try {
            foreach ($masterTables as $table) {
                // 2. สั่ง Update และรับค่าจำนวน Record ที่ถูกแก้ไข (Affected Rows)
                $affectedRows = DB::table($table)
                    ->where('activeflag', 0)
                    ->update(['activeflag' => 1]);

                // สำหรับ test
                // $affectedRows = rand(0, 15);

                // 3. เก็บข้อมูลลง List สรุปผล
                $restoreSummary[] = [
                    'table_name' => $table,
                    'restored_count' => $affectedRows
                ];

                $totalRestored += $affectedRows;
            }
            // ถ้าทุกอย่างผ่านไปด้วยดี ให้ยืนยันการบันทึกข้อมูล
            DB::commit();

            // 4. ส่งค่ากลับไปแสดงผล (ตัวอย่างส่งกลับเป็น JSON สำหรับ API หรือ Ajax)
            Log::channel('activity')->info(session('auth_user.user_id') . ' Restore Data', [
                'summary' => $restoreSummary,
                'total_restored' => $totalRestored,
                'action' => 'restore',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->position('bottom-right')
                ->success(__('menu.restore_success'));
            return redirect()->back()
                ->with('successs', __('menu.restore_success'))
                ->with('total_restored', $totalRestored)
                ->with('summary_list', $restoreSummary);
        } catch (\Exception $e) {
            // ถ้ามี Error เกิดขึ้น ให้ยกเลิกการเปลี่ยนแปลงทั้งหมด
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('menu.restore_fail') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    public function clear_index()
    {
        return view('pages.restore.clear');
    }

    public function clearMasterData(Request $request)
    {

        $masterTables = [
            'branch_info',
            'changeuser_info',
            'client_info',
            'coupon_info',
            'coupondetail_info',
            'expensevendor_info',
            'grouppaymenttype_info',
            'groupproduct_info',
            'grouptypeproduct_info',
            'guide_info',
            'member_info',
            'paymenttype_info',
            'product_info',
            'promotion_info',
            'redeemitem_info',
            'staff_info',
            'sub_info',
            'terminal_info',
            'timecrossbranch_info',
            'typeproduct_info',
            'unit_info',
            'user_info',
            'userprofile_info',
            'vendor_info',
            'vendorproduct_info',
            'vendorproduct_temp_info',
            'vendorprogress_info',
            'vendorprogressmonth_info',
            'vendorpromotion_info'
        ];

        $clearSummary = []; // สำหรับเก็บ List สรุปผล
        $totalCleared = 0;   // สำหรับเก็บยอดรวมทั้งหมด

        DB::beginTransaction();

        try {
            foreach ($masterTables as $table) {
                $deletedRows = DB::table($table)
                    ->where('activeflag', 0)
                    ->delete();

                // สำหรับ test
                // $deletedRows = rand(0, 15);

                $clearSummary[] = [
                    'table_name' => $table,
                    'deleted_count' => $deletedRows
                ];

                $totalCleared += $deletedRows;
            }
            DB::commit();

            Log::channel('activity')->info(session('auth_user.user_id') . ' Clear Data', [
                'summary' => $clearSummary,
                'total_cleared' => $totalCleared,
                'action' => 'clear',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('timeout', 3000)
                ->position('bottom-right')
                ->success(__('menu.clear_success'));
            return redirect()->back()
                ->with('successs', __('menu.clear_success'))
                ->with('total_cleared', $totalCleared)
                ->with('summary_list', $clearSummary);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('menu.clear_fail') . ': ' . $e->getMessage()
            ], 500);
        }
    }
}
