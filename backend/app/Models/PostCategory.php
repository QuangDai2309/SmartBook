<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'categories'; // Chỉ rõ bảng liên kết

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
