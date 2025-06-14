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
    <h4>Thông tin thanh toán:</h4>
    <p><b>Tạm tính:</b> {{ number_format($order->subtotal, 0, ',', '.') }} đ</p>
    @if($order->discount_amount > 0)
        <p><b>Giảm giá:</b> -{{ number_format($order->discount_amount, 0, ',', '.') }} đ
        @if($order->coupon_id)
            (Mã: {{ optional(App\Models\Coupon::find($order->coupon_id))->coupon_code }})
        @endif
        </p>
    @endif
    <p><b>Tổng cộng:</b> {{ number_format($order->total_amount, 0, ',', '.') }} đ</p>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Thông tin đơn hàng</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->order_date->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong> <span class="badge bg-{{ $order->order_status === 'pending' ? 'warning' : ($order->order_status === 'completed' ? 'success' : 'secondary') }}">{{ $order->status_label }}</span></p>
                <p><strong>Thanh toán:</strong> <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status_label }}</span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' }}</p>
            </div>
        </div>

        @if($order->order_status === 'pending')
        <div class="mt-3">
            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> Hủy đơn hàng
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection 