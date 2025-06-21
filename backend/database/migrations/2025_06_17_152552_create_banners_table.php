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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image'); // Đường dẫn ảnh
            $table->string('link')->nullable(); // Liên kết khi bấm vào banner
            $table->string('position')->nullable(); // Vị trí hiển thị: ví dụ 'homepage_top', 'sidebar', v.v.
            $table->integer('sort_order')->default(0); // Thứ tự ưu tiên hiển thị
            $table->boolean('is_hidden')->default(false); // Ẩn / hiện banner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
