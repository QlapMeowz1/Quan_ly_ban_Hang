@extends('layouts.web')

@section('title', 'Đăng nhập')

@section('content')
    <h1>Đăng nhập</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label>Email:</label><input type="email" name="email" required class="form-control mb-2"><br>
        <label>Mật khẩu:</label><input type="password" name="password" required class="form-control mb-2"><br>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
    <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
@endsection 