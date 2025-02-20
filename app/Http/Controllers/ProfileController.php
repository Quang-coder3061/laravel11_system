<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserProfile;

class ProfileController extends Controller
{

    // Hiển thị form thêm thông tin
    public function create()
    {
        return view('profile.create'); // Trả về view create.blade.php
    }

    // Lưu thông tin
    public function store(Request $request)
    {
        $request->validate([
            'type_information' => 'required',
            'citizen_id' => 'required|unique:tbl_user_profiles',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required',
            'address' => 'required',
        ]);

        // Kiểm tra vai trò và chuyển hướng
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Sử dụng phương thức profile() đã được định nghĩa trong User
        // Tạo hoặc cập nhật profile để lưu thông tin
        $user->profile()->create($request->all());
        //return redirect()->route('profile.show');
        return redirect()->route('profile.show'); // Không cần truyền $id
    }

    // Hiển thị thông tin (chỉ người dùng đó xem)
    //public function show()
    //{
    //    $profile = Auth::user()->profile;
    //    return view('profile.show', compact('profile'));
    //}

    //public function show($id)
    //{
    //    $profile = UserProfile::findOrFail($id);
    //    if ($profile->user_id !== Auth::id()) {
    //        abort(403, 'Bạn không có quyền truy cập.');
    //    }
    //    return view('profile.show', compact('profile'));
    //}

    public function show()
    {
        // Lấy thông tin profile của người dùng hiện tại
        $profile = Auth::user()->profile;
        
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        return view('profile.show', compact('profile'));
    }
}
