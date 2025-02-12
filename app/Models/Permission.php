<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Permission extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_permissions';

    protected $fillable = [
        'slug',
        'description',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tbl_permission_role');
    }
}
