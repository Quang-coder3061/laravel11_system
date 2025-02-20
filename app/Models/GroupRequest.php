<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupRequest extends Model
{
    // Đảm bảo tên bảng đúng với migration
    protected $table = 'tbl_group_requests';
    //Khai báo các trường
    protected $fillable = [
        'group_id',
        'user_id',
        'type',
        'status',
        'is_resubmitted', // Thêm trường này để theo dõi yêu cầu đã được gửi lại
    ];

    // Quan hệ với nhóm Group
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
