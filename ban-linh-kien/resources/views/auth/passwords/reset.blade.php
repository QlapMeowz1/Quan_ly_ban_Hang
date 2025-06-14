@extends('layouts.web')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 animate__animated animate__fadeInDown">
        <div class="card shadow border-0">
            <div class="card-body">
                <h2 class="mb-4 text-center text-primary">Đặt lại mật khẩu</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <label>Email:</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-control mb-2">
                    <label>Mật khẩu mới:</label>
                    <input type="password" name="password" required class="form-control mb-2">
                    <label>Xác nhận mật khẩu:</label>
                    <input type="password" name="password_confirmation" required class="form-control mb-2">
                    <button type="submit" class="btn btn-primary w-100">Đặt lại mật khẩu</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 