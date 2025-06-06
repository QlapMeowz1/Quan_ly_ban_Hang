@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Chi tiết thương hiệu</h1>
        <div>
            <a href="{{ route('admin.brands.edit', $brand->brand_id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    @if($brand->brand_logo)
                        <img src="{{ asset('storage/' . $brand->brand_logo) }}" 
                             alt="{{ $brand->brand_name }}" 
                             class="img-fluid mb-3"
                             style="max-height: 200px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 200px">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <h4>{{ $brand->brand_name }}</h4>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin chi tiết</h5>
                    
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Mô tả</h6>
                        <p>{{ $brand->brand_description ?: 'Chưa có mô tả' }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Ngày tạo</h6>
                        <p>{{ $brand->created_at ? $brand->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Cập nhật lần cuối</h6>
                        <p>{{ $brand->updated_at ? $brand->updated_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                    </div>

                    <div>
                        <h6 class="text-muted mb-2">Số sản phẩm</h6>
                        <p>{{ $brand->products_count ?? 0 }} sản phẩm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($products) && $products->count() > 0)
    <div class="card shadow mt-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Sản phẩm của thương hiệu</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_code }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->product_id) }}">
                                    {{ $product->product_name }}
                                </a>
                            </td>
                            <td>{{ optional($product->category)->category_name }}</td>
                            <td>{{ number_format($product->price) }}đ</td>
                            <td>
                                @if($product->stock_quantity > $product->min_stock_level)
                                    <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($product->status == 'active')
                                    <span class="badge bg-success">Đang bán</span>
                                @else
                                    <span class="badge bg-secondary">Ngừng bán</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 