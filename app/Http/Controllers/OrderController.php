<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        $orders = $this->orderService->getUserOrders($request->user());

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = \App\Models\Order::with(['items.product', 'user'])
            ->where('id', $id)
            ->where(function ($query) use ($request) {
                if ($request->user() && !$request->user()->is_admin) {
                    $query->where('user_id', $request->user()->id);
                }
            })
            ->firstOrFail();

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }
}
