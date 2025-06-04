@extends('layouts.app')

@section('content')
    <h1>Danh sách Admin</h1>
    <a href="{{ route('admins.create') }}">Thêm admin mới</a>
    <table border="1">
        <tr>
            <th>ID</th><th>Tên</th><th>Email</th><th>Hành động</th>
        </tr>
        @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->id }}</td>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>
                <a href="{{ route('admins.show', $admin->id) }}">Xem</a> |
                <a href="{{ route('admins.edit', $admin->id) }}">Sửa</a> |
                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Xóa admin này?')">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection 