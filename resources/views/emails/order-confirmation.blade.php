<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Order Confirmation') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .order-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-item {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .total {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #667eea;
            padding-top: 15px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('Order Confirmation') }}</h1>
        <p>{{ __('Thank you for your order!') }}</p>
    </div>
    
    <div class="content">
        <div class="order-info">
            <h2>{{ __('Order Details') }}</h2>
            <p><strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}</p>
            <p><strong>{{ __('Order Date') }}:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
            <p><strong>{{ __('Status') }}:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>{{ __('Payment Status') }}:</strong> {{ ucfirst($order->payment_status) }}</p>
        </div>

        <div class="order-info">
            <h2>{{ __('Shipping Information') }}</h2>
            <p><strong>{{ __('Customer Name') }}:</strong> {{ $order->customer_name }}</p>
            <p><strong>{{ __('Email') }}:</strong> {{ $order->customer_email }}</p>
            @if($order->customer_phone)
            <p><strong>{{ __('Phone') }}:</strong> {{ $order->customer_phone }}</p>
            @endif
            <p><strong>{{ __('Shipping Address') }}:</strong><br>{{ $order->shipping_address }}</p>
        </div>

        <div class="order-info">
            <h2>{{ __('Order Items') }}</h2>
            @foreach($order->items as $item)
            <div class="order-item">
                <p><strong>{{ $item->product_name }}</strong> ({{ $item->product_sku }})</p>
                <p>{{ __('Quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} = {{ number_format($item->total, 2) }}</p>
            </div>
            @endforeach
        </div>

        <div class="total">
            <div class="total-row">
                <span>{{ __('Subtotal') }}:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount > 0)
            <div class="total-row">
                <span>{{ __('Discount') }}:</span>
                <span>-${{ number_format($order->discount, 2) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>{{ __('Tax') }}:</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="total-row final">
                <span>{{ __('Total') }}:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>{{ __('If you have any questions, please contact us.') }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
    </div>
</body>
</html>

