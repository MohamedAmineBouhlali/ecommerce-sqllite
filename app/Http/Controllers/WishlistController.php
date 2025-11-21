<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService
    ) {}

    public function index(Request $request)
    {
        $wishlist = $this->wishlistService->getUserWishlist($request->user());

        return Inertia::render('Wishlist/Index', [
            'wishlistItems' => $wishlist,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $this->wishlistService->addToWishlist($request->user(), $product);

        return back()->with('message', 'Product added to wishlist.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->wishlistService->removeFromWishlist($request->user(), $product);

        return back()->with('message', 'Product removed from wishlist.');
    }
}
