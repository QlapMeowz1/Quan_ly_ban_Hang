@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Chỉnh sửa khách hàng</h3>
    <form method="POST" action="{{ route('admin.customers.update', $customer->customer_id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $customer->first_name) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
        </div>
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                <option value="blocked" {{ $customer->status == 'blocked' ? 'selected' : '' }}>Bị khóa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 
