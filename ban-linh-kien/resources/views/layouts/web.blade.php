@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Linh Kiện')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" type="image/svg+xml" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/cpu.svg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* Xóa nền họa tiết carbon, trả lại nền mặc định */
            transition: background 0.3s, color 0.3s;
        }
        .dark-mode {
            background: #18191a !important;
            color: #e4e6eb !important;
        }
        .dark-mode .card, .dark-mode .navbar, .dark-mode .footer-services, .dark-mode .footer-info, .dark-mode footer {
            background: #242526 !important;
            color: #e4e6eb !important;
        }
        .dark-mode .navbar-nav .nav-link, .dark-mode .navbar-brand {
            color: #e4e6eb !important;
        }
        .dark-mode .card {
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }
        .dark-mode .form-control {
            background: #242526;
            color: #e4e6eb;
            border-color: #444;
        }
        .dark-mode .form-control:focus {
            background: #18191a;
            color: #fff;
        }
        .dark-mode .btn-primary {
            background: #3a3b3c;
            border-color: #3a3b3c;
        }
        .dark-mode .btn-primary:hover {
            background: #4e54c8;
            border-color: #4e54c8;
        }
        .dark-mode .bg-gradient {
            background: linear-gradient(90deg, #232526 0%, #232526 100%) !important;
        }
        .dark-mode .alert {
            background: #232526;
            color: #e4e6eb;
            border-color: #444;
        }
        .dark-mode .dropdown-menu {
            background: #232526;
            color: #e4e6eb;
        }
        .dark-mode .dropdown-item {
            color: #e4e6eb;
        }
        .dark-mode .dropdown-item:hover {
            background: #3a3b3c;
        }
        .dark-mode .table {
            color: #e4e6eb;
        }
        .dark-mode .table thead th {
            background: #232526;
        }
        .dark-mode .footer-services, .dark-mode .footer-info {
            background: #232526 !important;
        }
        .dark-mode .fi-title, .dark-mode h4, .dark-mode h6, .dark-mode .fw-bold {
            color: #FFD600 !important;
        }
        .dark-mode a, .dark-mode a:visited {
            color: #FFD600;
        }
        .dark-mode a:hover {
            color: #fff;
        }
        .dark-mode .text-muted {
            color: #b0b3b8 !important;
        }
        .dark-mode .btn, .dark-mode .btn-secondary {
            background: #3a3b3c;
            color: #e4e6eb;
            border-color: #444;
        }
        .dark-mode .btn:hover, .dark-mode .btn-secondary:hover {
            background: #4e54c8;
            color: #fff;
        }
        .dark-mode .form-label {
            color: #FFD600;
        }
        .dark-mode .navbar {
            background: #232526 !important;
        }
        .dark-mode .navbar .nav-link.active, .dark-mode .navbar .nav-link:hover {
            background: #FFD600;
            color: #232526 !important;
        }
        .dark-mode .navbar .nav-link {
            color: #e4e6eb !important;
        }
        .dark-mode .navbar-brand {
            color: #FFD600 !important;
        }
        .dark-mode .dropdown-menu {
            background: #232526;
        }
        .dark-mode .dropdown-item {
            color: #e4e6eb;
        }
        .dark-mode .dropdown-item:hover {
            background: #3a3b3c;
        }
        .dark-mode .breadcrumb {
            color: #FFD600;
        }
        .dark-mode .alert-success {
            background: #232526;
            color: #FFD600;
        }
        .dark-mode .alert-danger {
            background: #232526;
            color: #ff4d4f;
        }
        .dark-mode .form-control::placeholder {
            color: #b0b3b8;
        }
        .dark-mode .form-select {
            background: #232526;
            color: #e4e6eb;
            border-color: #444;
        }
        .dark-mode .form-select:focus {
            background: #18191a;
            color: #fff;
        }
        .dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
            background: #232526;
        }
        .dark-mode .table-striped > tbody > tr:nth-of-type(even) {
            background: #18191a;
        }
        .dark-mode .table-hover > tbody > tr:hover {
            background: #3a3b3c;
        }
        .dark-mode .modal-content {
            background: #232526;
            color: #e4e6eb;
        }
        .dark-mode .modal-header, .dark-mode .modal-footer {
            border-color: #444;
        }
        .dark-mode .modal-title {
            color: #FFD600;
        }
        .dark-mode .close {
            color: #e4e6eb;
        }
        .dark-mode .pagination .page-link {
            background: #232526;
            color: #FFD600;
            border-color: #444;
        }
        .dark-mode .pagination .page-link.active, .dark-mode .pagination .active > .page-link {
            background: #FFD600;
            color: #232526;
            border-color: #FFD600;
        }
        .dark-mode .pagination .page-link:hover {
            background: #4e54c8;
            color: #fff;
        }
        .dark-mode .footer-info {
            background: #232526 !important;
        }
        .dark-mode .footer-info a {
            color: #FFD600;
        }
        .dark-mode .footer-info a:hover {
            color: #fff;
        }
        .dark-mode .fi-title, .dark-mode .footer-info h4, .dark-mode .footer-info h6 {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .text-muted {
            color: #b0b3b8 !important;
        }
        .dark-mode .footer-info .fw-bold {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .payment_block h4 {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .payment_block img {
            filter: brightness(0.8) contrast(1.2);
        }
        .dark-mode .footer-info .fi-title {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa-phone, .dark-mode .footer-info .fa-envelope, .dark-mode .footer-info .fa-map-marker-alt {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .widget_links h4 {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .widget_links img {
            filter: brightness(0.8) contrast(1.2);
        }
        .dark-mode .footer-info .fi-title {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa-phone, .dark-mode .footer-info .fa-envelope, .dark-mode .footer-info .fa-map-marker-alt {
            color: #FFD600 !important;
        }
        .dark-mode .footer-info .fa {
            color: #FFD600 !important;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
        .hover-zoom:hover {
            transform: scale(1.08);
            transition: transform 0.3s;
        }
        .bg-gradient {
            background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
            color: #fff !important;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #4e54c8 !important;
            letter-spacing: 1px;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link:hover {
            color: #fff !important;
            background: #4e54c8;
            border-radius: 0.25rem;
        }
        .navbar-nav .nav-link {
            color: #4e54c8 !important;
            margin-right: 0.5rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
    </style>
</head>
<body>
    <button id="toggle-darkmode" class="btn btn-secondary position-fixed top-0 end-0 m-3 z-3" style="z-index:9999;">
        <i class="fa fa-moon"></i> <span>Dark Mode</span>
    </button>
    <nav class="navbar navbar-expand-lg navbar-light bg-gradient border-bottom shadow-sm mb-4" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);">
        <div class="container">
            <a class="navbar-brand text-white" href="/"><i class="bi bi-cpu"></i> <span style="color:#FFD600">Shop Linh Kiện</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white" href="/"><i class="bi bi-house-door"></i> Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/products"><i class="bi bi-box-seam"></i> Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/cart"><i class="bi bi-cart"></i> Giỏ hàng</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/categories"><i class="bi bi-grid"></i> Danh mục</a></li>
                    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin']))
                        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Quản lý user</a></li>
                        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.admins.index') }}"><i class="bi bi-person-badge"></i> Quản lý admin</a></li>
                    @endif
                    @guest
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}"><i class="bi bi-person"></i> Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Đăng ký</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-primary text-white fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Xin chào, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu animate__animated animate__fadeIn" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-pencil-square"></i> Chỉnh sửa thông tin</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.password') }}"><i class="bi bi-key"></i> Đổi mật khẩu</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-clock-history"></i> Lịch sử mua hàng</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit"><i class="bi bi-trash"></i> Xóa tài khoản</button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <div class="footer-services py-4" style="background: #f9f9f9; border-top: 2px solid #2db200;">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <i class="fa fa-truck fa-2x" style="color:#2db200"></i>
                    <h6 class="mt-2 mb-1" style="color:#2196f3">Vận chuyển nhanh - 24h</h6>
                    <div style="font-size: 14px;">Tất cả đơn hàng được xử lý trong ngày.<br>Phí vận chuyển được hỗ trợ theo từng đơn hàng cụ thể</div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <i class="fa fa-money-bill fa-2x" style="color:#2db200"></i>
                    <h6 class="mt-2 mb-1" style="color:#2196f3">Kiểm tra trước khi giao hàng</h6>
                    <div style="font-size: 14px;">Đảm bảo chất lượng 100%</div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <i class="fa fa-smile fa-2x" style="color:#2db200"></i>
                    <h6 class="mt-2 mb-1" style="color:#2196f3">Hỗ trợ tư vấn</h6>
                    <div style="font-size: 14px;">Thứ 2 - Chủ nhật: 08h30 - 17h30</div>
                </div>
                <div class="col-md-3">
                    <i class="fa fa-phone fa-2x" style="color:#2db200"></i>
                    <h6 class="mt-2 mb-1" style="color:#2196f3">Đặt hàng trực tuyến</h6>
                    <div style="font-size: 14px;">Gọi ngay: <b>0123.456.789</b></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-info py-4" style="background: #eaeaea;">
        <div class="container">
            <div class="row text-start">
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold mb-2">LIÊN HỆ</h6>
                    <div>Đơn vị cung cấp linh kiện điện tử.</div>
                    <div class="mb-1 mt-2"><i class="fa fa-map-marker-alt"></i> Hà Đông, Hà Nội</div>
                    <div><i class="fa fa-phone"></i> Cửa hàng: 0123.456.789</div>
                    <div>Online: 0123.456.789</div>
                    <div>Kỹ thuật: 0123.456.789</div>
                    <div>Hotline: 0123.456.789</div>
                    <div class="mt-1"><i class="fa fa-envelope"></i> hunter_rain@melmuop.space</div>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold mb-2">CHÍNH SÁCH</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Chính sách thanh toán</a></li>
                        <li><a href="#">Chính sách vận chuyển</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả hàng</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold mb-2">HỖ TRỢ</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Đăng ký thành viên</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    
                    <div class="fi-title">CHỨNG NHẬN </div>
                    <a target="_blank" href="http://online.gov.vn/Home/WebDetails/24272">
                        <img data-lazyload="//bizweb.dktcdn.net/100/140/943/themes/958293/assets/register_logo.png?1722309341662"
                             src="//bizweb.dktcdn.net/100/140/943/themes/958293/assets/register_logo.png?1722309341662"
                             class="img-fluid" style="background: none; max-width:120px; height:auto;">
                    </a>
                    <div class="widget widget_links clearfix mt-3">
                        <div class="payment_block">
                            <h4>HÌNH THỨC THANH TOÁN </h4>
                            <img data-lazyload="//bizweb.dktcdn.net/100/140/943/themes/958293/assets/payment_logo.png?1722309341662" src="//bizweb.dktcdn.net/100/140/943/themes/958293/assets/payment_logo.png?1722309341662" style="background: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-4 mb-2 text-muted">
        &copy; melmuop.space
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark mode toggle
        const btn = document.getElementById('toggle-darkmode');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        function setDarkMode(on) {
            if(on) {
                document.body.classList.add('dark-mode');
                btn.querySelector('i').className = 'fa fa-sun';
                btn.querySelector('span').textContent = 'Light Mode';
                localStorage.setItem('darkmode', '1');
            } else {
                document.body.classList.remove('dark-mode');
                btn.querySelector('i').className = 'fa fa-moon';
                btn.querySelector('span').textContent = 'Dark Mode';
                localStorage.setItem('darkmode', '0');
            }
        }
        btn.addEventListener('click', function() {
            setDarkMode(!document.body.classList.contains('dark-mode'));
        });
        // Khởi tạo theo localStorage hoặc hệ điều hành
        if(localStorage.getItem('darkmode') === '1' || (localStorage.getItem('darkmode') === null && prefersDark)) {
            setDarkMode(true);
        }
    </script>
    @stack('styles')
    @stack('scripts')
</body>
</html> 