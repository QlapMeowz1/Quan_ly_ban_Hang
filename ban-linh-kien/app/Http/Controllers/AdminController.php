<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // Thống kê tổng quan
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', 'completed')->sum('total_amount');
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();

        // Dữ liệu doanh thu 7 ngày gần đây
        $revenueData = Order::where('order_status', 'completed')
            ->where('order_date', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(total_amount) as amount')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Đơn hàng gần đây
        $recentOrders = Order::with('customer')
            ->orderBy('order_date', 'desc')
            ->limit(5)
            ->get();

        // Sản phẩm bán chạy
        $topProducts = DB::table('products')
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.category_id')
            ->leftJoin('product_images', function($join) {
                $join->on('products.product_id', '=', 'product_images.product_id');
                $join->where('product_images.is_primary', '=', 1);
            })
            ->select(
                'products.product_id',
                'products.product_name',
                'products.product_code',
                'products.price',
                'products.stock_quantity',
                'products.min_stock_level',
                'categories.category_name',
                'product_images.image_url',
                DB::raw('COUNT(order_items.order_item_id) as total_sold'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->where('orders.order_status', 'completed')
            ->groupBy(
                'products.product_id',
                'products.product_name',
                'products.product_code',
                'products.price',
                'products.stock_quantity',
                'products.min_stock_level',
                'categories.category_name',
                'product_images.image_url'
            )
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return view('admins.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalCustomers',
            'revenueData',
            'recentOrders',
            'topProducts'
        ));
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Tạo admin thành công!');
    }

    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $admin->update($validated);

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Cập nhật admin thành công!');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.admins.index')
            ->with('success', 'Đã xóa admin!');
    }

    public function users(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%");
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(20);
        return view('admins.users', compact('users'));
    }

    public function userOrders($userId)
    {
        $user = User::findOrFail($userId);
        $orders = $user->customer ? $user->customer->orders()->orderByDesc('order_date')->get() : [];
        return view('admins.user_orders', compact('user', 'orders'));
    }
}
