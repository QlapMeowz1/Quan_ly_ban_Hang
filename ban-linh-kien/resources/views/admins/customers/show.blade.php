@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Chi tiết Khách hàng</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer->customer_id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">Thông tin cơ bản</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">ID</th>
                            <td>{{ $customer->customer_id }}</td>
                        </tr>
                        <tr>
                            <th>Tên</th>
                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($customer->status === 'active')
                                    <span class="badge bg-success">Hoạt động</span>
                                @elseif($customer->status === 'inactive')
                                    <span class="badge bg-warning">Không hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Đã khóa</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tài khoản liên kết</th>
                            <td>
                                @if($customer->user)
                                    {{ $customer->user->name }} ({{ $customer->user->email }})
                                    <br>
                                    <small class="text-muted">Tạo ngày: {{ $customer->user->created_at->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h6 class="mb-3">Thông tin bổ sung</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Giới tính</th>
                            <td>
                                @if($customer->gender === 'male')
                                    Nam
                                @elseif($customer->gender === 'female')
                                    Nữ
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày sinh</th>
                            <td>{{ $customer->date_of_birth ? date('d/m/Y', strtotime($customer->date_of_birth)) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email xác thực</th>
                            <td>
                                @if($customer->email_verified)
                                    <span class="badge bg-success">Đã xác thực</span>
                                @else
                                    <span class="badge bg-warning">Chưa xác thực</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h6 class="mb-3">Lịch sử đơn hàng</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>{{ number_format($order->total_amount) }}đ</td>
                                <td>
                                    @if($order->order_status === 'pending')
                                        <span class="badge bg-warning">Chờ xử lý</span>
                                    @elseif($order->order_status === 'processing')
                                        <span class="badge bg-info">Đang xử lý</span>
                                    @elseif($order->order_status === 'completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($order->order_status === 'cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status === 'pending')
                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                    @elseif($order->payment_status === 'paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @elseif($order->payment_status === 'refunded')
                                        <span class="badge bg-info">Đã hoàn tiền</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->payment_status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->order_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 