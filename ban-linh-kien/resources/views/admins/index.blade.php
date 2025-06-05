@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Danh sách admin</h2>
    <a href="{{ route('admins.create') }}" class="btn btn-primary mb-3">Thêm admin mới</a>
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
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at }}</td>
                <td>
                    <a href="{{ route('admins.show', $admin->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 