<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function editStatus($order_id)
    {
        $order = \App\Models\Order::with('customer')->findOrFail($order_id);
        return view('admins.orders.edit_status', compact('order'));
    }

    public function updateStatus(Request $request, $order_id)
    {
        $order = \App\Models\Order::with('orderItems.product')->findOrFail($order_id);
        $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled,returned,completed'
        ]);
        
        $oldStatus = $order->order_status;
        $newStatus = $request->order_status;
        
        if ($newStatus == 'delivered') {
            $order->order_status = 'completed';
            $order->payment_status = 'paid';
            $order->delivery_date = now();
            
            if (!in_array($oldStatus, ['completed', 'delivered'])) {
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->stock_quantity -= $item->quantity;
                        $product->save();
                    }
                }
            }
        } 
        elseif (in_array($oldStatus, ['completed', 'delivered']) && in_array($newStatus, ['cancelled', 'returned'])) {
            $order->order_status = $newStatus;
            $order->payment_status = ($newStatus == 'returned') ? 'refunded' : 'cancelled';
            
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();
                }
            }
        }
        else {
            $order->order_status = $newStatus;
        }
        
        $order->save();

        $message = ($newStatus == 'delivered') 
            ? 'Đơn hàng đã được giao thành công và chuyển sang trạng thái hoàn thành!' 
            : 'Cập nhật trạng thái đơn hàng thành công!';

        return redirect()->route('admin.orders.list')->with('success', $message);
    }

    public function show($order_id)
    {
        $order = \App\Models\Order::with(['orderItems.product', 'customer'])->findOrFail($order_id);
        return view('admins.orders.show', compact('order'));
    }

    public function list()
    {
        $orders = \App\Models\Order::with('customer')->orderByDesc('order_date')->paginate(20);
        return view('admins.orders.list', compact('orders'));
    }
} 