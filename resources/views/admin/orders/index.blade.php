@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Orders Management</h1>

    <table class="w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">User</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="border-b">
                    <td class="p-3">{{ $order->id }}</td>
                    <td class="p-3">{{ $order->user->name }}</td>
                    <td class="p-3">${{ $order->total }}</td>
                    <td class="p-3">{{ $order->status }}</td>
                    <td class="p-3">
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="border p-1">
                                <option value="pending" @selected($order->status == 'pending')>Pending</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="completed" @selected($order->status == 'completed')>Completed</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Canceled</option>
                            </select>
                            <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
