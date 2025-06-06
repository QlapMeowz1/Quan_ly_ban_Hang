@extends('layouts.web')
@section('content')
<div class="container">
    <h3>Xác thực trước khi thanh toán</h3>
    <div class="alert alert-warning">Tính năng xác thực đã được gỡ bỏ.</div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Quay lại</a>
</div>
@endsection 