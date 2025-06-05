@extends('layouts.web')

@section('content')
@php
    $images = $product->images;
    $mainImage = $images->first()->image_url ?? 'https://via.placeholder.com/300';
    $oldPrice = $product->cost_price ?? null;
    $discount = ($oldPrice && $oldPrice > $product->price) ? round(100 * ($oldPrice - $product->price) / $oldPrice) : 0;
    $specs = is_array($product->specifications) ? $product->specifications : (json_decode($product->specifications, true) ?? []);
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <img id="mainProductImg" src="{{ $mainImage }}" alt="{{ $product->product_name }}" class="img-fluid mb-3 border rounded shadow-sm" style="max-height:300px;object-fit:contain;">
            @if($images->count() > 1)
            <div class="d-flex gap-2 mt-2">
                @foreach($images as $img)
                    <img src="{{ $img->image_url }}" alt="thumb" class="img-thumbnail" style="width:60px;height:60px;object-fit:cover;cursor:pointer;" onclick="document.getElementById('mainProductImg').src='{{ $img->image_url }}'">
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-md-7">
            <h3 class="fw-bold mb-2">{{ $product->product_name }}</h3>
            <div class="mb-2">
                <span class="fs-3 text-danger fw-bold"><i class="bi bi-cash-coin"></i> {{ number_format($product->price, 0, ',', '.') }}đ</span>
                @if($oldPrice && $oldPrice > $product->price)
                    <span class="text-muted text-decoration-line-through ms-2">{{ number_format($oldPrice, 0, ',', '.') }}đ</span>
                    <span class="badge bg-danger ms-2">-{{ $discount }}%</span>
                @endif
            </div>
            <form action="/cart" method="POST" class="mb-3 d-flex gap-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-danger btn-lg fw-bold flex-fill"><i class="bi bi-lightning-charge"></i> MUA NGAY</button>
            </form>
            <form action="/cart" method="POST" class="mb-3 d-flex gap-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success btn-lg fw-bold flex-fill"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</button>
            </form>
            <div class="alert alert-info py-2"><i class="bi bi-truck"></i> Giao tận nơi hoặc nhận tại cửa hàng</div>
            <div class="mt-3">
                <h5 class="fw-bold"><i class="bi bi-info-circle"></i> Thông tin sản phẩm</h5>
                <div class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ $product->description }}</div>
                @if(!empty($specs))
                <h6 class="fw-bold mt-3"><i class="bi bi-list-check"></i> Thông số kỹ thuật:</h6>
                <ul class="list-unstyled">
                    @foreach($specs as $key => $val)
                        <li><i class="bi bi-dot"></i> <b>{{ ucfirst(str_replace('_',' ',$key)) }}:</b> {{ is_array($val) ? json_encode($val) : $val }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 