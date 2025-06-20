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
        // Nếu bảng ratings chưa tồn tại, tạo mới
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('book_id');
                $table->unsignedBigInteger('user_id');
                $table->decimal('rating_star', 2, 1); // Từ 0.5 đến 5.0
                $table->text('comment')->nullable();
                $table->timestamps();

                // Indexes
                $table->index(['book_id', 'user_id']);
                $table->index('book_id');
                $table->index('user_id');
                $table->index('rating_star');

                // Foreign keys
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                // Unique constraint - một user chỉ có thể rating một sách một lần
                $table->unique(['book_id', 'user_id']);
            });
        } else {
            // Nếu bảng đã tồn tại, chỉ thêm cột comment nếu chưa có
            Schema::table('ratings', function (Blueprint $table) {
                if (!Schema::hasColumn('ratings', 'comment')) {
                    $table->text('comment')->nullable()->after('rating_star');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};