<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Product;

class ReviewService
{
    public function createReview($user, Product $product, array $data): Review
    {
        return Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'is_approved' => false, // Admin approval required
        ]);
    }

    public function approveReview(Review $review): Review
    {
        $review->is_approved = true;
        $review->save();
        return $review;
    }

    public function deleteReview(Review $review): bool
    {
        return $review->delete();
    }

    public function getProductReviews(Product $product, bool $approvedOnly = true)
    {
        $query = Review::with('user')
            ->where('product_id', $product->id);

        if ($approvedOnly) {
            $query->where('is_approved', true);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}

