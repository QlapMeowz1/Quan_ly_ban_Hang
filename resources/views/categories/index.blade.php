            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 animate__animated animate__fadeInUp">
                <div class="card h-100 shadow-sm border-0 transition">
                    <div class="card-body text-center">
                        <span class="display-6 text-primary"><i class="bi bi-box"></i></span>
                        <h5 class="card-title mt-2">{{ $category->name }}</h5>
                        <p class="card-text small">{{ $category->description }}</p>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
            </div> 