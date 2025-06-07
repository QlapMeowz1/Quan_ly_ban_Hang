@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Chỉnh sửa danh mục</h3>
    <form method="POST" action="{{ route('admin.categories.update', $category->category_id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="category_description" class="form-control">{{ old('category_description', $category->category_description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Danh mục cha</label>
            <select name="parent_category_id" class="form-control">
                <option value="">--- Không có ---</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ old('parent_category_id', $category->parent_category_id) == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 