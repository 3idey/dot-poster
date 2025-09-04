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
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Delete</button>
                        </form>
                    </td>
                    <td class="p-3">
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border border-gray-300 rounded-lg p-2 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="pending" @selected($order->status == 'pending')>Pending</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="completed" @selected($order->status == 'completed')>Completed</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Canceled</option>
                            </select>
                            <button class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-3 py-1 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Update</button>
                        </form>
                    </td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
@endsection
