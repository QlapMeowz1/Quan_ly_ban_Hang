@extends('layouts.app')

@section('content')
    <h1>Sửa admin</h1>
    <form action="{{ route('admins.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Tên:</label><input type="text" name="name" value="{{ $admin->name }}" required><br>
        <label>Email:</label><input type="email" name="email" value="{{ $admin->email }}" required><br>
        <label>Mật khẩu mới (nếu đổi):</label><input type="password" name="password"><br>
        <button type="submit">Cập nhật</button>
    </form>
    <a href="{{ route('admins.index') }}">Quay lại</a>
@endsection 