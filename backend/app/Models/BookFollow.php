<?php
// app/Models/BookFollow.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookFollow extends Model
{
    public $timestamps = false; // Vì chỉ có created_at

    protected $fillable = [
        'book_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
