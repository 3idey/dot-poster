<x-mail::message>
# Order Status Update

Your order #{{ $order->id }} status has been updated.

## Status Change
- **Previous Status:** {{ ucfirst($oldStatus) }}
- **New Status:** {{ ucfirst($order->status) }}
- **Order Total:** ${{ number_format($order->total_amount, 2) }}

@if($order->status === 'shipped')
Your order is on its way! You should receive it within 3-5 business days.
@elseif($order->status === 'delivered')
Your order has been delivered! We hope you enjoy your purchase.
@elseif($order->status === 'cancelled')
Your order has been cancelled. If you have any questions, please contact our support team.
@endif

<x-mail::button :url="route('orders.show', $order)">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
