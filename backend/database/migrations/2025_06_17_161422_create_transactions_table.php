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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến đơn hàng
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->nullOnDelete();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->string('transaction_code')->unique(); // Mã giao dịch (từ cổng thanh toán)
            $table->decimal('amount', 12, 2);             // Số tiền giao dịch
            $table->string('currency', 10)->default('VND'); // Loại tiền tệ
            $table->string('status')->default('pending'); // Trạng thái: pending, success, failed...
            $table->timestamp('paid_at')->nullable();     // Thời gian thanh toán

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
