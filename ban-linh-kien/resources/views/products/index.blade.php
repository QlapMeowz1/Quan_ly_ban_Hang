@extends('layouts.web')

@section('title', 'Sản phẩm')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    <!-- Bộ lọc -->
    <form method="GET" class="mb-4 row g-2">
        <div class="col-auto">
            <select name="category_id" class="form-select">
                <option value="">Danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ request('category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="brand_id" class="form-select">
                <option value="">Hãng</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="chipset" class="form-select">
                <option value="">Chipset</option>
                @foreach($chipsets as $chipset)
                    <option value="{{ $chipset }}" {{ request('chipset') == $chipset ? 'selected' : '' }}>{{ $chipset }}</option>
                @endforeach
            </select>
        </div>
        <!-- Thêm các filter khác tương tự -->
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="">Sắp xếp</option>
                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Giá tăng dần</option>
                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Giá giảm dần</option>
                <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Mới nhất</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Lọc</button>
        </div>
    </form>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 shadow-sm border-primary hover-zoom">
                @if(isset($product->image_url))
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cpu"></i> <a href="{{ route('products.show', $product->product_id) }}" class="text-decoration-none text-dark">{{ $product->product_name }}</a></h5>
                    <p class="card-text text-danger fw-bold"><i class="bi bi-cash-coin"></i> {{ number_format($product->price, 0, ',', '.') }} đ</p>
                    <span class="badge bg-success mb-2"><i class="bi bi-box"></i> Tồn kho: {{ $product->stock_quantity }}</span>
                    <p class="card-text"><small class="text-muted"><i class="bi bi-grid"></i> {{ $product->category->category_name ?? '' }}</small></p>
                    <div class="d-flex gap-2">
                        <form action="/cart" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                        </form>
                        <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-warning btn-sm"><i class="bi bi-lightning-charge"></i> Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection 