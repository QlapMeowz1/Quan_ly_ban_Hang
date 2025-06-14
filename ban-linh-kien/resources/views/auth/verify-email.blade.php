<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xác thực Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        .message {
            margin: 20px 0;
            color: #666;
        }
        .resend-button {
            padding: 10px 20px;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .resend-button:hover {
            background: #138496;
        }
        .logout-button {
            margin-top: 15px;
            display: block;
            color: #dc3545;
            text-decoration: none;
        }
        .logout-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Xác thực Email</h2>
        
        <div class="message">
            @if (session('resent'))
                <p>Một liên kết xác thực mới đã được gửi đến địa chỉ email của bạn.</p>
            @else
                <p>Vui lòng kiểm tra email của bạn để xác thực tài khoản.</p>
            @endif
        </div>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="resend-button">
                Gửi lại email xác thực
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">
                Đăng xuất
            </button>
        </form>
    </div>
</body>
</html> 