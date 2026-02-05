<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupOrder extends Model
{
    protected $fillable = [
        'owner_user_id','join_token','allow_guest','shipping_rule',
        'expires_at','status','order_id','confirmed_at'
    ];

    protected $casts = [
        'expires_at'   => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    // ===== Relationships =====
    public function members()     { return $this->hasMany(GroupOrderMember::class); }
    public function items()       { return $this->hasMany(GroupOrderItem::class); }
    public function settlements() { return $this->hasMany(GroupOrderSettlement::class); }
    public function payments()    { return $this->hasMany(GroupOrderPayment::class, 'group_order_id'); }
    public function owner()       { return $this->belongsTo(User::class, 'owner_user_id'); }

    // ===== Scopes =====
    public function scopeOpen($q) { return $q->where('status', 'open'); }

    // (tuỳ) link join cho FE (đổi domain nếu cần)
    public function getJoinUrlAttribute()
    {
        return 'http://localhost:3000/go/'.$this->join_token;
    }
}
