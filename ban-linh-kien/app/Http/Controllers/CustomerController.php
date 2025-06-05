<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::with('user')->get();
        return view('customers.index', compact('customers'));
    }
}
