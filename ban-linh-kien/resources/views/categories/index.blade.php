@extends('layouts.web')

@section('title', 'Danh mục sản phẩm - Shop Linh Kiện')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Tất cả danh mục</h4>
                        <span class="badge bg-primary">{{ $categories->count() }} danh mục</span>
                    </div>

                    <div class="row g-4">
                        @forelse($categories as $category)
                        <div class="col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm category-card animate-fade-up">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-grid-3x3-gap-fill display-4 text-primary"></i>
                                    </div>
                                    <h5 class="card-title">{{ $category->category_name }}</h5>
                                    <p class="text-muted small mb-3">
                                        {{ Str::limit($category->category_description, 100) }}
                                    </p>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div class="text-center">
                                            <h6 class="mb-0">{{ $category->products_count }}</h6>
                                            <small class="text-muted">Sản phẩm</small>
                                        </div>
                                        @if($category->children_count)
                                        <div class="text-center">
                                            <h6 class="mb-0">{{ $category->children_count }}</h6>
                                            <small class="text-muted">Danh mục con</small>
                                        </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('categories.show', $category->category_id) }}" 
                                       class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-eye"></i> Xem sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Chưa có danh mục nào được tạo.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<style>
.category-card {
    transition: all 0.3s ease;
}
.category-card:hover {
    transform: translateY(-5px);
}
.category-card .bi {
    transition: transform 0.3s ease;
}
.category-card:hover .bi {
    transform: scale(1.1);
}
</style>
@endsection 