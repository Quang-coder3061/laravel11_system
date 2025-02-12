<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Kiểm tra và tạo roles nếu chưa tồn tại
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Kiểm tra và tạo permissions nếu chưa tồn tại
        $createPost = Permission::firstOrCreate([
            'slug' => 'create-post',
            'description' => 'Create a post',
        ]);
        $editPost = Permission::firstOrCreate([
            'slug' => 'edit-post',
            'description' => 'Edit a post',
        ]);
        $editPost = Permission::firstOrCreate([
            'slug' => 'delete-post',
            'description' => 'Delete a post',
        ]);
        // Gán permission cho role (nếu chưa tồn tại)
        if (!$adminRole->permissions->contains($createPost->id)) {
            $adminRole->permissions()->attach($createPost->id);
        }
        if (!$adminRole->permissions->contains($editPost->id)) {
            $adminRole->permissions()->attach($editPost->id);
        }
        if (!$userRole->permissions->contains($createPost->id)) {
            $userRole->permissions()->attach($createPost->id);
        }
    }
}
