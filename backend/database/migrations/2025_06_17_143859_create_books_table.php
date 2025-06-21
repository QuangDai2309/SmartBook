<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_code')->unique();                  // Mã sách
            $table->string('title');                                // Tên sách
            $table->string('slug')->unique();                       // Slug URL
            $table->text('description')->nullable();                // Mô tả ngắn
            $table->unsignedBigInteger('author_id');                // Tác giả
            $table->unsignedBigInteger('publisher_id');             // Nhà xuất bản
            $table->unsignedBigInteger('category_id')->nullable();  // Danh mục chính
            $table->decimal('price', 10, 2)->default(0);            // Giá bán
            $table->decimal('discount_price', 10, 2)->nullable();   // Giá khuyến mãi
            $table->enum('book_type', ['physical', 'ebook']);       // Loại sách
            $table->unsignedInteger('stock')->default(0);           // Tồn kho
            $table->boolean('is_featured')->default(false);         // Sách nổi bật
            $table->year('published_year')->nullable();             // Năm xuất bản
            $table->string('language')->nullable();                 // Ngôn ngữ
            $table->integer('page_count')->nullable();              // Số trang
            $table->float('weight')->nullable();                    // Trọng lượng
            $table->string('dimensions')->nullable();               // Kích thước (dài x rộng x cao)
            $table->boolean('is_hidden')->default(true);            // Ẩn/hiện sách
            $table->enum('status', ['available', 'coming_soon', 'unavailable'])->default('available'); // Trạng thái
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('book_categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
