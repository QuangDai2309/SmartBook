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
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Tên danh mục
            $table->string('slug')->unique();                // Đường dẫn thân thiện
            $table->text('description')->nullable();         // Mô tả ngắn
            $table->integer('order_index')->default(0);      // Thứ tự hiển thị
            $table->timestamps();                            // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
