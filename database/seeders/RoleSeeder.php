<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạo các vai trò
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);

        // $adminRole = Role::create(['name' => 'admin']);
        // $managerRole = Role::create(['name' => 'manager']);
        // $userRole = Role::create(['name' => 'user']);

        // Gán vai trò cho người dùng
        // $adminUser = User::find(1); // Giả sử user có ID 1 là admin
        // $adminUser->roles()->attach($adminRole);
    }
}
