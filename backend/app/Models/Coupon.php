<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'usage_limit',
        'used_count',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_code', 'code');
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        return true;
    }

    public function discountAmount(float $amount): float
    {
        if ($this->type === 'percentage') {
            return round($amount * $this->value / 100, 2);
        }

        return min($this->value, $amount);
    }

    public function applyDiscount(float $amount): float
    {
        return max(0, $amount - $this->discountAmount($amount));
    }
}
