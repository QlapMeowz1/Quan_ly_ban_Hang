@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Chi tiết danh mục</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->category_name }}</h5>
            <p class="card-text">
                <strong>Mô tả:</strong> {{ $category->category_description ?: 'Không có mô tả' }}
            </p>
            @if($category->parent)
                <p class="card-text">
                    <strong>Danh mục cha:</strong> {{ $category->parent->category_name }}
                </p>
            @endif
            <p class="card-text">
                <strong>Số sản phẩm:</strong> {{ $category->products()->count() }}
            </p>
            <a href="{{ route('admin.categories.edit', $category->category_id) }}" class="btn btn-primary">Chỉnh sửa</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection 