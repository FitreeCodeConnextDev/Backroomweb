<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{


    public function index()
    {
        // $dd = Cache::get('code');
        // $session_check = DB::table('user_session_active')->select()->get();
        // dd($session_check);
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'user_pass' => 'required',
        ], [
            'user_id' => 'Please provide a username.',
            'user_pass' => 'Please provide a password.',
        ]);

        $user_id = $request->input('user_id');
        $user_pass = $request->input('user_pass');
        // $cacheKey = $user_id;

        // // Check Cache first
        // if (Cache::has($cacheKey)) {
        //     $userData = Cache::get($cacheKey);
        //     $this->storeUserSession($userData);
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Login successful.',
        //     ]);
        // }

        $data_user = DB::table('user_info')
            ->where('user_id', $user_id)
            ->first();


        if ($data_user && $data_user->user_id == $user_id && $data_user->user_pass == $user_pass) {
            if ($data_user->user_lock == 1) {
                return response()->json([
                    'success' => false,
                    'message' => __('menu.is_locked'),
                ], 401);
            }

            // Prepare user session data
            $userSessionData = [
                'user_id' => $data_user->user_id,
                'user_name' => $data_user->user_name,
                'branch_id' => $data_user->branch_id,
                'user_lock' => $data_user->user_lock,
                'profile_code' => $data_user->profile_code,
                'activeflag' => $data_user->activeflag,
            ];

            // Store in session
            $this->storeUserSession($userSessionData);
            Log::channel('activity')->notice('User ' . $data_user->user_id . '  has logged in. ' . json_encode([
                'user_id' => $data_user->user_id,
                'action' => 'login',
                'timestamp' => Carbon::now()->toDateTimeString(), // แปลงเป็น string
            ]));
            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ], 401);
        }
    }

    private function storeUserSession(array $userSessionData)
    {
        // Store user data in Session
        Session::put('auth_user', $userSessionData);
        // Cache::put($userSessionData['user_id'], $userSessionData);
    }

    public function checkPermiss()
    {
        $user_id = session('auth_user.user_id');
        $user_info = DB::table('user_info')
            ->select('back_permiss')
            ->where('user_id', $user_id)
            ->where('activeflag', 1)
            ->first();
        $user_back = str_split($user_info->back_permiss);
        if ($user_back[0] == 1) {
            return redirect()->route('vendor-page.index');
        } else if ($user_back[1] == 1) {
            return redirect()->route('member.index');
        } else if ($user_back[2] == 1) {
            return redirect()->route('products-groups.index');
        } else if ($user_back[3] == 1) {
            return redirect()->route('vendor-promotion.index');
        } else if ($user_back[4] == 1) {
            return redirect()->route('card-promotion.index');
        } else if ($user_back[5] == 1) {
            return redirect()->route('users.index');
        } else if ($user_back[6] == 1) {
            return redirect()->route('branch.index');
        } else if ($user_back[7] == 1) {
            return redirect()->route('card-type.index');
        } else if ($user_back[9] == 1) {
            return redirect()->route('products.index');
        } else if ($user_back[11] == 1) {
            return redirect()->route('staff.index');
        } else if ($user_back[12] == 1) {
            return redirect()->route('product-units.index');
        } else if ($user_back[13] == 1) {
            return redirect()->route('product-sap.index');
        } else if ($user_back[14] == 1) {
            return redirect()->route('coupons.index');
        } else if ($user_back[15] == 1) {
            return redirect()->route('payment-group.index');
        } else if ($user_back[16] == 1) {
            return redirect()->route('payment_type.index');
        } else {
            return redirect()->route('chart_daily');
        }
    }
    public function logout()
    {

        $userId = session('auth_user.user_id');
        Log::channel('activity')->notice('User ' . $userId . '  has logged out. ' . json_encode([
            'user_id' => $userId,
            'action' => 'logout',
            'timestamp' => Carbon::now()->toDateTimeString(), // แปลงเป็น string
        ]));
        // Clear the session_id in the database
        DB::table('user_session_active')
            ->where('user_id', $userId)
            ->update(['session_active' => null]);

        // Clear the session
        session()->forget('auth_user');
        session()->forget('last_activity');
        Session::flush();


        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success(__('menu.is_logged_out'));

        return redirect('/');
    }
}
