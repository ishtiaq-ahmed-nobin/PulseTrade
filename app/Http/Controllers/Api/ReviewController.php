<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Product $product): JsonResponse
    {
        $reviews = $product->reviews()->with('user')->latest()->get();

        return response()->json([
            'reviews' => $reviews,
            'average_rating' => round((float) $product->averageRating(), 1),
            'review_count' => $reviews->count(),
        ]);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $hasPurchased = $product->orderItems()
            ->whereHas('order', fn ($q) => $q->where('user_id', $request->user()->id))
            ->exists();

        if (! $hasPurchased) {
            return response()->json([
                'errors' => ['comment' => ['You can only review products you have purchased.']],
            ], 422);
        }

        $review = Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        $review->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.',
            'review' => $review,
            'average_rating' => round((float) $product->averageRating(), 1),
        ], 201);
    }
}
