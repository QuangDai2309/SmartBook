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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến bài viết
            $table->foreignId('post_id')
                ->constrained('posts')
                ->onDelete('cascade');

            // Khóa ngoại đến người dùng
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Tự khóa để hỗ trợ trả lời (bình luận con)
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('post_comments')
                ->onDelete('cascade');

            $table->text('content');                     // Nội dung bình luận
            $table->boolean('is_hidden')->default(false); // Ẩn bình luận vi phạm
            $table->timestamps();                        // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
