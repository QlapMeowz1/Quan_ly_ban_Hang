@extends('layouts.web')

@section('title', 'Sản phẩm')

@section('content')
    <h1 class="mb-4 text-center">Danh sách sản phẩm</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/200' }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <span class="badge bg-success mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    <p class="card-text small text-truncate">{{ $product->description }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection 