@extends('layouts.web')

@section('title', 'Giỏ hàng')

@section('content')
    <h1>Giỏ hàng của bạn</h1>
    @if(isset($cart) && count($cart) > 0)
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th><i class="bi bi-box"></i> Sản phẩm</th>
                    <th><i class="bi bi-cash-coin"></i> Giá</th>
                    <th><i class="bi bi-123"></i> Số lượng</th>
                    <th><i class="bi bi-calculator"></i> Thành tiền</th>
                    <th><i class="bi bi-gear"></i> Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $productId => $quantity)
                    @php
                        $product = \App\Models\Product::find($productId);
                    @endphp
                    @if($product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                        <td><span class="badge bg-info">{{ $quantity }}</span></td>
                        <td>{{ number_format($product->price * $quantity, 0, ',', '.') }} đ</td>
                        <td>
                            <form action="/cart/remove" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="text-end mt-3">
            <a href="{{ url('/checkout') }}" class="btn btn-success btn-lg">
                <i class="bi bi-cash-coin"></i> Thanh toán
            </a>
        </div>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
    @endif
@endsection 