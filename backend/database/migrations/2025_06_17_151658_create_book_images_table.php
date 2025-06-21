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
        Schema::create('book_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id'); // Khóa ngoại đến bảng books
            $table->string('image_url');           // Đường dẫn ảnh
            $table->string('alt_text')->nullable(); // Văn bản thay thế
            $table->boolean('is_main')->default(false); // Ảnh chính của sách
            $table->integer('sort_order')->default(0);  // Thứ tự sắp xếp
            $table->timestamps();

            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onDelete('cascade'); // Xóa sách thì xóa ảnh liên quan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_images');
    }
};
