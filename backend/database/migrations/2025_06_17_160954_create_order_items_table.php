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
         Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Khoá ngoại đến đơn hàng
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Khoá ngoại đến sách
            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();

            $table->unsignedInteger('quantity');                  // Số lượng sách
            $table->decimal('price', 10, 2);                      // Giá tại thời điểm mua
            $table->decimal('total_price', 10, 2);                // Tổng = price * quantity

            $table->text('note')->nullable();                     // Ghi chú thêm (nếu có)

            $table->timestamps();                                 // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
