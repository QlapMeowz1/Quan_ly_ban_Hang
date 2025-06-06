@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Báo cáo thống kê</h1>

    <!-- Báo cáo doanh thu theo tháng -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo tháng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Số đơn hàng</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyRevenue as $revenue)
                        <tr>
                            <td>{{ $revenue->month }}/{{ $revenue->year }}</td>
                            <td>{{ number_format($revenue->order_count) }}</td>
                            <td>{{ number_format($revenue->revenue) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top sản phẩm bán chạy</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ number_format($product->total_sold) }}</td>
                            <td>{{ number_format($product->total_revenue) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cảnh báo tồn kho -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sản phẩm sắp hết hàng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Tồn kho</th>
                            <th>Mức tối thiểu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStock as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stock_quantity == 0 ? 'danger' : 'warning' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td>{{ $product->min_stock_level }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 