<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserProfile; // Thêm dòng này

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $roles
 *
 * @method bool hasRole(string $role)
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_users'; // Khai báo tên bảng
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nfc_uid', // Cho NFC
        'is_approved', //Phê duyệt
    ];

    // Quan hệ nhiều-nhiều với bảng roles
    public function roles()
    {
        //return $this->belongsToMany(Role::class, 'tbl_role_user');
        return $this->belongsToMany(Role::class, 'tbl_role_user', 'user_id', 'role_id');
    }

    /**
     * Kiểm tra người dùng có vai trò cụ thể hay không.
     *
     * @param string $role Tên vai trò cần kiểm tra (ví dụ: 'admin', 'manager', 'user').
     * @return bool
     */

    // Phương thức kiểm tra quyền
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    // Quan hệ 1-1 với UserProfile (đã đổi tên bảng)
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    public function hasPermission($slug)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('slug', $slug)) {
                return true;
            }
        }
        return false;
    }
}
