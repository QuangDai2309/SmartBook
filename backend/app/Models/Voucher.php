<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'max_discount',
        'min_order_value',
        'description',
        'quantity',
        'is_hidden',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
