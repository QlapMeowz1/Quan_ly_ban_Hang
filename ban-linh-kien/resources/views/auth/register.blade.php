@extends('layouts.web')

@section('title', 'Đăng ký')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 animate__animated animate__fadeInDown">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h2 class="mb-4 text-center text-success">Đăng ký tài khoản</h2>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <label>Tên:</label>
                        <input type="text" name="name" required class="form-control mb-2">
                        <label>Email:</label>
                        <input type="email" name="email" required class="form-control mb-2">
                        <label>Mật khẩu:</label>
                        <input type="password" name="password" required class="form-control mb-2">
                        <label>Nhập lại mật khẩu:</label>
                        <input type="password" name="password_confirmation" required class="form-control mb-2">
                        <button type="submit" class="btn btn-success w-100">Đăng ký</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 