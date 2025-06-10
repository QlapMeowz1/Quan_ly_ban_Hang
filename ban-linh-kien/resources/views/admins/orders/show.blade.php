@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng #{{ $order->order_number }}</h2>
    <div class="mb-3">
        <strong>Khách hàng:</strong> {{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}<br>
        <strong>Email:</strong> {{ $order->customer->email ?? '' }}<br>
        <strong>Trạng thái:</strong> {{ $order->status_label }}<br>
        <strong>Ngày đặt:</strong> {{ $order->order_date }}
    </div>
    <h5>Danh sách sản phẩm</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mã</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->product_code }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                <td>{{ number_format($item->total_price, 0, ',', '.') }}đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        <strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ
    </div>
    <a href="{{ route('admin.orders.list') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection 