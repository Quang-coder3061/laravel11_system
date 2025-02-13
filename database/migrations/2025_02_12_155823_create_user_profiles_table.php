<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type_information'); //Loại thông tin
            $table->foreignId('user_id')->constrained('tbl_users')->onDelete('cascade');// Liên kết với users
            $table->string('citizen_id')->unique(); // Số CCCD
            $table->date('date_of_birth'); // Ngày sinh
            $table->string('gender'); // Giới tính
            $table->string('phone'); // Số điện thoại
            $table->text('address'); // Địa chỉ
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_profiles');
    }
};
