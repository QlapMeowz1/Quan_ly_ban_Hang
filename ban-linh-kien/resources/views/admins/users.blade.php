@extends('layouts.admin')
@section('content')
<div class="container">
    <h2>Danh sách người dùng</h2>
    <form method="GET" action="{{ route('admin.users') }}" class="mb-3">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm tên hoặc email..." class="form-control d-inline-block" style="width:300px;">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <a href="{{ route('admin.user.orders', $user->id) }}" class="btn btn-info btn-sm">Xem đơn hàng</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection 