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
        Schema::create('book_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');    // Người đánh giá
            $table->unsignedBigInteger('book_id');    // Sách được đánh giá
            $table->tinyInteger('rating');            // Điểm đánh giá (1-5)
            $table->text('comment')->nullable();      // Nội dung bình luận
            $table->unsignedBigInteger('parent_id')->nullable(); // Bình luận cha (nếu có)
            $table->boolean('is_hidden')->default(false); // Ẩn/hiện bình luận
            $table->timestamps();

            // Foreign keys
            $table->foreign('parent_id')->references('id')->on('book_ratings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_ratings');
    }
};
