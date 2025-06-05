@extends('layouts.web')

@section('content')
    <h1>Chi tiết Admin</h1>
    <p><strong>ID:</strong> {{ $admin->id }}</p>
    <p><strong>Tên:</strong> {{ $admin->name }}</p>
    <p><strong>Email:</strong> {{ $admin->email }}</p>
    <a href="{{ route('admins.index') }}">Quay lại</a>
@endsection 