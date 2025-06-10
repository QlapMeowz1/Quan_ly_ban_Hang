<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $coupons = Coupon::orderByDesc('created_at')->paginate(20);
        return view('admins.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admins.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'coupon_name' => 'nullable|max:100',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'status' => 'required|in:active,inactive',
        ]);
        $validated['used_count'] = 0;
        Coupon::create($validated);
        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admins.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $coupon->coupon_id . ',coupon_id',
            'coupon_name' => 'nullable|max:100',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'status' => 'required|in:active,inactive',
        ]);
        $coupon->update($validated);
        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Đã xóa mã giảm giá!');
    }
} 