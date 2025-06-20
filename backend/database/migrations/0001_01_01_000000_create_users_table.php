<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Tên người dùng
            $table->string('email')->unique();               // Email duy nhất
            $table->timestamp('email_verified_at')->nullable(); // Thời gian xác thực email
            $table->string('password');                      // Mật khẩu đã mã hoá
            $table->string('avatar')->nullable();            // Ảnh đại diện người dùng
            $table->string('phone')->nullable();             // Số điện thoại
            $table->string('address')->nullable();           // Địa chỉ
            $table->enum('role', ['user', 'admin'])->default('user'); // Vai trò
            $table->boolean('is_hidden')->default(true);     // Kích hoạt tài khoản
            $table->rememberToken();                         // Token cho chức năng "ghi nhớ đăng nhập"
            $table->timestamps();                            // created_at & updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
