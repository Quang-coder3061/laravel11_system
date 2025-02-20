<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_group_user', function (Blueprint $table) {
            //$table->foreignId('group_id')->constrained('tbl_groups');
            // Thêm onDelete('cascade') cho khóa ngoại group_id
            $table->foreignId('group_id')
                ->constrained('tbl_groups')
                ->onDelete('cascade');
            //$table->foreignId('user_id')->constrained('tbl_users');
            // Thêm onDelete('cascade') cho khóa ngoại user_id
            $table->foreignId('user_id')
                ->constrained('tbl_users')
                ->onDelete('cascade');
            $table->boolean('is_manager')->default(false);
            $table->primary(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_group_user');
    }
};
