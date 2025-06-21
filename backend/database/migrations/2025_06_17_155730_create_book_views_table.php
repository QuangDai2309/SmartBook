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
        Schema::create('book_views', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến bảng books
            $table->foreignId('book_id')
                ->constrained('books')
                ->onDelete('cascade');

            // Khóa ngoại đến bảng users
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->unsignedInteger('view_count')->default(1); // Số lượt xem
            $table->timestamp('last_viewed_at')->nullable();   // Thời điểm xem gần nhất

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_views');
    }
};
