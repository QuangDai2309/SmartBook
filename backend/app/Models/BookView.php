<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookView extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'view_count',
        'last_viewed_at',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
