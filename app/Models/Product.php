<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'image',
        'images',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    /**
     * Get the final active price (sale price if exists, otherwise regular price).
     */
    public function getFinalPriceAttribute()
    {
        return $this->sale_price !== null ? $this->sale_price : $this->price;
    }

    /**
     * Check if product is discounted.
     */
    public function hasDiscount(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the image URL — handles both external URLs (Unsplash) and local storage paths.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Get gallery image URLs — handles both external URLs and local storage paths.
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }

        return array_map(function ($img) {
            if (str_starts_with($img, 'http')) {
                return $img;
            }
            return asset('storage/' . $img);
        }, $this->images);
    }

    /**
     * Get the average rating of reviews.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
