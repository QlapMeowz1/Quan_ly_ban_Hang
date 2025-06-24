<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Bỏ middleware auth để cho phép truy cập mà không cần đăng nhập
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $featuredProducts = Product::where('featured', true)
            ->with(['category', 'images'])
            ->take(8)
            ->get();

        
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();

        
        $newProducts = Product::with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

  
        $brands = Brand::take(8)->get();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'newProducts',
            'brands'
        ));
    }
}
