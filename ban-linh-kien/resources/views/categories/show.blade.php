@extends('layouts.web')

@section('title', $category->category_name . ' - Shop Linh Kiện')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-decoration-none">Danh mục</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->category_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Thông tin danh mục</h5>
                    <div class="text-center mb-4">
                        <i class="bi bi-grid-3x3-gap-fill display-1 text-primary"></i>
                        <h4 class="mt-3">{{ $category->category_name }}</h4>
                        <p class="text-muted">{{ $category->category_description }}</p>
                        <div class="d-flex justify-content-around text-center mt-4">
                            <div>
                                <h5 class="mb-0">{{ $products->total() }}</h5>
                                <small class="text-muted">Sản phẩm</small>
                            </div>
                            @if($category->parent)
                            <div>
                                <h6 class="mb-0">{{ $category->parent->category_name }}</h6>
                                <small class="text-muted">Danh mục cha</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($category->children->isNotEmpty())
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Danh mục con</h5>
                    <div class="list-group list-group-flush">
                        @foreach($category->children as $child)
                        <a href="{{ route('categories.show', $child->category_id) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $child->category_name }}
                            <span class="badge bg-primary rounded-pill">{{ $child->products_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Sản phẩm trong danh mục</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="gridView">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" id="listView">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Chưa có sản phẩm nào trong danh mục này.
                </div>
            @else
                <div class="row g-4" id="productGrid">
                    @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100 product-card animate-fade-up">
                            <div class="position-relative">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ $product->images->first()->image_url }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->product_name }}" 
                                         style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/200" 
                                         class="card-img-top" 
                                         alt="{{ $product->product_name }}" 
                                         style="height: 200px; object-fit: contain;">
                                @endif
                                @if($product->featured)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-danger">Hot</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-truncate">
                                    <a href="{{ route('products.show', $product->product_id) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $product->product_name }}
                                    </a>
                                </h5>
                                <p class="price mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bi bi-box"></i> Còn {{ $product->stock_quantity }} sản phẩm
                                </p>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                        </button>
                                    </form>
                                    <a href="{{ route('products.show', $product->product_id) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
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
