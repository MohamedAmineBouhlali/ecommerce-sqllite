<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCartItems($user = null): array
    {
        $sessionId = Session::getId();
        
        if ($user) {
            $items = CartItem::with('product')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $items = CartItem::with('product')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();
        }

        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total,
            ];
        })->toArray();
    }

    public function addToCart(Product $product, int $quantity, $user = null): CartItem
    {
        $sessionId = Session::getId();
        
        $cartItem = CartItem::where('product_id', $product->id)
            ->when($user, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId)->whereNull('user_id');
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $user?->id,
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return $cartItem->load('product');
    }

    public function updateCartItem(CartItem $cartItem, int $quantity): CartItem
    {
        $cartItem->quantity = $quantity;
        $cartItem->save();
        return $cartItem->load('product');
    }

    public function removeFromCart(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }

    public function clearCart($user = null): void
    {
        $sessionId = Session::getId();
        
        CartItem::when($user, function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        }, function ($query) use ($sessionId) {
            return $query->where('session_id', $sessionId)->whereNull('user_id');
        })->delete();
    }

    public function getCartTotal($user = null): float
    {
        $items = $this->getCartItems($user);
        return collect($items)->sum('total');
    }

    public function getCartCount($user = null): int
    {
        $sessionId = Session::getId();
        
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        }
        
        return CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->sum('quantity');
    }

    public function syncCartToUser($user): void
    {
        $sessionId = Session::getId();
        
        $sessionItems = CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($sessionItems as $sessionItem) {
            $userItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($userItem) {
                $userItem->quantity += $sessionItem->quantity;
                $userItem->save();
                $sessionItem->delete();
            } else {
                $sessionItem->user_id = $user->id;
                $sessionItem->session_id = null;
                $sessionItem->save();
            }
        }
    }
}

