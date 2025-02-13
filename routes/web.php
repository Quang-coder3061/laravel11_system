<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;


// Public routes
Route::get('/', function () {
    return view('index');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Các route yêu cầu đăng nhập
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Admin routes
    // Đăng ký middleware trong bootstrap/app.php trước!
    Route::middleware('role:admin')->group(function () {
        //Route::get('/admin', [AdminController::class, 'index']);
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/approve-users', [AdminController::class, 'approveUsers'])->name('admin.approve-users');
        Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->name('admin.assign-role');
    });

    // Manager routes
    Route::middleware('role:manager')->group(function () {
        Route::get('/manager', [ManagerController::class, 'index'])->name('manager.index');
        Route::get('/manager/manager', [ManagerController::class, 'manager'])->name('manager.manager');
    });

    // User routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/manager', [UserController::class, 'manager'])->name('user.manager');
    });
});

# Route::get('/posts/create', function () {
#     // Chỉ người dùng có quyền 'create-post' mới truy cập được
#     return 'Bạn có quyền tạo bài viết!';
# })->middleware('permission:create-post');
