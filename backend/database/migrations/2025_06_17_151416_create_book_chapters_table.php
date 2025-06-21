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
        Schema::create('book_chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->string('title');                                    // Tiêu đề chương
            $table->string('slug')->unique();                           // Slug URL
            $table->text('content');                                    // Nội dung chương (HTML)
            $table->integer('chapter_number')->nullable();              // Số thứ tự chương
            $table->boolean('is_hidden')->default(true);                // Ẩn/hiện chương
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('cascade'); // Khi xóa sách thì xóa chương
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_chapters_');
    }
};
