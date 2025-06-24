@extends('layouts.admin')
@section('title', 'Chỉnh sửa mã giảm giá')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa mã giảm giá</h2>
    <form action="{{ route('admin.coupons.update', $coupon->coupon_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Mã giảm giá <span class="text-danger">*</span></label>
            <input type="text" name="coupon_code" class="form-control" required value="{{ old('coupon_code', $coupon->coupon_code) }}">
        </div>
        <div class="mb-3">
            <label>Tên mã</label>
            <input type="text" name="coupon_name" class="form-control" value="{{ old('coupon_name', $coupon->coupon_name) }}">
        </div>
        <div class="mb-3">
            <label>Loại giảm giá <span class="text-danger">*</span></label>
            <select name="discount_type" class="form-select" required>
                <option value="percentage" {{ old('discount_type', $coupon->discount_type)=='percentage'?'selected':'' }}>Phần trăm (%)</option>
                <option value="fixed_amount" {{ old('discount_type', $coupon->discount_type)=='fixed_amount'?'selected':'' }}>Cố định (VNĐ)</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Giá trị giảm <span class="text-danger">*</span></label>
            <input type="number" name="discount_value" class="form-control" required min="0" step="0.01" value="{{ old('discount_value', $coupon->discount_value) }}">
        </div>
        <div class="mb-3">
            <label>Đơn tối thiểu</label>
            <input type="number" name="minimum_order_amount" class="form-control" min="0" step="0.01" value="{{ old('minimum_order_amount', $coupon->minimum_order_amount) }}">
        </div>
        <div class="mb-3">
            <label>Giảm tối đa</label>
            <input type="number" name="maximum_discount_amount" class="form-control" min="0" step="0.01" value="{{ old('maximum_discount_amount', $coupon->maximum_discount_amount) }}">
        </div>
        <div class="mb-3">
            <label>Giới hạn lượt dùng</label>
            <input type="number" name="usage_limit" class="form-control" min="1" value="{{ old('usage_limit', $coupon->usage_limit) }}">
        </div>
        <div class="mb-3">
            <label>Ngày bắt đầu <span class="text-danger">*</span></label>
            <input type="date" name="valid_from" class="form-control" required value="{{ old('valid_from', $coupon->valid_from ? date('Y-m-d', strtotime($coupon->valid_from)) : '') }}">
        </div>
        <div class="mb-3">
            <label>Ngày kết thúc <span class="text-danger">*</span></label>
            <input type="date" name="valid_until" class="form-control" required value="{{ old('valid_until', $coupon->valid_until ? date('Y-m-d', strtotime($coupon->valid_until)) : '') }}">
        </div>
        <div class="mb-3">
            <label>Trạng thái <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
                <option value="active" {{ old('status', $coupon->status)=='active'?'selected':'' }}>Kích hoạt</option>
                <option value="inactive" {{ old('status', $coupon->status)=='inactive'?'selected':'' }}>Ngừng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 
