@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Quản lý thương hiệu</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm thương hiệu
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Tên thương hiệu</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->brand_id }}</td>
                            <td>
                                @if($brand->brand_logo)
                                    <img src="{{ asset('storage/' . $brand->brand_logo) }}" 
                                         alt="{{ $brand->brand_name }}" 
                                         class="img-thumbnail"
                                         style="max-width: 100px; height: auto;">
                                @else
                                    <span class="text-muted">Chưa có logo</span>
                                @endif
                            </td>
                            <td>{{ $brand->brand_name }}</td>
                            <td>{{ Str::limit($brand->brand_description, 100) }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.brands.edit', $brand->brand_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.brands.show', $brand->brand_id) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->brand_id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 