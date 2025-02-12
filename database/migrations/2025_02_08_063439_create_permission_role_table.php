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
        Schema::create('tbl_permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('tbl_roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('tbl_permissions')->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_permission_role');
    }
};
