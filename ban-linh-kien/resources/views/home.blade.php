@extends('layouts.web')

@section('title', 'Trang chủ')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">Chào mừng đến với <span class="text-primary">Shop Linh Kiện!</span></h1>
        <p class="lead">Chuyên cung cấp linh kiện máy tính, điện tử chất lượng cao.</p>
        <img src="https://cdn.pixabay.com/photo/2017/01/06/19/15/computer-1952027_1280.jpg" class="img-fluid rounded shadow mb-4" style="max-width: 600px;">
        <div class="mt-4">
            <a href="/products" class="btn btn-lg btn-success">Xem sản phẩm</a>
            <a href="/categories" class="btn btn-lg btn-outline-primary ms-2">Danh mục</a>
        </div>
    </div>
    <hr class="my-5">
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row justify-content-center">
        @foreach($featuredProducts ?? [] as $product)
            @if(is_object($product))
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/200' }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
@endsection 