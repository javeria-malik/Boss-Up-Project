<!DOCTYPE html>
<html>
<head>
    <title>Order Invoice</title>
</head>
<body>
    <h2>Dear {{ $order->name }},</h2>
    <p>Thank you for your purchase. Here is your invoice:</p>
    
    <h3>Order Details:</h3>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>

    <h3>Shipping Details:</h3>
    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->country }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>

    <h3>Ordered Items:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->title }} - ${{ number_format($item->price, 2) }} x {{ $item->quantity }}</li>
        @endforeach
    </ul>

    <p>Thank you for shopping with us!</p>
</body>
</html>
