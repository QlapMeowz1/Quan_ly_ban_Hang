@extends('layouts.admin')

@section('title', 'Thêm thương hiệu mới')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm thương hiệu mới</h2>
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="brand_name" class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
            <input type="text" name="brand_name" id="brand_name" class="form-control" required value="{{ old('brand_name') }}">
        </div>
        <div class="mb-3">
            <label for="brand_description" class="form-label">Mô tả</label>
            <textarea name="brand_description" id="brand_description" class="form-control" rows="3">{{ old('brand_description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="brand_logo" class="form-label">Logo thương hiệu</label>
            <input type="file" name="brand_logo" id="brand_logo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Thêm thương hiệu</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 
