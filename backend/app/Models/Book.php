<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

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
        'likes',
    ];
}
