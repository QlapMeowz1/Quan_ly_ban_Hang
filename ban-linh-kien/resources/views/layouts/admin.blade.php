<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Trang quản trị LinhKien" />
    <meta name="author" content="LinhKien Dev Team" />
    <title>@yield('title', 'Dashboard') - LinhKien Admin</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('themes/admin/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">LinhKien Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('home') }}">Xem trang chủ</a></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Cài đặt tài khoản</a></li>
                    <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                            <button type="submit" class="dropdown-item w-100 text-start">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidenav -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Quản lý</div>

                        <!-- Quản lý danh mục -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.categories.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDanhMuc">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Quản lý danh mục
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="collapseDanhMuc" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Danh sách danh mục</a>
                                <a class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}" href="{{ route('admin.categories.create') }}">Thêm danh mục</a>
                            </nav>
                        </div>

                        <!-- Quản lý sản phẩm -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.products.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSanPham">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Quản lý sản phẩm
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="collapseSanPham" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a>
                                <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">Thêm sản phẩm</a>
                            </nav>
                        </div>

                        <!-- Quản lý thương hiệu -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.brands.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseThuongHieu">
                            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                            Quản lý thương hiệu
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.brands.*') ? 'show' : '' }}" id="collapseThuongHieu" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.brands.index') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">Danh sách thương hiệu</a>
                                <a class="nav-link {{ request()->routeIs('admin.brands.create') ? 'active' : '' }}" href="{{ route('admin.brands.create') }}">Thêm thương hiệu</a>
                            </nav>
                        </div>

                        <!-- Quản lý người dùng -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.customers.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNguoiDung">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Quản lý khách hàng
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.customers.*') ? 'show' : '' }}" id="collapseNguoiDung" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">Danh sách khách hàng</a>
                            </nav>
                        </div>

                        <!-- Quản lý đơn hàng -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.orders.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDonHang">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Quản lý đơn hàng
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="collapseDonHang" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.orders.list') ? 'active' : '' }}" href="{{ route('admin.orders.list') }}">Danh sách đơn hàng</a>
                            </nav>
                        </div>

                        <!-- Quản lý mã giảm giá -->
                        <a class="nav-link collapsed {{ request()->routeIs('admin.coupons.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaGiamGia">
                            <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                            Mã giảm giá
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.coupons.*') ? 'show' : '' }}" id="collapseMaGiamGia" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">Danh sách mã giảm giá</a>
                                <a class="nav-link {{ request()->routeIs('admin.coupons.create') ? 'active' : '' }}" href="{{ route('admin.coupons.create') }}">Thêm mã giảm giá</a>
                            </nav>
                        </div>

                        <!-- Thống kê -->
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Báo cáo & Thống kê
                        </a>

                        <!-- Cài đặt -->
                        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                            Cài đặt website
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Đăng nhập với quyền:</div>
                    {{ ucfirst(Auth::user()->role ?? 'Administrator') }}
                </div>
            </nav>
        </div>

        <!-- Nội dung chính -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('themes/admin/js/scripts.js') }}"></script>
    <!-- Chart.js phiên bản mới -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    @stack('scripts')
</body>
</html> 