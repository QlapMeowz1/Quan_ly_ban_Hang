<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    // Bắt buộc đăng nhập cho toàn bộ controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $orders = [];
        if ($user && $user->customer) {
            $orders = Order::where('customer_id', $user->customer->customer_id)
                ->orderByDesc('order_date')
                ->with('orderItems.product')
                ->get();
        }
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Kiểm tra user và quan hệ customer
        $user = auth()->user();
        $customer = $user->customer;
        if (!$customer) {
            $customer = Customer::where('email', $user->email)->first();
            if (!$customer) {
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'password_hash' => $user->password,
                    'status' => 'active',
                ]);
            }
        }
        $customerId = $customer->customer_id;

        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $order = Order::create([
            'customer_id' => $customerId,
            'shipping_address' => $request->address,
            'order_number' => uniqid('ORD'),
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cod',
            'subtotal' => 0,
            'shipping_fee' => 0,
            'discount_amount' => 0,
            'total_amount' => 0,
            'order_date' => Carbon::now(),
        ]);

        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $quantity;
                $order->orderItems()->create([
                    'product_id' => $productId,
                    'product_name' => $product->product_name,
                    'product_code' => $product->product_code,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $subtotal,
                ]);
                $total += $subtotal;
            }
        }

        $order->subtotal = $total;
        $order->total_amount = $total;
        $order->save();

        session()->forget('cart');

        return redirect()->route('orders.index')
            ->with('success', 'Đặt hàng thành công! Bạn có thể kiểm tra trạng thái đơn hàng và lịch sử mua hàng tại đây.');
    }

    public function show(Order $order)
    {
        // Kiểm tra quyền xem đơn hàng
        $user = auth()->user();
        if (!$user->customer || $order->customer_id !== $user->customer->customer_id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này!');
        }

        $order->load('orderItems.product', 'customer');
        return view('orders.show', compact('order'));
    }
}
