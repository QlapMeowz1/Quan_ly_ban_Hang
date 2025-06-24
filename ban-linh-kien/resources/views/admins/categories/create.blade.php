@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Thêm danh mục mới</h3>
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" required>
            @error('category_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="category_description" class="form-control">{{ old('category_description') }}</textarea>
            @error('category_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Danh mục cha</label>
            <select name="parent_category_id" class="form-control">
                <option value="">--- Không có ---</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ old('parent_category_id') == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @error('parent_category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 
