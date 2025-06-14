<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('book_follows', function (Blueprint $table) {
            $table->id(); // Mã theo dõi
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['book_id', 'user_id']); // Tránh follow trùng
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_follows');
    }
}
