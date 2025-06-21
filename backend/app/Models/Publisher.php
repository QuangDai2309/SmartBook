<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = ['name', 'is_hidden'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
