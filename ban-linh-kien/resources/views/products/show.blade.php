@extends('layouts.web')

@section('title', $product->product_name . ' - Shop Linh Kiện')

@section('content')
@php
    $images = $product->images;
    $mainImage = $images->first() ? asset('storage/' . $images->first()->image_url) : 'https://via.placeholder.com/500';
    $oldPrice = $product->cost_price ?? null;
    $discount = ($oldPrice && $oldPrice > $product->price) ? round(100 * ($oldPrice - $product->price) / $oldPrice) : 0;
    $specs = is_array($product->specifications) ? $product->specifications : (json_decode($product->specifications, true) ?? []);
@endphp

<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->category_id) }}" class="text-decoration-none">{{ $product->category->category_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5 mb-4">
            <div class="position-relative">
                <img id="mainProductImg" src="{{ $mainImage }}" alt="{{ $product->product_name }}" 
                    class="img-fluid rounded shadow-sm mb-3" style="width: 100%; height: 400px; object-fit: contain;">
                @if($discount > 0)
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-danger">-{{ $discount }}%</span>
                    </div>
                @endif
            </div>
            @if($images->count() > 1)
            <div class="d-flex gap-2 flex-wrap">
                @foreach($images as $img)
                    <img src="{{ asset('storage/' . $img->image_url) }}" alt="thumb" 
                        class="img-thumbnail" 
                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                        onclick="document.getElementById('mainProductImg').src='{{ asset('storage/' . $img->image_url) }}'">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            <h1 class="h2 mb-4">{{ $product->product_name }}</h1>
            
            <div class="mb-4">
                <span class="h3 text-danger me-3">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @if($oldPrice && $oldPrice > $product->price)
                    <span class="text-muted text-decoration-line-through">{{ number_format($oldPrice, 0, ',', '.') }}đ</span>
                @endif
            </div>

            <div class="mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                        {{ $product->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                    </span>
                    <span class="text-muted">
                        <i class="bi bi-box"></i> Còn {{ $product->stock_quantity }} sản phẩm
                    </span>
                </div>

                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <div class="row g-2">
                        <div class="col-auto">
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                                <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock_quantity }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>

            <!-- Quick Specs -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Thông số nổi bật</h5>
                    <div class="row">
                        @foreach(array_slice($specs, 0, 6) as $key => $value)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check2-circle text-primary me-2"></i>
                                <span class="text-muted">{{ ucfirst($key) }}:</span>
                                <span class="ms-2 fw-medium">{{ $value }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h5>Mô tả sản phẩm</h5>
                <div class="text-muted">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Full Specifications -->
    <div class="card border-0 shadow-sm my-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Thông số kỹ thuật chi tiết</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        @foreach($specs as $key => $value)
                        <tr>
                            <th style="width: 30%">{{ ucfirst($key) }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <section class="my-5">
        <h3 class="mb-4">Sản phẩm liên quan</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-6 col-md-3">
                <div class="card h-100 product-card">
                    <div class="position-relative">
                        @if($related->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" class="card-img-top" 
                                alt="{{ $related->product_name }}" style="height: 200px; object-fit: contain;">
                        @else
                            <img src="https://via.placeholder.com/200" class="card-img-top" 
                                alt="{{ $related->product_name }}" style="height: 200px; object-fit: contain;">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">
                            <a href="{{ route('products.show', $related->product_id) }}" class="text-decoration-none text-dark">
                                {{ $related->product_name }}
                            </a>
                        </h5>
                        <p class="price mb-0">{{ number_format($related->price, 0, ',', '.') }} đ</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}
</script>
@endpush
@endsection 