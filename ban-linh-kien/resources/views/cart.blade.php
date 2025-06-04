@extends('layouts.web')

@section('title', 'Giỏ hàng')

@section('content')
    <h1>Giỏ hàng của bạn</h1>
    @if(isset($cart) && count($cart) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                    <td>
                        <form action="/cart/remove" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="/checkout" class="btn btn-success">Thanh toán</a>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
    @endif
@endsection 