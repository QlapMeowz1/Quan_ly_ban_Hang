@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Chi tiết Admin</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">ID:</th>
                            <td>{{ $admin->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên:</th>
                            <td>{{ $admin->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo:</th>
                            <td>{{ $admin->created_at ? $admin->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối:</th>
                            <td>{{ $admin->updated_at ? $admin->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </a>
                @if(auth()->id() !== $admin->id)
                <form action="{{ route('admin.admins.destroy', $admin->id) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa admin này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
