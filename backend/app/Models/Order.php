<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_address',
        'shipping_phone',
        'payment_method',
        'payment_status',
        'coupon_code',
        'discount_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    protected $appends = [
        'subtotal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }
}
