<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    protected $table = 'tbl_users';
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
        return $this->belongsToMany(Role::class, 'tbl_role_user');
    }

    /**
     * Kiểm tra người dùng có vai trò cụ thể hay không.
     *
     * @param string $role Tên vai trò cần kiểm tra (ví dụ: 'admin', 'manager', 'user').
     * @return bool
     */

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
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
