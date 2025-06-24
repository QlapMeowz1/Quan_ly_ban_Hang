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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Số đơn hàng</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyRevenue as $row)
                        <tr>
                            <td>{{ $row->month }}/{{ $row->year }}</td>
                            <td>{{ $row->order_count }}</td>
                            <td>{{ number_format($row->revenue, 0, ',', '.') }} đ</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
                        @endforelse
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->total_sold }}</td>
                            <td>{{ number_format($product->total_revenue, 0, ',', '.') }} đ</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
                        @endforelse
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Tồn kho</th>
                            <th>Mức tối thiểu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStock as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->min_stock_level }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 
