<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Linh Kiện')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Shop Linh Kiện</a>
            <div>
                <a class="nav-link d-inline" href="/">Trang chủ</a>
                <a class="nav-link d-inline" href="/products">Sản phẩm</a>
                <a class="nav-link d-inline" href="/cart">Giỏ hàng</a>
                <a class="nav-link d-inline" href="/login">Đăng nhập</a>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <footer class="text-center mt-4 mb-2 text-muted">
        &copy; {{ date('Y') }} Shop Linh Kiện
    </footer>
</body>
</html> 