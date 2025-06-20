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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            $table->string('name');                    // Tên phương thức thanh toán (Ví dụ: VNPay, COD, Momo)
            $table->text('description')->nullable();   // Mô tả thêm nếu có
            $table->boolean('is_hidden')->default(false); // Đánh dấu ẩn/hiện

            $table->timestamps();                      // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
