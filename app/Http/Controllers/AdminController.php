<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    //**Mục đích**: Hiển thị trang dashboard của quản trị viên sau khi đăng nhập.
    public function index()
    {
        return view('admin.index'); // Trả về view dashboard của quản trị viên
    }
    //**Mục đích**: Hiển thị danh sách người dùng chờ phê duyệt và xử lý phê duyệt.
    public function approveUsers()
    {
        $users = User::with('roles')->get(); // Lấy danh sách người dùng chưa được phê duyệt
        $roles = Role::all(); // Lấy danh sách người dùng được phê duyệt
        return view('admin.approve-users', compact('users', 'roles')); // Trả về view phê duyệt người dùng
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:tbl_users,id',
            'role_id' => 'required|exists:tbl_roles,id',
        ]);

        $user = User::find($request->user_id);
        $user->roles()->sync([$request->role_id]);

        return back()->with('success', 'Gán quyền thành công!');
    }
}
