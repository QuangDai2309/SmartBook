<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id', 
        'user_id', 
        'rating_star', 
        'comment'
    ];

    protected $casts = [
        'rating_star' => 'decimal:1',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope để lọc theo rating
    public function scopeByRatingRange($query, $min, $max)
    {
        return $query->whereBetween('rating_star', [$min, $max]);
    }

    // Scope để lọc theo rating cụ thể
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating_star', $rating);
    }

    // Scope để lọc theo mức sao (1-5) theo kiểu Google
    public function scopeByStarLevel($query, $starLevel)
    {
        switch ($starLevel) {
            case 5:
                return $query->where('rating_star', '>=', 4.5);
            case 4:
                return $query->where('rating_star', '>=', 3.5)
                           ->where('rating_star', '<', 4.5);
            case 3:
                return $query->where('rating_star', '>=', 2.5)
                           ->where('rating_star', '<', 3.5);
            case 2:
                return $query->where('rating_star', '>=', 1.5)
                           ->where('rating_star', '<', 2.5);
            case 1:
                return $query->where('rating_star', '<', 1.5);
            default:
                return $query;
        }
    }

    // Accessor để format rating display
    public function getFormattedRatingAttribute()
    {
        return $this->rating_star == floor($this->rating_star) 
            ? (int)$this->rating_star 
            : $this->rating_star;
    }

    // Accessor để hiển thị thời gian relative
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}