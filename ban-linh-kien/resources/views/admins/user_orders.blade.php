@extends('layouts.admin')
@section('content')
<div class="container">
    <h2>Đơn hàng của user: {{ $user->name }} ({{ $user->email }})</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->order_status }}</td>
                <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                <td>
                    <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Quay lại danh sách user</a>
</div>
@endsection 