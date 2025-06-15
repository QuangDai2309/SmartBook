<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'author_id',
        'publisher_id',
        'category_id',
        'is_physical',
        'price',
        'stock',
        'views',
        'likes'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
