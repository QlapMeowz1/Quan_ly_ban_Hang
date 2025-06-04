@extends('layouts.web')

@section('title', 'Danh mục sản phẩm')

@section('content')
    <h1 class="mb-4 text-center">Danh mục sản phẩm</h1>
    <div class="row justify-content-center">
        @foreach($categories as $category)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <span class="display-6 text-primary"><i class="bi bi-box"></i></span>
                        <h5 class="card-title mt-2">{{ $category->name }}</h5>
                        <p class="card-text small">{{ $category->description }}</p>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection 