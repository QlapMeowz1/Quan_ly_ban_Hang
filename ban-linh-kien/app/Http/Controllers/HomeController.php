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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::where('featured', true)
            ->with(['category', 'images'])
            ->take(8)
            ->get();

        // Lấy danh mục nổi bật
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();

        // Lấy sản phẩm mới nhất
        $newProducts = Product::with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Lấy thương hiệu
        $brands = Brand::take(8)->get();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'newProducts',
            'brands'
        ));
    }
}
