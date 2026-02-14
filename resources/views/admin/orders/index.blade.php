@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Orders</h1>
    </div>

    <div class="card">
        <div class="card-body">
            @if($orders->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer_name ?? ($order->user->name ?? 'Guest') }}</td>
                                <td>{{ $order->phone ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total_price ?? 0, 2) }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span style="background: #cce5ff; color: #004085; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Processing</span>
                                    @elseif($order->status == 'delivered')
                                        <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Delivered</span>
                                    @elseif($order->status == 'cancelled')
                                        <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Cancelled</span>
                                    @else
                                        <span style="background: #e9ecef; color: #495057; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ ucfirst($order->status ?? 'Unknown') }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px; border: 1px solid #ced4da;">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #6c757d; padding: 40px;">No orders yet.</p>
            @endif
        </div>
    </div>
@endsection
