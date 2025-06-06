<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Báo cáo doanh thu theo tháng
        $monthlyRevenue = Order::where('order_status', 'completed')
            ->select(
                DB::raw('YEAR(order_date) as year'),
                DB::raw('MONTH(order_date) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        // Báo cáo sản phẩm bán chạy
        $topProducts = DB::table('products')
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.order_status', 'completed')
            ->select(
                'products.product_id',
                'products.product_name',
                DB::raw('COUNT(order_items.order_item_id) as total_sold'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Báo cáo tồn kho
        $lowStock = Product::where('stock_quantity', '<=', DB::raw('min_stock_level'))
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();

        return view('admins.reports.index', compact('monthlyRevenue', 'topProducts', 'lowStock'));
    }
} 