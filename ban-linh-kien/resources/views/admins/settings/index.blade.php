@extends('layouts.admin')
@section('title', 'Cài đặt website')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cài đặt thông tin website</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên website</label>
            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name']->setting_value ?? '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email liên hệ</label>
            <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email']->setting_value ?? '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="site_phone" class="form-control" value="{{ $settings['site_phone']->setting_value ?? '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ cửa hàng</label>
            <input type="text" name="site_address" class="form-control" value="{{ $settings['site_address']->setting_value ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </form>
</div>
@endsection 