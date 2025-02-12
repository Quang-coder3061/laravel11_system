<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role; 

class UserController extends Controller
{
    //**Mục đích**: Hiển thị trang dashboard của người dùng sau khi đăng nhập.   
    public function index()
    {
        return view('user.index'); // Trả về view dashboard của người dùng
    }

    //**Mục đích**: Hiển thị trang quản lý dữ liệu của người dùng.
    public function manager()
    {
        return view('user.manager'); // Trả về view quản lý của người dùng
    }
}
