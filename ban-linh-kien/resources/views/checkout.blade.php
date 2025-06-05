@extends('layouts.web')

@section('content')
<div class="container">
    <h2>Thanh toán đơn hàng</h2>
    @if(session('cart') && count(session('cart')) > 0)
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $productId => $quantity)
                        @php
                            $product = \App\Models\Product::find($productId);
                        @endphp
                        @if($product)
                        @php
                            $subtotal = $product->price * $quantity;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $quantity }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <h4>Tổng cộng: {{ number_format($total, 0, ',', '.') }} đ</h4>
            <div class="mb-3">
                <label>Địa chỉ nhận hàng</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Đặt hàng</button>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
    @endif
</div>
@endsection
