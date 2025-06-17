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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();                         // Mã giảm giá
            $table->decimal('discount_value', 10, 2);                 // Giá trị giảm (theo % hoặc số tiền)
            $table->enum('discount_type', ['percentage', 'fixed']);   // Kiểu giảm: phần trăm hoặc cố định
            $table->decimal('max_discount', 10, 2)->nullable();       // Số tiền giảm tối đa (nếu là %)
            $table->decimal('min_order_value', 10, 2)->default(0);    // Giá trị đơn hàng tối thiểu
            $table->string('description')->nullable();                // Mô tả ngắn
            $table->unsignedInteger('quantity')->default(0);          // Số lượng mã còn lại
            $table->boolean('is_hidden')->default(false);             // Ẩn/hiện voucher
            $table->dateTime('start_date');                           // Ngày bắt đầu
            $table->dateTime('end_date');                             // Ngày kết thúc
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
