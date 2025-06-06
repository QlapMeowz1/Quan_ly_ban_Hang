@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Chỉnh sửa Sản phẩm</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Thông tin cơ bản</h6>

                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                           id="product_name" name="product_name" 
                                           value="{{ old('product_name', $product->product_name) }}" required>
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="product_code" class="form-label">Mã sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_code') is-invalid @enderror" 
                                           id="product_code" name="product_code" 
                                           value="{{ old('product_code', $product->product_code) }}" required>
                                    @error('product_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" name="category_id" required>
                                                <option value="">Chọn danh mục</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->category_id }}" 
                                                            {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="brand_id" class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                                            <select class="form-select @error('brand_id') is-invalid @enderror" 
                                                    id="brand_id" name="brand_id" required>
                                                <option value="">Chọn thương hiệu</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->brand_id }}" 
                                                            {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="specifications" class="form-label">Thông số kỹ thuật (JSON)</label>
                                    <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                              id="specifications" name="specifications" rows="4">{{ old('specifications', $product->specifications) }}</textarea>
                                    @error('specifications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Giá & Kho hàng</h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                       id="price" name="price" 
                                                       value="{{ old('price', $product->price) }}" required>
                                                <span class="input-group-text">đ</span>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cost_price" class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('cost_price') is-invalid @enderror" 
                                                       id="cost_price" name="cost_price" 
                                                       value="{{ old('cost_price', $product->cost_price) }}" required>
                                                <span class="input-group-text">đ</span>
                                                @error('cost_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock_quantity" class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                   id="stock_quantity" name="stock_quantity" 
                                                   value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="min_stock_level" class="form-label">Tồn kho tối thiểu <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror" 
                                                   id="min_stock_level" name="min_stock_level" 
                                                   value="{{ old('min_stock_level', $product->min_stock_level) }}" required>
                                            @error('min_stock_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Trạng thái</h6>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                            Đang bán
                                        </option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                            Ngừng bán
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input @error('featured') is-invalid @enderror" 
                                               id="featured" name="featured" value="1" 
                                               {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">Sản phẩm nổi bật</label>
                                        @error('featured')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Hình ảnh</h6>

                                <div class="mb-3">
                                    <label for="images" class="form-label">Thêm ảnh mới</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                           id="images" name="images[]" multiple accept="image/*">
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Có thể chọn nhiều ảnh. Chấp nhận các định dạng: JPG, PNG, GIF</small>
                                </div>

                                <div class="row g-2">
                                    @foreach($product->images as $image)
                                        <div class="col-6">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image->image_url) }}" 
                                                     alt="{{ $product->product_name }}"
                                                     class="img-thumbnail">
                                                <div class="position-absolute top-0 end-0">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" 
                                                               name="delete_images[]" value="{{ $image->image_id }}">
                                                        <label class="form-check-label">Xóa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 