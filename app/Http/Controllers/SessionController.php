<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class SessionController extends Controller
{
    public function index()
    {
        if (session('auth_user.profile_code' !== 00)) {
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $session_data = DB::table(('sessions'))
            ->join('user_session_active', 'sessions.id', '=', 'user_session_active.session_active')
            ->join('user_info', 'user_session_active.user_id', '=', 'user_info.user_id')
            ->get();
        // dd( $session_data);
        return view('pages.session.index', compact('session_data'));
    }
    public function edit()
    {
        $session_data = DB::table(('sessions'))
            ->join('user_session_active', 'sessions.id', '=', 'user_session_active.session_active')
            ->join('user_info', 'user_session_active.user_id', '=', 'user_info.user_id')
            ->get();
        return view('pages.session.index', compact('session_data'));
    }
    public function destroy($id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        sweetalert()->success(__('Session deleted successfully.'));
        return redirect()->route('session.index');
    }
}
