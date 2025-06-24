@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Chi tiết Sản phẩm</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Thông tin cơ bản</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Tên sản phẩm:</th>
                                    <td>{{ $product->product_name }}</td>
                                </tr>
                                <tr>
                                    <th>Mã sản phẩm:</th>
                                    <td>{{ $product->product_code }}</td>
                                </tr>
                                <tr>
                                    <th>Danh mục:</th>
                                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu:</th>
                                    <td>{{ $product->brand->brand_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mô tả:</th>
                                    <td>{{ $product->description ?: 'Không có mô tả' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Thông số kỹ thuật</h6>
                            @if($product->specifications)
                                @php
                                    $specs = json_decode($product->specifications, true);
                                @endphp
                                @if($specs && is_array($specs))
                                    <table class="table table-striped">
                                        @foreach($specs as $key => $value)
                                        <tr>
                                            <th width="200">{{ ucfirst($key) }}:</th>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <p class="text-muted">Không có thông số kỹ thuật</p>
                                @endif
                            @else
                                <p class="text-muted">Không có thông số kỹ thuật</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Giá & Kho hàng</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Giá bán:</th>
                                    <td class="text-danger h5">{{ number_format($product->price) }}đ</td>
                                </tr>
                                <tr>
                                    <th>Giá gốc:</th>
                                    <td>{{ number_format($product->cost_price) }}đ</td>
                                </tr>
                                <tr>
                                    <th>Số lượng tồn:</th>
                                    <td>{{ $product->stock_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Tồn kho tối thiểu:</th>
                                    <td>{{ $product->min_stock_level }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Trạng thái</h6>
                            <p>
                                <strong>Trạng thái:</strong>
                                @if($product->status == 'active')
                                    <span class="badge bg-success">Đang bán</span>
                                @else
                                    <span class="badge bg-secondary">Ngừng bán</span>
                                @endif
                            </p>
                            <p>
                                <strong>Sản phẩm nổi bật:</strong>
                                @if($product->featured)
                                    <span class="badge bg-primary">Có</span>
                                @else
                                    <span class="badge bg-secondary">Không</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Ảnh sản phẩm</h6>
                            @if($product->images->count() > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_url) }}" 
                                             alt="Ảnh sản phẩm" 
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Chưa có ảnh</p>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Thông tin khác</h6>
                            <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Cập nhật lần cuối:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
