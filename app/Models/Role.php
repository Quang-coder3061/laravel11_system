<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Notifiable;
    // Đảm bảo tên bảng đúng với migration
    protected $table = 'tbl_roles'; // Đảm bảo tên bảng đúng
    protected $fillable = [
        'name',
    ];

    // Quan hệ nhiều-nhiều với bảng users
    // Quan hệ với bảng users (nếu cần)
    public function users()
    {
        return $this->belongsToMany(User::class, 'tbl_role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'tbl_permission_role');
    }
}
