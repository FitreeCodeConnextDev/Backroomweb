<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!session()->has('auth_user')) {
        //     return redirect('/');
        // }

        if (session()->has('auth_user')) {
            $userId = session('auth_user.user_id');
            $currentSessionId = Session::getId();

            $session_check = DB::table('user_session_active')->where('user_id', $userId)->first();
            if ($session_check == false) {
                DB::table('user_session_active')->insert([
                    'user_id' => $userId,
                    'session_active' => Session::getId(),
                    'login_at' => Carbon::now(),
                ]);
            }
            $userSession = DB::table('user_session_active')
                ->where('user_id', $userId)
                ->select('session_active')
                ->first();

            if ($userSession) {
                if ($userSession->session_active && $userSession->session_active !== $currentSessionId) {
                    DB::table('user_session_active')
                        ->where('user_id', $userId)
                        ->update(['session_active' => null]);
                    session()->forget('auth_user');

                    sweetalert()
                        ->showConfirmButton(false)
                        ->timer(5000)
                        ->error(__('menu.is_session_failed'));
                    // flash()
                    //     ->option('position', 'top-center')
                    //     ->option('timeout', 5000)
                    //     ->error(__('menu.is_session_failed'));

                    return redirect('/');
                }
                if ($userSession->session_active != $currentSessionId) {
                    DB::table('user_session_active')
                        ->where('user_id', $userId)
                        ->update(['session_active' => $currentSessionId, 'login_at' => Carbon::now()]);
                }
            }
            if ($request->is('/')) {
                return redirect()->route('checkPermiss');
            }

            return $next($request);
        } else {

            session()->forget('auth_user');
            session()->forget('last_activity');
            Session::flush();

            flash()
                ->option('position', 'top-center')
                ->option('timeout', 5000)
                ->error(__('menu.is_session_expired'));

            return redirect('/');
        }
    }
}
