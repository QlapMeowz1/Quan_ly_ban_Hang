@extends('layouts.web')

@section('title', 'Danh mục sản phẩm')

@section('content')
    <div class="container">
        <h2>Danh mục sản phẩm</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->category_description }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-info btn-sm">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection 