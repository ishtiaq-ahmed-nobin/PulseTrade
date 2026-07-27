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

    public const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80';

    /**
     * Resolve an image path/URL to a full URL.
     */
    private function resolveImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return asset('storage/' . $path);
    }

    /**
     * Get the image URL — returns stored image or Unsplash fallback.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->resolveImageUrl($this->image) ?? self::FALLBACK_IMAGE;
    }

    public static function fallbackImageUrl(): string
    {
        return self::FALLBACK_IMAGE;
    }

    public function getGalleryImagesAttribute(): array
    {
        $images = $this->images;

        if (is_array($images)) {
            return array_values(array_filter($images));
        }

        if (is_string($images) && filled($images)) {
            $decoded = json_decode($images, true);

            if (is_array($decoded)) {
                return array_values(array_filter($decoded));
            }

            return [$images];
        }

        return [];
    }

    /**
     * Get gallery image URLs — returns stored gallery or falls back to main image.
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (count($this->gallery_images) > 0) {
            return array_map(fn($img) => $this->resolveImageUrl($img) ?? self::FALLBACK_IMAGE, $this->gallery_images);
        }

        return [$this->image_url];
    }

    /**
     * Get the average rating of reviews.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
