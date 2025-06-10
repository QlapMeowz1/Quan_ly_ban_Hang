@extends('layouts.admin')
@section('title', 'Quản lý mã giảm giá')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh sách mã giảm giá</h2>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-success mb-3">Thêm mã giảm giá</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Tên</th>
                <th>Loại</th>
                <th>Giá trị</th>
                <th>Đơn tối thiểu</th>
                <th>Giảm tối đa</th>
                <th>Lượt dùng</th>
                <th>Hạn dùng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->coupon_code }}</td>
                <td>{{ $coupon->coupon_name }}</td>
                <td>{{ $coupon->discount_type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</td>
                <td>{{ $coupon->discount_value }}</td>
                <td>{{ $coupon->minimum_order_amount }}</td>
                <td>{{ $coupon->maximum_discount_amount }}</td>
                <td>{{ $coupon->used_count }}/{{ $coupon->usage_limit ?? '∞' }}</td>
                <td>{{ $coupon->valid_from }}<br>-<br>{{ $coupon->valid_until }}</td>
                <td><span class="badge bg-{{ $coupon->status == 'active' ? 'success' : 'secondary' }}">{{ $coupon->status }}</span></td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon->coupon_id) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <form action="{{ route('admin.coupons.destroy', $coupon->coupon_id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $coupons->links() }}</div>
</div>
@endsection 