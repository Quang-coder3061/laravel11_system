<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'tbl_user_profiles'; // Khai báo tên bảng
    protected $fillable = [
        'user_id',
        'type_information',
        'citizen_id',
        'date_of_birth',
        'gender',
        'phone',
        'address'
    ];


    /**
     * Quan hệ ngược lại với User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
