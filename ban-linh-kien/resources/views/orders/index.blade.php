@extends('layouts.web')
@section('content')
<div class="container">
    <h2>Đơn hàng của bạn</h2>
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
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
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
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                <td><span class="badge bg-{{ $statusColor[$order->order_status] ?? 'secondary' }}"><i class="bi {{ $statusIcon[$order->order_status] ?? 'bi-info-circle' }}"></i> {{ $order->status_label }}</span></td>
                <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                <td><a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Xem</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 