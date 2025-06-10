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
                        data-image="{{ asset('storage/' . $img->image_url) }}"
                        onclick="document.getElementById('mainProductImg').src = this.dataset.image">
                @endforeach
            </div>
            @endif
        </div>

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

                @if($product->status === 'active' && $product->stock_quantity > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <div class="row g-2">
                        <div class="col-auto">
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="var input = document.getElementById('quantity'); var val = parseInt(input.value); if(val > 1) input.value = val - 1;">-</button>
                                <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock_quantity }}" autocomplete="off">
                                <button type="button" class="btn btn-outline-secondary" onclick="var input = document.getElementById('quantity'); var val = parseInt(input.value); var max = parseInt(input.getAttribute('max')); if(val < max) input.value = val + 1;">+</button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="alert alert-warning mt-3">
                    Sản phẩm này hiện đang ngừng bán hoặc hết hàng. Bạn không thể đặt hàng.
                </div>
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

    <!-- Product Reviews -->
    <div class="card border-0 shadow-sm my-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Đánh giá sản phẩm</h5>
            
            <!-- Rating Summary -->
            <div class="row mb-4">
                <div class="col-md-4 text-center">
                    <h2 class="display-4 mb-0">{{ number_format($product->average_rating, 1) }}</h2>
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $product->average_rating ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="text-muted">{{ $product->reviews->count() }} đánh giá</p>
                </div>
                <div class="col-md-8">
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $product->reviews->where('rating', $i)->count();
                            $percentage = $product->reviews->count() > 0 ? ($count / $product->reviews->count()) * 100 : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                {{ $i }} <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="progress flex-grow-1" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $percentage > 0 ? number_format($percentage, 1) : '0' }}%"></div>
                            </div>
                            <div class="ms-2 text-muted" style="width: 40px;">
                                {{ $count }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Review Form -->
            @auth
                @php $customer = auth()->user()->customer; @endphp
                @if($customer && $customer->orders()->whereHas('orderItems', function($query) use ($product) {
                    $query->where('product_id', $product->product_id);
                })->exists())
                    <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề (tuỳ chọn)</label>
                            <input type="text" name="title" class="form-control" maxlength="200">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đánh giá của bạn</label>
                            <div class="rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                    <label for="star{{ $i }}"><i class="bi bi-star-fill"></i></label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review_text" class="form-label">Nhận xét</label>
                            <textarea class="form-control" id="review_text" name="review_text" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                @endif
            @endauth

            <!-- Reviews List -->
            <div class="reviews-list">
                @forelse($product->reviews()->with('customer')->where('status', 'approved')->latest()->get() as $review)
                    <div class="review-item border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $review->customer->first_name ?? 'Ẩn danh' }}</strong>
                                @if($review->title)
                                    <div class="fw-bold">{{ $review->title }}</div>
                                @endif
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $review->review_text }}</p>
                    </div>
                @empty
                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    padding: 0 0.1em;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: #ffc107;
}
</style>
@endpush

@push('scripts')
<script>
// Hàm thay đổi số lượng - global function
function changeQuantity(delta) {
    var input = document.getElementById('quantity');
    var currentValue = parseInt(input.value) || 1;
    var maxValue = parseInt(input.getAttribute('max')) || 999;
    var newValue = currentValue + delta;
    
    if (newValue >= 1 && newValue <= maxValue) {
        input.value = newValue;
    }
}

// Hàm thay đổi ảnh chính
function changeMainImage(element) {
    document.getElementById('mainProductImg').src = element.dataset.image;
}

// Khởi tạo các event listeners khác nếu cần
document.addEventListener('DOMContentLoaded', function() {
    // Log để debug
    console.log('Product page loaded');
    
    // Kiểm tra input quantity có tồn tại không
    var quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        console.log('Quantity input found, max:', quantityInput.getAttribute('max'));
    } else {
        console.error('Quantity input not found!');
    }
});
</script>
@endpush
@endsection 