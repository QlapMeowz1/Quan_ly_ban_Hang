        <img src="https://cdn.pixabay.com/photo/2017/01/06/19/15/computer-1952027_1280.jpg" class="img-fluid rounded shadow mb-4 animate__animated animate__fadeInDown" style="max-width: 600px;">
        <div class="col-md-3 mb-4 animate__animated animate__zoomIn">
            <div class="card h-100 shadow-sm border-0 transition">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/200' }}" class="card-img-top hover-zoom" alt="{{ $product->name }}">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">{{ $product->name }}</h5>
                    <span class="badge bg-gradient mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div> 