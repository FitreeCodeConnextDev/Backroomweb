<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentFullController extends Controller
{
    public function index()
    {
        return view('pages.payment_full.index');
    }

    public function create()
    {
        return view('pages.payment_full.create');
    }
}
