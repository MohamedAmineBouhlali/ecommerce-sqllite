<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        $cartItems = $this->cartService->getCartItems($request->user());
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->getCartTotal($request->user());
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $cartItems = $this->cartService->getCartItems($request->user());
        
        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $order = $this->orderService->createOrder(
            $request->validated(),
            $request->user(),
            $cartItems
        );

        return redirect()->route('orders.show', $order->id)
            ->with('message', 'Order placed successfully!');
    }
}
