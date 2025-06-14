@extends('layouts.web')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 animate__animated animate__fadeInDown">
        <div class="card shadow border-0">
            <div class="card-body">
                <h2 class="mb-4 text-center text-primary">Quên mật khẩu</h2>
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('forgot-password.post') }}">
                    @csrf
                    <label>Email:</label>
                    <input type="email" name="email" required class="form-control mb-2">
                    <button type="submit" class="btn btn-primary w-100">Gửi liên kết đặt lại mật khẩu</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 