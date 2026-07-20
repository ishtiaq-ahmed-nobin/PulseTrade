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
    ];

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
