<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupJoinRequest extends Model
{
    // Đảm bảo tên bảng đúng với migration
    protected $table = 'tbl_group_join_requests';
    //Khai báo các trường
    protected $fillable = ['user_id', 'group_id', 'message', 'status', 'assigned_group_id'];

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Quan hệ với nhóm Group
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    
    public function assignedGroup()
    {
        return $this->belongsTo(Group::class, 'assigned_group_id');
    }
}
