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
    <style>
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
                        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.users') }}"><i class="bi bi-people"></i> Quản lý user</a></li>
                        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admins.index') }}"><i class="bi bi-person-badge"></i> Quản lý admin</a></li>
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
    <footer class="text-center mt-4 mb-2 text-muted">
        &copy; melmuop.space
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 