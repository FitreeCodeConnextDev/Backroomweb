<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorTypeController extends Controller
{
    public function index(){
        return view('pages.vendor_type.index');
    }

    public function create(){
        return view('pages.vendor_type.create');
    }
}
