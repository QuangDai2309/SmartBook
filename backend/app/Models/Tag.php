<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_hidden',
    ];

    // Quan hệ nhiều-nhiều với bảng books
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_tags');
    }
}
