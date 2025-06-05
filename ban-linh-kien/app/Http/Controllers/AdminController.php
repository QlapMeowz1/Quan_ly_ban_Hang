<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Hiển thị danh sách admin
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admins.index', compact('admins'));
    }

    // Hiển thị form tạo admin mới (demo trả về text)
    public function create()
    {
        return view('admins.create');
    }

    // Lưu admin mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'admin',
        ]);
        return redirect()->route('admins.index')->with('success', 'Tạo admin thành công!');
    }

    // Hiển thị thông tin 1 admin
    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    // Hiển thị form sửa admin (demo trả về text)
    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admins.edit', compact('admin'));
    }

    // Cập nhật thông tin admin
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $admin->update($validated);
        if ($request->filled('password')) {
            $admin->password = $request->password;
            $admin->save();
        }
        return redirect()->route('admins.index')->with('success', 'Cập nhật admin thành công!');
    }

    // Xóa admin
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'Đã xóa admin!');
    }

    // Hiển thị danh sách user và tìm kiếm
    public function users(Request $request)
    {
        $query = \App\Models\User::query();
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%");
            });
        }
        $users = $query->orderByDesc('created_at')->paginate(20);
        return view('admins.users', compact('users'));
    }

    // Xem đơn hàng của 1 user
    public function userOrders($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $orders = $user->customer ? $user->customer->orders()->orderByDesc('created_at')->get() : [];
        return view('admins.user_orders', compact('user', 'orders'));
    }
}
