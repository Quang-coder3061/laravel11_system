<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role; // Đảm bảo import Role

class AuthController extends Controller
{

    //**Mục đích**: Hiển thị form đăng ký cho người dùng.
    public function showRegisterForm()
    {
        return view('auth.register'); // Trả về view đăng ký
    }

    //**Mục đích**: Xử lý dữ liệu từ form đăng ký và lưu thông tin người dùng vào database.
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => 0,
        ]);

        // Gán role mặc định (ví dụ: 'user')
        $user->roles()->attach(Role::where('name', 'user')->first());
        //return redirect('/login')->with('success', 'Đăng ký thành công!');
        return redirect()->route('login')->with('success', 'Đăng ký thành công. Bạn có thể đăng nhập.');
    }
    //**Mục đích**: Hiển thị form đăng nhập cho người dùng.
    public function showLoginForm()
    {
        return view('auth.login'); // Trả về view đăng nhập
    }

    //**Mục đích**: Xử lý dữ liệu từ form đăng nhập và xác thực người dùng, kiểm tra email và mật khẩu có hợp lệ hay không.
    /**
     * Xử lý đăng nhập và chuyển hướng theo vai trò.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Kiểm tra vai trò và chuyển hướng
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect('/admin');
                //return redirect()->intended('/admin');
            } elseif ($user->hasRole('manager')) {
                return redirect('/manager');
                //return redirect()->intended('/manager');
            } else {
                return redirect('/user');
                //return redirect()->intended('/user');
            }
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    //**Mục đích**: Đăng xuất người dùng và hủy bỏ session
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Bạn đã đăng xuất.');
    }
}
