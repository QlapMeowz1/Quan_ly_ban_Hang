@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Chỉnh sửa thương hiệu</h1>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('admin.brands.update', $brand->brand_id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('brand_name') is-invalid @enderror" 
                                   id="brand_name" 
                                   name="brand_name" 
                                   value="{{ old('brand_name', $brand->brand_name) }}" 
                                   required>
                            @error('brand_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand_description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('brand_description') is-invalid @enderror" 
                                      id="brand_description" 
                                      name="brand_description" 
                                      rows="4">{{ old('brand_description', $brand->brand_description) }}</textarea>
                            @error('brand_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand_logo" class="form-label">Logo</label>
                            <input type="file" 
                                   class="form-control @error('brand_logo') is-invalid @enderror" 
                                   id="brand_logo" 
                                   name="brand_logo"
                                   accept="image/*">
                            <div class="form-text">Để trống nếu không muốn thay đổi logo.</div>
                            @error('brand_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title mb-3">Logo hiện tại</h5>
                    @if($brand->brand_logo)
                        <img src="{{ asset('storage/' . $brand->brand_logo) }}" 
                             alt="{{ $brand->brand_name }}" 
                             class="img-fluid rounded">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                             style="height: 200px">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center text-muted mt-2">Chưa có logo</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
