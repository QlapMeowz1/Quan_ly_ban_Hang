@extends('layouts.web')

@section('title', 'Sản phẩm - Shop Linh Kiện')

@section('content')
<div class="container">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Bộ lọc tìm kiếm</h5>
                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Danh mục -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Danh mục</label>
                            <select name="category_id" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Thương hiệu -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Thương hiệu</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Tất cả thương hiệu</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" name="price_min" class="form-control" placeholder="Từ" value="{{ request('price_min') }}">
                                </div>
                                <div class="col">
                                    <input type="number" name="price_max" class="form-control" placeholder="Đến" value="{{ request('price_max') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Thông số kỹ thuật -->
                        @if($chipsets->isNotEmpty())
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Chipset</label>
                            <select name="chipset" class="form-select">
                                <option value="">Tất cả Chipset</option>
                                @foreach($chipsets as $chipset)
                                    <option value="{{ $chipset }}" {{ request('chipset') == $chipset ? 'selected' : '' }}>
                                        {{ $chipset }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if($ram_types->isNotEmpty())
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Loại RAM</label>
                            <select name="ram_type" class="form-select">
                                <option value="">Tất cả loại RAM</option>
                                @foreach($ram_types as $ram_type)
                                    <option value="{{ $ram_type }}" {{ request('ram_type') == $ram_type ? 'selected' : '' }}>
                                        {{ $ram_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Sắp xếp -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Sắp xếp theo</label>
                            <select name="sort" class="form-select">
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-funnel"></i> Lọc sản phẩm
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Sản phẩm ({{ $products->total() }})</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="gridView">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" id="listView">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            <div class="row g-4" id="productGrid">
                @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 product-card animate-fade-up">
                        <div class="position-relative">
                            @if(isset($product->images) && $product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: contain;">
                            @else
                                <img src="https://via.placeholder.com/200" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: contain;">
                            @endif
                            @if($product->featured)
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-danger">Hot</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-truncate">
                                <a href="{{ route('products.show', $product->product_id) }}" class="text-decoration-none text-dark">
                                    {{ $product->product_name }}
                                </a>
                            </h5>
                            <p class="price mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                            <p class="card-text small text-muted mb-2">
                                <i class="bi bi-box"></i> Còn {{ $product->stock_quantity }} sản phẩm
                            </p>
                            <div class="d-flex gap-2">
                                @if($product->status === 'active' && $product->stock_quantity > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('gridView').addEventListener('click', function() {
    const grid = document.getElementById('productGrid');
    grid.className = 'row g-4';
    grid.querySelectorAll('.col-md-4').forEach(item => {
        item.className = 'col-md-4';
    });
});

document.getElementById('listView').addEventListener('click', function() {
    const grid = document.getElementById('productGrid');
    grid.className = 'row g-4';
    grid.querySelectorAll('.col-md-4').forEach(item => {
        item.className = 'col-12';
    });
});
</script>
@endpush
@endsection 