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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến bảng carts
            $table->foreignId('cart_id')
                ->constrained('carts')
                ->cascadeOnDelete();

            // Khóa ngoại đến bảng books
            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            // Số lượng sách trong giỏ hàng
            $table->unsignedInteger('quantity')->default(1);

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
