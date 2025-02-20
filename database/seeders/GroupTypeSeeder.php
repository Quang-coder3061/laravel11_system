<?php

namespace Database\Seeders;

use App\Models\GroupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        GroupType::create(['name' => 'customer']);
        GroupType::create(['name' => 'supplier']);
        GroupType::create(['name' => 'staff']);
        GroupType::create(['name' => 'admin']);
        GroupType::create(['name' => 'child']); // Thêm loại "child"
        GroupType::create(['name' => 'sub-child']); // Thêm loại "sub-child" 
    }
}
