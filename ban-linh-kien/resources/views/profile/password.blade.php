@extends('layouts.web')
@section('content')
<div class="container">
    <h3>Đổi mật khẩu</h3>
    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf
        <div class="mb-3">
            <label>Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nhập lại mật khẩu mới</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div>
@endsection
