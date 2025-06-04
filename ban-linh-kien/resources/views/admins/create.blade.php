@extends('layouts.app')

@section('content')
    <h1>Thêm admin mới</h1>
    <form action="{{ route('admins.store') }}" method="POST">
        @csrf
        <label>Tên:</label><input type="text" name="name" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Mật khẩu:</label><input type="password" name="password" required><br>
        <button type="submit">Lưu</button>
    </form>
    <a href="{{ route('admins.index') }}">Quay lại</a>
@endsection 