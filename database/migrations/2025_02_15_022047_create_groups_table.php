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
        Schema::create('tbl_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB'; //đảm bảo sử dụng InnoDB
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->foreignId('parent_id')->nullable()->constrained('tbl_groups')->onDelete('cascade');
            $table->unsignedBigInteger('type_id'); // Khóa ngoại đến tbl_group_types.id
            $table->foreign('type_id')->references('id')->on('tbl_group_types')->onDelete('cascade');
            //$table->unsignedBigInteger('type_id')->foreignId('type_id')->constrained('tbl_group_types')->onDelete('cascade');
            //$table->unsignedBigInteger('assigned_group_id')->foreignId('assigned_group_id')->nullable()->constrained('tbl_group_join_requests')->onDelete('cascade');
            $table->unsignedBigInteger('created_by'); // Khóa ngoại đến tbl_users.id
            $table->foreign('created_by')->references('id')->on('tbl_users')->onDelete('cascade');
            //$table->unsignedBigInteger('created_by')->foreignId('created_by')->constrained('tbl_users')->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_groups');
    }
};
