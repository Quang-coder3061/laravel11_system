<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    // Hiển thị form thêm thông tin
    public function create()
    {
        return view('profile.create');
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

        // Sử dụng phương thức profile() đã được định nghĩa trong User
        // Tạo hoặc cập nhật profile
        Auth::user()->profile()->create($request->all());

        return redirect()->route('profile.show');
    }

    // Hiển thị thông tin (chỉ người dùng đó xem)
    //public function show()
    //{
    //    $profile = Auth::user()->profile;
    //    return view('profile.show', compact('profile'));
    //}
    public function show($id)
    {
        $profile = UserProfile::findOrFail($id);
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        return view('profile.show', compact('profile'));
    }
}
