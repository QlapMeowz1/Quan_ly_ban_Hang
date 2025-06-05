@extends('layouts.web')

@section('title', $category->name)

@section('content')
<div class="container">
    <h2>Danh mục: {{ $category->category_name }}</h2>
    <p><strong>Mô tả:</strong> {{ $category->category_description }}</p>
    <h4>Sản phẩm thuộc danh mục này:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-info btn-sm">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
