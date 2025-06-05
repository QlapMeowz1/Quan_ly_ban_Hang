<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = \App\Models\OrderDetail::all();
        return view('order_details.index', compact('orderDetails'));
    }
}
