<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class SessionExpire
{
    

    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!session()->has('auth_user')) {
    //         $userId = session('auth_user.user_id');

    //         // Clear the session_id in the database
    //         DB::table('user_info')
    //             ->where('user_id', $userId)
    //             ->update(['session_id' => null]);

    //         // Clear the session
    //         session()->forget('auth_user');
    //         session()->forget('last_activity');
    //         Session::flush();

    //         flash()
    //             ->option('position', 'top-center')
    //             ->option('timeout', 5000)
    //             ->error(__('menu.is_session_expired'));

    //         return redirect('/');
    //     }
    //     if (session()->has('auth_user')) {
    //         $userId = session('auth_user.user_id'); // ปรับตามโครงสร้างเซสชั่นของคุณ
    //         $currentSessionId = Session::getId();

    //         // ตรวจสอบว่ามีบันทึกเซสชันสำหรับผู้ใช้รายนี้หรือไม่
    //         $userSession = DB::table('user_info')
    //             ->where('user_id', $userId)
    //             ->select('session_id')
    //             ->first();

    //         if ($userSession) {
    //             // ตรวจสอบว่า ID เซสชันที่เก็บไว้แตกต่างจากรหัสปัจจุบันหรือไม่
    //             if ($userSession->session_id && $userSession->session_id !== $currentSessionId) {
    //                 // ทำให้เซสชันปัจจุบันใช้ไม่ได้และเปลี่ยนเส้นทางไปยังการเข้าสู่ระบบ
    //                 session()->forget('auth_user');
    //                 flash()
    //                     ->option('position', 'top-center')
    //                     ->option('timeout', 5000)
    //                     ->error(__('menu.is_session_failed'));
    //                 return redirect('/');
    //             }

    //             // อัพเดต ID เซสชันในฐานข้อมูลโดยใช้ตัวสร้างแบบสอบถาม
    //             if ($userSession->session_id !== $currentSessionId) {
    //                 DB::table('user_info')
    //                     ->where('user_id', $userId)
    //                     ->update(['session_id' => $currentSessionId]);
    //             }
    //         }
    //     }
    //     return $next($request);
    // }

    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if session exists
    //     if (session()->has('auth_user')) {
    //         $userId = session('auth_user.user_id');
    //         $currentSessionId = Session::getId();
    //         $lastActivity = session('last_activity');
    //         $now = time();

    //         // Get session lifetime from environment config (in minutes)
    //         $sessionLifetimeInSeconds = config('session.lifetime', 120) * 60;

    //         // Check if session has expired
    //         if ($lastActivity && ($now - $lastActivity) > $sessionLifetimeInSeconds) {
    //             // Clear the session_id in the database
    //             DB::table('user_info')
    //                 ->where('user_id', $userId)
    //                 ->update(['session_id' => null]);

    //             // Clear the session
    //             session()->forget('auth_user');
    //             session()->forget('last_activity');
    //             Session::flush();

    //             flash()
    //                 ->option('position', 'top-center')
    //                 ->option('timeout', 5000)
    //                 ->error(__('menu.is_session_expired'));

    //             return redirect('/');
    //         }

    //         // Update last_activity time
    //         session(['last_activity' => $now]);

    //         // Get user session from database
    //         $userSession = DB::table('user_info')
    //             ->where('user_id', $userId)
    //             ->select('session_id')
    //             ->first();

    //         if ($userSession) {
    //             // Check if stored session ID is different from current
    //             if ($userSession->session_id && $userSession->session_id !== $currentSessionId) {
    //                 // Invalidate current session and redirect to login
    //                 session()->forget('auth_user');
    //                 session()->forget('last_activity');
    //                 flash()
    //                     ->option('position', 'top-center')
    //                     ->option('timeout', 5000)
    //                     ->error(__('menu.is_session_failed'));
    //                 return redirect('/');
    //             }

    //             // Update session ID in database if different
    //             if ($userSession->session_id !== $currentSessionId) {
    //                 DB::table('user_info')
    //                     ->where('user_id', $userId)
    //                     ->update(['session_id' => $currentSessionId]);
    //             }
    //         }
    //     } else {
    //         // No auth session, redirect to home
    //         return redirect('/');
    //     }

    //     return $next($request);
}
