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
        Schema::create('reading_progresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('last_chapter_id')->nullable();
            $table->integer('last_page_number')->nullable();      // ví dụ: 3
            $table->decimal('read_percent', 5, 2)->default(0);    // ví dụ: 42.75%
            $table->string('status')->default('reading');         // đọc, đã hoàn thành, tạm ngưng, v.v.
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('last_chapter_id')->references('id')->on('book_chapters')->onDelete('set null');

            // Unique để 1 người dùng chỉ có 1 tiến trình đọc cho mỗi sách
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_progress');
    }
};
