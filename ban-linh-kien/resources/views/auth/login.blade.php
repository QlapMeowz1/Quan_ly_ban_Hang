@extends('layouts.web')

@section('title', 'Đăng nhập')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 animate__animated animate__fadeInDown">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h2 class="mb-4 text-center text-primary">Đăng nhập</h2>
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <label>Email:</label>
                        <input type="email" name="email" required class="form-control mb-2">
                        <label>Mật khẩu:</label>
                        <input type="password" name="password" required class="form-control mb-2">
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                    <div class="mt-2 text-center">
                        <a href="{{ route('forgot-password') }}">Quên mật khẩu?</a>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 