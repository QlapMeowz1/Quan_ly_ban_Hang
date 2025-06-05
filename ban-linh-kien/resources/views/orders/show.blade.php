@extends('layouts.web')
@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng: {{ $order->order_number }}</h2>
    <p><b>Ngày đặt:</b> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
    @php
        $statusColor = [
            'pending' => 'secondary',
            'confirmed' => 'info',
            'processing' => 'info',
            'shipping' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'dark',
        ];
        $statusIcon = [
            'pending' => 'bi-clock',
            'confirmed' => 'bi-clipboard-check',
            'processing' => 'bi-clipboard-check',
            'shipping' => 'bi-truck',
            'delivered' => 'bi-check-circle',
            'cancelled' => 'bi-x-circle',
            'returned' => 'bi-arrow-counterclockwise',
        ];
    @endphp
    <p><b>Trạng thái:</b> <span class="badge bg-{{ $statusColor[$order->order_status] ?? 'secondary' }}"><i class="bi {{ $statusIcon[$order->order_status] ?? 'bi-info-circle' }}"></i> {{ $order->status_label }}</span></p>
    <p><b>Địa chỉ giao hàng:</b> {{ $order->shipping_address }}</p>
    <h4>Sản phẩm trong đơn hàng:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mã SP</th>
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
                <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                <td>{{ number_format($item->total_price, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4 class="text-end">Tổng cộng: {{ number_format($order->total_amount, 0, ',', '.') }} đ</h4>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>
@endsection 