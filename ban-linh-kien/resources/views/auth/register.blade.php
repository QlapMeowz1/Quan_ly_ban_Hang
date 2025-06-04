@extends('layouts.web')

@section('title', 'Đăng ký')

@section('content')
    <h1>Đăng ký tài khoản</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label>Tên:</label><input type="text" name="name" required class="form-control mb-2"><br>
        <label>Email:</label><input type="email" name="email" required class="form-control mb-2"><br>
        <label>Mật khẩu:</label><input type="password" name="password" required class="form-control mb-2"><br>
        <label>Nhập lại mật khẩu:</label><input type="password" name="password_confirmation" required class="form-control mb-2"><br>
        <button type="submit" class="btn btn-success">Đăng ký</button>
    </form>
    <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
@endsection 