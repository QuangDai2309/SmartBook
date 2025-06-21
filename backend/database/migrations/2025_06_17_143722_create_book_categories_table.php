<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->string('name');                     // Tên danh mục
            $table->string('slug')->unique();           // Slug cho URL
            $table->text('description')->nullable();    // Mô tả
            $table->boolean('is_hidden')->default(true); // Trạng thái hiển thị
            $table->unsignedInteger('order_index')->default(0); // STT hiển thị
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_categories');
    }
};
