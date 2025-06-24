@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Cập nhật trạng thái đơn hàng #{{ $order->order_number }}</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Khách hàng:</strong> {{ $order->customer->email ?? 'N/A' }}<br>
                <strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ<br>
                <strong>Trạng thái hiện tại:</strong> 
                <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : 'secondary' }}">
                    {{ $order->getStatusLabelAttribute() }}
                </span>
            </div>
            
            <form action="{{ route('admin.orders.update_status', $order->order_id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label>Trạng thái mới:</label>
                    <select name="order_status" class="form-control">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="shipping" {{ $order->order_status == 'shipping' ? 'selected' : '' }}>Đang vận chuyển</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Đã giao hàng (sẽ chuyển thành Hoàn thành)</option>
                        <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }} disabled>Hoàn thành (tự động khi giao hàng)</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Đã trả hàng</option>
                    </select>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <strong>Lưu ý:</strong>
                    <ul class="mb-0">
                        <li>Khi chọn "Đã giao hàng", đơn hàng sẽ tự động chuyển sang "Hoàn thành" và được tính vào doanh thu</li>
                        <li>Số lượng tồn kho sẽ tự động được cập nhật khi giao hàng hoặc hủy/trả hàng</li>
                    </ul>
                </div>
                
                <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                <a href="{{ route('admin.orders.list') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection 
