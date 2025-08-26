<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TerminalController extends Controller
{
    public function index()
    {
        try {

            $sessions = session('auth_user');
            $api = Http::post(
                '10.10.1.7:9501/backroom/v1/terminal',
                [
                    'branch_id' => $sessions['branch_id'],
                    'user_id' => $sessions['user_id']
                ]
            );
    
            $api_response = json_decode($api->body(), true);
            $terminal_info = $api_response['terminal_info'];
            foreach ($terminal_info as $key => $value) {
    
                $terminal_id = $value['term_id'];
                $terminal_name = $value['term_name'];
                $branch_id = $value['branch_id'];
            }
    
            // dd($terminal_id);
    
            if (isset($api_response['Status'])) {
                return view('pages.terminals.index', compact('terminal_info'));
            } else {
                return redirect()->route('teminal')->withErrors(['error' => 'Api Data is Not Ready to use']);
            }
        }catch (\Exception $e) {
            $errorMessage = ' เกิดข้อผิดพลาดทางเซิร์ฟเวอร์ โปรดตรวจสอบการทำงานของเซิร์ฟเวอร์';
            Log::error($errorMessage . ' ' . $e->getMessage());
            return view('pages.terminals.index', ['error' => $errorMessage]);
    }
        
    }
}
