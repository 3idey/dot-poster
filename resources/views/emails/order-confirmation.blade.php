<x-mail::message>
# Order Confirmation #{{ $order->id }}

Thank you for your order! We've received your order and will process it shortly.

## Order Details
- **Order ID:** #{{ $order->id }}
- **Total Amount:** ${{ number_format($order->total_amount, 2) }}
- **Payment Method:** {{ ucfirst($order->payment_method) }}
- **Status:** {{ ucfirst($order->status) }}

## Items Ordered
@foreach($order->orderItems as $item)
- {{ $item->product->name }} (Qty: {{ $item->quantity }}) - ${{ number_format($item->price * $item->quantity, 2) }}
@endforeach

<x-mail::button :url="route('orders.show', $order)">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
