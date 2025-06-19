<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_hidden',
        'order_index'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
