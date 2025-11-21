<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Order Update') }}</title>
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
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-shipped { background: #d1fae5; color: #065f46; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-unpaid { background: #fef3c7; color: #92400e; }
        .status-refunded { background: #fee2e2; color: #991b1b; }
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
        <h1>{{ __('Order Update') }}</h1>
        <p>{{ __('Your order status has been updated') }}</p>
    </div>
    
    <div class="content">
        <div class="order-info">
            <h2>{{ __('Order Details') }}</h2>
            <p><strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}</p>
            <p><strong>{{ __('Order Date') }}:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
            
            @if($statusType === 'status')
            <p><strong>{{ __('New Status') }}:</strong></p>
            <span class="status-badge status-{{ $order->status }}">
                {{ ucfirst($order->status) }}
            </span>
            @else
            <p><strong>{{ __('New Payment Status') }}:</strong></p>
            <span class="status-badge status-{{ $order->payment_status }}">
                {{ ucfirst($order->payment_status) }}
            </span>
            @endif
        </div>

        <div class="order-info">
            <h2>{{ __('Order Summary') }}</h2>
            <p><strong>{{ __('Total') }}:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>{{ __('Payment Method') }}:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>
    </div>

    <div class="footer">
        <p>{{ __('If you have any questions, please contact us.') }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
    </div>
</body>
</html>

