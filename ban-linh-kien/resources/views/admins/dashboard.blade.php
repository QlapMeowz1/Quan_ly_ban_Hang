@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <h1 class="mt-4 mb-4" style="color: #7f1d1d; font-size: 1.75rem; font-weight: 600;">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Tổng Quan
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 12px;">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-white-50 mb-1">Tổng Khách Hàng</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($totalCustomers ?? 0) }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-75">
                        <i class="fas fa-arrow-up me-1"></i>
                        Tăng trưởng ổn định
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 12px;">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-white-50 mb-1">Tổng Sản Phẩm</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($totalProducts ?? 0) }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-75">
                        <i class="fas fa-check me-1"></i>
                        Đang hoạt động
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-radius: 12px;">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-white-50 mb-1">Tổng Đơn Hàng</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($totalOrders ?? 0) }}</div>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-75">
                        <span class="badge bg-warning text-dark rounded-pill">
                            {{ $pendingOrders ?? 0 }} chờ xử lý
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); border-radius: 12px;">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-white-50 mb-1">Tổng Doanh Thu</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($totalRevenue ?? 0) }}₫</div>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-75">
                        <i class="fas fa-chart-line me-1"></i>
                        Từ đơn đã giao
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%); border-radius: 12px 12px 0 0;">
                <h5 class="card-title text-white mb-0">
                    <i class="fas fa-chart-area me-2"></i>Doanh Thu 7 Ngày Qua
                </h5>
            </div>
            <div class="card-body" style="height: 350px;">
                <canvas id="revenueChart" width="100%" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 12px 12px 0 0;">
                <h5 class="card-title text-white mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Thống Kê Đơn Hàng
                </h5>
            </div>
            <div class="card-body" style="height: 350px;">
                <canvas id="orderStatusChart" width="100%" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Top Products -->
<div class="row">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-radius: 12px 12px 0 0;">
                <h5 class="card-title text-white mb-0">
                    <i class="fas fa-clock me-2"></i>Đơn Hàng Gần Đây
                </h5>
            </div>
            <div class="card-body p-0">
                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Mã ĐH</th>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Khách Hàng</th>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Tổng Tiền</th>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Trạng Thái</th>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Ngày Đặt</th>
                                    <th style="font-size: 0.875rem; font-weight: 600;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td style="font-size: 0.875rem;">
                                            <span class="fw-bold text-primary">
                                                #{{ $order->order_number ?? 'DH' . str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td style="font-size: 0.875rem;">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $order->customer->email ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size: 0.875rem;">
                                            <span class="fw-bold text-success">{{ number_format($order->total_amount ?? 0) }}₫</span>
                                        </td>
                                        <td style="font-size: 0.875rem;">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-warning text-dark',
                                                    'processing' => 'bg-info text-white',
                                                    'shipped' => 'bg-primary text-white',
                                                    'completed' => 'bg-success text-white',
                                                    'cancelled' => 'bg-danger text-white',
                                                ];
                                                $statusClass = $statusClasses[$order->order_status ?? 'pending'] ?? 'bg-secondary text-white';
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill">
                                                {{ $order->order_status ?? 'pending' }}
                                            </span>
                                        </td>
                                        <td style="font-size: 0.875rem;">
                                            <div>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : 'N/A' }}</div>
                                            <small class="text-muted">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('H:i') : '' }}</small>
                                        </td>
                                        <td style="font-size: 0.875rem;">
                                            <a href="{{ route('admin.orders.show', $order->order_id) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có đơn hàng nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); border-radius: 12px 12px 0 0;">
                <h5 class="card-title text-white mb-0">
                    <i class="fas fa-fire me-2"></i>Sản Phẩm Bán Chạy
                </h5>
            </div>
            <div class="card-body p-0">
                @if(isset($topProducts) && $topProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topProducts->take(5) as $product)
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}" 
                                                 alt="{{ $product->product_name }}" 
                                                 class="rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1" style="font-size: 0.875rem; font-weight: 600;">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success rounded-pill me-2">
                                                {{ $product->total_sold ?? 0 }} đã bán
                                            </span>
                                            <small class="text-muted">
                                                {{ number_format($product->price ?? 0) }}₫
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có dữ liệu sản phẩm</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%); border-radius: 12px 12px 0 0;">
                <h5 class="card-title text-white mb-0">
                    <i class="fas fa-bolt me-2"></i>Thao Tác Nhanh
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.products.create') }}" 
                           class="btn btn-outline-primary w-100 py-3 border-2" 
                           style="border-radius: 10px; font-size: 0.9rem;">
                            <i class="fas fa-plus-circle fa-lg mb-2 d-block"></i>
                            Thêm Sản Phẩm
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.categories.create') }}" 
                           class="btn btn-outline-success w-100 py-3 border-2" 
                           style="border-radius: 10px; font-size: 0.9rem;">
                            <i class="fas fa-tags fa-lg mb-2 d-block"></i>
                            Thêm Danh Mục
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.orders.list') }}" 
                           class="btn btn-outline-warning w-100 py-3 border-2" 
                           style="border-radius: 10px; font-size: 0.9rem;">
                            <i class="fas fa-list-alt fa-lg mb-2 d-block"></i>
                            Quản Lý Đơn Hàng
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.reports.index') }}" 
                           class="btn btn-outline-info w-100 py-3 border-2" 
                           style="border-radius: 10px; font-size: 0.9rem;">
                            <i class="fas fa-chart-line fa-lg mb-2 d-block"></i>
                            Báo Cáo & Thống Kê
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = @json($revenueData ?? []);
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['7 ngày trước', '6 ngày trước', '5 ngày trước', '4 ngày trước', '3 ngày trước', '2 ngày trước', 'Hôm qua'],
                datasets: [{
                    label: 'Doanh thu (₫)',
                    data: revenueData,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#dc2626',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + '₫';
                            },
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                }
            }
        });
    }

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart');
    if (orderStatusCtx) {
        const pendingOrders = {{ $pendingOrders ?? 0 }};
        const totalOrders = {{ $totalOrders ?? 0 }};
        const completedOrders = totalOrders - pendingOrders;
        
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Đã hoàn thành', 'Đang xử lý', 'Khác'],
                datasets: [{
                    data: [
                        completedOrders * 0.7,
                        pendingOrders,
                        completedOrders * 0.3
                    ],
                    backgroundColor: [
                        '#059669',
                        '#ea580c',
                        '#6b7280'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }
});
</script>
@endpush
