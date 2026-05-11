<?php

namespace App\Http\Controllers;

use App\Models\BranchModel;
use App\Models\TerminalModel;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TerminalController extends Controller
{
    public function index()
    {
        $terminal_info = TerminalModel::orderBy('term_id', 'asc')->get();
        return view('pages.terminal.index', compact('terminal_info'));
    }

    public function create()
    {
        $branch_info = DB::table('branch_info')->orderBy('branch_id', 'asc')->get();
        // dd($branch_info);
        return view('pages.terminal.create', compact('branch_info'));
    }

    public function store(Request $request)
    {
        $terminal = new TerminalModel();
        $terminal->term_id = $request->term_id;
        $terminal->term_name = $request->term_name;
        $terminal->save();
        return redirect()->route('terminal.index');
    }

    public function edit($id)
    {
        $branch_info = DB::table('branch_info')->orderBy('branch_id', 'asc')->get();
        $terminal_info = TerminalModel::find($id);

        $term_funtion = str_split($terminal_info->terminal_function);
        // dd($term_funtion);
        return view('pages.terminal.edit', compact('terminal_info', 'branch_info', 'term_funtion'));
    }
}
