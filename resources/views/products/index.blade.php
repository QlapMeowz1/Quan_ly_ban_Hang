        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 animate__animated animate__fadeInUp">
            <div class="card h-100 shadow-sm border-0 transition">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/200' }}" class="card-img-top hover-zoom" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title text-primary">{{ $product->name }}</h5>
                    <span class="badge bg-gradient mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    <p class="card-text small text-truncate">{{ $product->description }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div> 