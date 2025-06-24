@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Quản lý đơn hàng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái đơn hàng</th>
                <th>Thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_number }}</td>
                <td>{{ $order->customer->email ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                <td>
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipping' => 'primary',
                            'delivered' => 'success',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            'returned' => 'secondary'
                        ];
                        $color = $statusColors[$order->order_status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }}">{{ $order->getStatusLabelAttribute() }}</span>
                </td>
                <td>
                    @php
                        $paymentColors = [
                            'pending' => 'warning',
                            'paid' => 'success',
                            'refunded' => 'info',
                            'failed' => 'danger',
                            'cancelled' => 'secondary'
                        ];
                        $pColor = $paymentColors[$order->payment_status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $pColor }}">{{ $order->getPaymentStatusLabelAttribute() }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                    <a href="{{ route('admin.orders.edit_status', $order->order_id) }}" class="btn btn-warning btn-sm">Cập nhật trạng thái</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection 
