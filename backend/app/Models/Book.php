<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_code',
        'title',
        'slug',
        'description',
        'author_id',
        'publisher_id',
        'category_id',
        'price',
        'discount_price',
        'book_type',
        'stock',
        'is_featured',
        'published_year',
        'language',
        'page_count',
        'weight',
        'dimensions',
        'is_hidden',
        'status',
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
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'book_tags');
    }
}
