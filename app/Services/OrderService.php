<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Services\CartService;
use App\Services\CouponService;
use App\Mail\OrderConfirmation;
use App\Mail\OrderStatusUpdate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private CartService $cartService,
        private CouponService $couponService
    ) {}

    public function createOrder(array $data, $user = null, array $cartItems = []): Order
    {
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        
        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = 0;
        $couponCode = null;

        if (isset($data['coupon_code']) && $data['coupon_code']) {
            $coupon = $this->couponService->validateCoupon($data['coupon_code'], $subtotal);
            if ($coupon) {
                $discount = $this->couponService->calculateDiscount($coupon, $subtotal);
                $couponCode = $coupon->code;
                $coupon->increment('used_count');
            }
        }

        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax - $discount;

        $order = Order::create([
            'user_id' => $user?->id,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $data['payment_method'] ?? 'cash',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'coupon_code' => $couponCode,
            'total' => $total,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'shipping_address' => $data['shipping_address'],
            'billing_address' => $data['billing_address'] ?? $data['shipping_address'],
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product']['name'],
                'product_sku' => $item['product']['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        $this->cartService->clearCart($user);

        // Send confirmation email
        if ($order->customer_email) {
            Mail::to($order->customer_email)->send(new OrderConfirmation($order));
        }

        return $order->load('items.product');
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        $order->status = $status;
        $order->save();

        // Send status update email
        if ($order->customer_email) {
            Mail::to($order->customer_email)->send(new OrderStatusUpdate($order, 'status'));
        }

        return $order;
    }

    public function updatePaymentStatus(Order $order, string $status): Order
    {
        $order->payment_status = $status;
        if ($status === 'paid') {
            $order->status = 'processing';
        }
        $order->save();

        // Send payment status update email
        if ($order->customer_email) {
            Mail::to($order->customer_email)->send(new OrderStatusUpdate($order, 'payment_status'));
        }

        return $order;
    }

    public function getUserOrders($user, int $perPage = 10)
    {
        return Order::with('items.product')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getAllOrders(array $filters = [], int $perPage = 15)
    {
        $query = Order::with(['user', 'items.product']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}

