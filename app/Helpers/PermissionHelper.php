<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PermissionHelper
{
    /**
     * ฟังก์ชันเช็คสิทธิ์การเข้าถึงหน้า หรือการกระทำ
     *
     * @param string $permissionType 'back' สำหรับการเข้าถึงหน้า หรือ 'function' สำหรับสิทธิ์การกระทำ (Create, Edit, Delete)
     * @param int|null $actionIndex หากเป็น 'function' จะต้องระบุตำแหน่งการกระทำ เช่น 0 = Create, 1 = Edit, 2 = Delete
     * @param int|null $pageIndex หากเป็น 'back' จะต้องระบุตำแหน่งของหน้าใน back_permiss เช่น 0 = Product, 1 = Page อื่น ๆ เป็นต้น
     * @return bool
     */
    public static function checkUserPermission($permissionType, $actionIndex = null, $pageIndex = null)
    {
        // ดึงข้อมูลของผู้ใช้ที่ล็อกอิน
        $userId = session('auth_user.user_id');

        // ค้นหาข้อมูล permission จากฐานข้อมูล
        $userInfo = DB::table('user_info')
            ->where('user_id', $userId)
            ->select('back_permiss', 'function_permiss')
            ->first();

        if (!$userInfo) {
            return false; // ถ้าไม่พบข้อมูลผู้ใช้
        }

        // ถ้าต้องการตรวจสอบการเข้าถึงหน้าหลัก (back_permiss)
        if ($permissionType === 'back' && !is_null($pageIndex)) {
            // ตรวจสอบว่า back_permiss ตำแหน่งที่ $pageIndex เป็น '1' หรือไม่
            return isset($userInfo->back_permiss[$pageIndex]) && $userInfo->back_permiss[$pageIndex] == '1';
        }

        // ถ้าต้องการตรวจสอบสิทธิ์การกระทำในฟังก์ชัน (function_permiss)
        if ($permissionType === 'function' && !is_null($actionIndex)) {
            // ตรวจสอบว่า function_permiss ตำแหน่งที่ $actionIndex เป็น '1' หรือไม่
            return isset($userInfo->function_permiss[$actionIndex]) && $userInfo->function_permiss[$actionIndex] == '1';
        }

        return false; // กรณีที่ไม่ได้ระบุ permissionType หรือพารามิเตอร์ไม่ครบ
    }
}
