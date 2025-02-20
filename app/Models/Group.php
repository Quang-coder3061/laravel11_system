<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, Notifiable;
    // Đảm bảo tên bảng đúng với migration
    protected $table = 'tbl_groups'; // Khai báo tên bảng
    //
    protected $fillable = ['name', 'parent_id', 'type_id', 'created_by', 'is_approved'];
    // Quan hệ với loại nhóm
    public function type()
    {
        return $this->belongsTo(GroupType::class, 'type_id');
    }

    // Quan hệ với người tạo nhóm
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Quan hệ với nhóm cha
    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    //phương thức để lấy tất cả các nhóm con đệ quy
    // Quan hệ với nhóm con    
    public function children()
    {
        return $this->hasMany(Group::class, 'parent_id');
    }
    // Quan hệ với các nhóm con
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Quan hệ với thành viên
    public function members()
    {
        return $this->belongsToMany(User::class, 'tbl_group_user')->withPivot('is_manager');
    }

    // Quan hệ với yêu cầu
    public function requests()
    {
        return $this->hasMany(GroupRequest::class);
    }
    //Quan hệ với GroupRequest
    public function groupRequests()
    {
        return $this->hasMany(GroupRequest::class, 'group_id');
    }
}
