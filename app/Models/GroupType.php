<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    // Đảm bảo tên bảng đúng với migration
    protected $table = 'tbl_group_types';// Khai báo tên bảng
    //Khai báo các trường
    protected $fillable = ['name'];
}
