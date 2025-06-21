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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->nullOnDelete();

            $table->string('order_code')->unique();                // Mã đơn hàng
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                ->default('pending');                            // Trạng thái đơn

            $table->text('shipping_address');                      // Địa chỉ giao hàng
            $table->decimal('total_price', 10, 2);                 // Tổng tiền hàng
            $table->decimal('discount_total', 10, 2)->default(0);  // Tổng tiền giảm giá
            $table->decimal('shipping_fee', 10, 2)->default(0);    // Phí vận chuyển
            $table->decimal('total_amount', 10, 2);                // Tổng thanh toán (đã giảm và phí)

            $table->text('note')->nullable();                      // Ghi chú đơn hàng
            $table->timestamps();                                  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
