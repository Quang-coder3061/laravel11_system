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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            //            $table->string('email_verified_at')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Thêm nullable()
            $table->string('password');
            //            $table->string('remember_token');
            $table->rememberToken();
            $table->string('nfc_uid')->nullable(); // Cho NFC
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};
