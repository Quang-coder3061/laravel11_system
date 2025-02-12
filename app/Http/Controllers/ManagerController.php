<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role; 

class ManagerController extends Controller
{
    //**Mục đích**: Hiển thị trang dashboard của quản lý chuyên môn sau khi đăng nhập.
    public function index()
    {
        return view('manager.index'); // Trả về view dashboard của quản lý chuyên môn
    }
    //**Mục đích**: Hiển thị trang quản lý dữ liệu của quản lý chuyên môn.
    public function manager()
    {
        return view('manager.manager'); // Trả về view quản lý của quản lý chuyên môn
    }
}
