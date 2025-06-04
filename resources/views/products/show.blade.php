    <div class="row justify-content-center">
        <div class="col-md-6 animate__animated animate__fadeInRight">
            <div class="card shadow border-0">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" class="card-img-top hover-zoom" alt="{{ $product->name }}">
                <div class="card-body">
                    <h1 class="card-title text-primary">{{ $product->name }}</h1>
                    <span class="badge bg-gradient mb-2">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    <p class="card-text">{{ $product->description }}</p>
                    <form action="/cart" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label>Số lượng:</label>
                        <input type="number" name="quantity" value="1" min="1" class="form-control d-inline-block mb-2" style="width:100px;display:inline-block;">
                        <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
                    </form>
                    <a href="{{ route('products.index') }}" class="btn btn-link">&laquo; Quay lại danh sách</a>
                </div>
            </div>
        </div>
    </div> 