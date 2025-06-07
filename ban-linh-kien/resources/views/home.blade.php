@extends('layouts.web')

@section('title', 'Trang chủ')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">Chào mừng đến với <span class="text-primary">Shop Linh Kiện!</span></h1>
        <p class="lead">Chuyên cung cấp linh kiện máy tính, điện tử chất lượng cao.</p>
        <img src="https://cdn.pixabay.com/photo/2017/01/06/19/15/computer-1952027_1280.jpg" class="img-fluid rounded shadow mb-4 animate__animated animate__fadeInDown" style="max-width: 600px;">
        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-lg btn-success">Xem sản phẩm</a>
            <a href="{{ route('categories.index') }}" class="btn btn-lg btn-outline-primary ms-2">Danh mục</a>
        </div>
    </div>
    <hr class="my-5">
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row justify-content-center">
        @foreach($featuredProducts ?? [] as $product)
            @if(is_object($product))
            <div class="col-md-3 mb-4 animate__animated animate__zoomIn">
                <div class="card h-100 shadow-sm border-0 transition">
                    @if($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" class="card-img-top hover-zoom" alt="{{ $product->product_name }}" style="height: 200px; object-fit: contain;">
                    @else
                        <img src="https://via.placeholder.com/200" class="card-img-top hover-zoom" alt="{{ $product->product_name }}" style="height: 200px; object-fit: contain;">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">{{ $product->product_name }}</h5>
                        <span class="badge bg-gradient mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                        <div class="d-flex gap-2 justify-content-center mt-2">
                            <form action="{{ route('cart.add') }}" method="POST">
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
            @endif
        @endforeach
    </div>
@endsection 