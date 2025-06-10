@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Thống kê tổng quan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalOrders) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Doanh thu (Đơn hoàn thành)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalRevenue) }}đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalProducts) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCustomers) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Biểu đồ doanh thu -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu (Đơn hoàn thành)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn hàng gần đây -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->order_id) }}">#{{ $order->order_number }}</a>
                                    </td>
                                    <td>{{ optional($order->customer)->email ?? 'N/A' }}</td>
                                    <td>
                                        @if($order->order_status == 'pending')
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="badge bg-info">Đang xử lý</span>
                                        @elseif($order->order_status == 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($order->total_amount) }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sản phẩm bán chạy</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Đã bán</th>
                            <th>Doanh thu</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->images->first())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                             alt="{{ $product->product_name }}" 
                                             class="rounded me-2" 
                                             width="40">
                                    @else
                                        <img src="{{ asset('images/no-image.jpg') }}" 
                                             alt="No image" 
                                             class="rounded me-2" 
                                             width="40">
                                    @endif
                                    <a href="{{ route('admin.products.edit', $product->product_id) }}">
                                        {{ $product->product_name }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ optional($product->category)->category_name ?? 'N/A' }}</td>
                            <td>{{ number_format($product->price) }}đ</td>
                            <td>{{ number_format($product->total_sold ?? 0) }}</td>
                            <td>{{ number_format($product->total_revenue ?? 0) }}đ</td>
                            <td>
                                @if($product->stock_quantity > $product->min_stock_level)
                                    <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="revenue-data" style="display: none;">
    @json($revenueData)
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueData = JSON.parse(document.getElementById('revenue-data').textContent);
    
    var labels = revenueData.map(function(item) {
        return item.date;
    });
    
    var data = revenueData.map(function(item) {
        return item.amount;
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu',
                data: data,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection