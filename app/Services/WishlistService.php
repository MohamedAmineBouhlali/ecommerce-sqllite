<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Models\Product;

class WishlistService
{
    public function getUserWishlist($user)
    {
        return Wishlist::with('product.category')
            ->where('user_id', $user->id)
            ->get();
    }

    public function addToWishlist($user, Product $product): Wishlist
    {
        return Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function removeFromWishlist($user, Product $product): bool
    {
        return Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->delete();
    }

    public function isInWishlist($user, Product $product): bool
    {
        return Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();
    }
}

