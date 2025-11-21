<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index(Request $request)
    {
        $cartItems = $this->cartService->getCartItems($request->user());
        $total = $this->cartService->getCartTotal($request->user());
        $count = $this->cartService->getCartCount($request->user());

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'count' => $count,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $this->cartService->addToCart($product, $request->quantity, $request->user());

        return back()->with('message', 'Product added to cart successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = \App\Models\CartItem::findOrFail($id);
        $this->cartService->updateCartItem($cartItem, $request->quantity);

        return back()->with('message', 'Cart updated successfully.');
    }

    public function destroy($id)
    {
        $cartItem = \App\Models\CartItem::findOrFail($id);
        $this->cartService->removeFromCart($cartItem);

        return back()->with('message', 'Item removed from cart.');
    }

    public function count(Request $request)
    {
        return response()->json([
            'count' => $this->cartService->getCartCount($request->user()),
        ]);
    }
}
