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

    protected $appends = [
        'image_url',
        'gallery_urls',
        'final_price',
        'has_discount',
        'stock_status',
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

    public function getHasDiscountAttribute(): bool
    {
        return $this->hasDiscount();
    }

    /**
     * Stock badge helper: in_stock | low_stock | out_of_stock.
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        }

        return $this->stock < 5 ? 'low_stock' : 'in_stock';
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
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=600&q=80';

    private static array $keywordMap = [
        'laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80',
        'desktop' => 'https://images.unsplash.com/photo-1593642702743-b2a86983193b?auto=format&fit=crop&w=600&q=80',
        'phone' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80',
        'tablet' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
        'earbuds' => 'https://images.unsplash.com/photo-1590658268037-6bf12f032f55?auto=format&fit=crop&w=600&q=80',
        'headphones' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
        'speaker' => 'https://images.unsplash.com/photo-1558089687-f282ffcbc126?auto=format&fit=crop&w=600&q=80',
        'watch' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
        'band' => 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?auto=format&fit=crop&w=600&q=80',
        'charger' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80',
        'hub' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80',
        'shoes' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80',
        'bag' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80',
        'mug' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
    ];

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

    public function getDemoImageUrlAttribute(): string
    {
        $resolved = $this->resolveImageUrl($this->image);

        if ($resolved) {
            return $resolved;
        }

        $keyword = match (true) {
            str_contains($this->name, 'Book') || str_contains($this->name, 'Laptop') => 'laptop',
            str_contains($this->name, 'Desk') || str_contains($this->name, 'Mini') => 'desktop',
            str_contains($this->name, 'Phone') => 'phone',
            str_contains($this->name, 'Tab') || str_contains($this->name, 'Pad') => 'tablet',
            str_contains($this->name, 'Buds') => 'earbuds',
            str_contains($this->name, 'Max') || str_contains($this->name, 'Headphone') || str_contains($this->name, 'Audio') => 'headphones',
            str_contains($this->name, 'Sound') || str_contains($this->name, 'Speaker') => 'speaker',
            str_contains($this->name, 'Watch') => 'watch',
            str_contains($this->name, 'Band') || str_contains($this->name, 'Fit') => 'band',
            str_contains($this->name, 'Charg') => 'charger',
            str_contains($this->name, 'Hub') => 'hub',
            str_contains($this->name, 'Shoe') || str_contains($this->name, 'Sneaker') || str_contains($this->name, 'Boot') => 'shoes',
            str_contains($this->name, 'Bag') || str_contains($this->name, 'Backpack') || str_contains($this->name, 'Luggage') => 'bag',
            str_contains($this->name, 'Mug') || str_contains($this->name, 'Cup') || str_contains($this->name, 'Ceramic') => 'mug',
            default => null,
        };

        if ($keyword && isset(self::$keywordMap[$keyword])) {
            return self::$keywordMap[$keyword];
        }

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
