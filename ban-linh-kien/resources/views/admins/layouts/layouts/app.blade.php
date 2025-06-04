<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - @yield('title', 'Admin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Trang chủ</a>
            <a class="nav-link" href="{{ route('admins.index') }}">Quản lý Admin</a>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html> 