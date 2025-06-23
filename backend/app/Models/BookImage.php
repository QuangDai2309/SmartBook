<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    protected $fillable = [
        'book_id',
        'image_url',
        'alt_text',
        'is_main',
        'sort_order',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
