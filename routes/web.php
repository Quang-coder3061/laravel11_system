<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Middleware\CheckRole;


// Public routes
Route::get('/', function () {
    return view('index');
});

//


//

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//test-view
Route::get('/test-view', function () {
    return view('profile.edit11');
});


// Protected routes
Route::middleware('auth')->group(function () {
    // Các route yêu cầu đăng nhập
    // Sử dụng middleware auth để yêu cầu đăng nhập
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route cho người dùng
    Route::get('/groups/create-request', [GroupController::class, 'createRequest'])->name('groups.create-request');
    Route::post('/groups/store-request', [GroupController::class, 'storeRequest'])->name('groups.store-request');
    Route::get('/groups/requests', [GroupController::class, 'index'])->name('groups.requests');
    // Route nhóm cho người dùng
    Route::get('/groups/create-child', [GroupController::class, 'createChild'])->name('groups.create-child');
    Route::post('/groups/store-child', [GroupController::class, 'storeChild'])->name('groups.store-child');
    // Route nhóm nhỏ cho người dùng
    Route::get('/groups/create-sub-child', [GroupController::class, 'createSubChild'])->name('groups.create-sub-child');
    Route::post('/groups/store-sub-child', [GroupController::class, 'storeSubChild'])->name('groups.store-sub-child');

    // Sửa/Xóa Yêu Cầu
    Route::get('/groups/edit-request/{id}', [GroupController::class, 'editRequest'])->name('groups.edit-request');
    Route::put('/groups/update-request/{id}', [GroupController::class, 'updateRequest'])->name('groups.update-request');
    Route::delete('/groups/delete-request/{id}', [GroupController::class, 'deleteRequest'])->name('groups.delete-request');
    // User gửi yêu cầu
    Route::post('/groups/{group}/join', [GroupController::class, 'sendJoinRequest'])->name('groups.join');
    // Quản lý yêu cầu
    Route::get('/groups/join-requests', [GroupController::class, 'manageJoinRequests'])->name('groups.manage-join-requests');
    Route::post('/groups/join-requests/{request}/approve', [GroupController::class, 'approveJoinRequest'])->name('groups.approve-join-request');
    Route::post('/groups/join-requests/{request}/reject', [GroupController::class, 'rejectJoinRequest'])->name('groups.reject-join-request');
    Route::post('/groups/join-requests/{request}/assign', [GroupController::class, 'assignToSubGroup'])->name('groups.assign-to-subgroup');
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

// Route cho admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/pending-requests', [GroupController::class, 'pendingRequests'])->name('admin.pending-requests');
    Route::post('/approve-request/{requestId}', [GroupController::class, 'approveRequest'])->name('admin.approve-request');
    Route::post('/admin/approve-request/{requestId}', [GroupController::class, 'approveRequest'])->name('admin.approve-request');
    Route::post('/admin/reject-request/{requestId}', [GroupController::class, 'rejectRequest'])->name('admin.reject-request');
});

# Route::get('/posts/create', function () {
#     // Chỉ người dùng có quyền 'create-post' mới truy cập được
#     return 'Bạn có quyền tạo bài viết!';
# })->middleware('permission:create-post');
