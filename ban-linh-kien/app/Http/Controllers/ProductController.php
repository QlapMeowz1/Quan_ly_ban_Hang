<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm từ database
        $products = \App\Models\Product::all();
        return view('products.index', compact('products'));
    }

    //
}
