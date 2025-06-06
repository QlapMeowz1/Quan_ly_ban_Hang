<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $customers = Customer::with(['user', 'orders'])
            ->withCount('orders')
            ->orderBy('customer_id', 'desc')
            ->paginate(20);
            
        return view('admins.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['user', 'orders.orderItems.product']);
        return view('admins.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admins.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Cập nhật thông tin khách hàng thành công.');
    }
} 