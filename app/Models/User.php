<?php

namespace App\Models;

// import Group ở đầu file
use App\Models\Group;
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
        //return $this->hasOne(UserProfile::class);
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

    public function groupRequests()
    {
        return $this->hasMany(GroupRequest::class, 'user_id');
    }

    public function groups()
    {
        // Quan hệ một-nhiều: Một User có nhiều Group
        return $this->hasMany(Group::class, 'created_by');
    }
    
    // Quan hệ để xác định user quản lý nhóm
    public function managedGroups()
    {
        return $this->belongsToMany(Group::class, 'tbl_group_user', 'user_id', 'group_id')
            ->wherePivot('is_manager', true);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Nếu không sử dụng xác thực email, hãy bỏ qua trường này
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
