@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary" style="background-color: #6c757d;">← Back to
            Orders</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <!-- Order Items -->
        <div class="card">
            <div class="card-body">
                <h3 style="margin-bottom: 20px;">Order Items</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->product)
                                        {{ $item->product->name }}
                                    @else
                                        <span style="color: #999;">Product Deleted</span>
                                    @endif
                                </td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;">₹{{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Details -->
        <div>
            <div class="card">
                <div class="card-body">
                    <h3 style="margin-bottom: 20px;">Customer Details</h3>
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Address:</strong></p>
                    <p style="background: #f8f9fa; padding: 10px; border-radius: 4px;">{{ $order->address }}</p>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <div class="card-body">
                    <h3 style="margin-bottom: 20px;">Order Info</h3>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <p><strong>Payment:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Status:</strong>
                        @if($order->status == 'pending')
                            <span
                                style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pending</span>
                        @elseif($order->status == 'processing')
                            <span
                                style="background: #cce5ff; color: #004085; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Processing</span>
                        @elseif($order->status == 'delivered')
                            <span
                                style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Delivered</span>
                        @elseif($order->status == 'cancelled')
                            <span
                                style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Cancelled</span>
                        @endif
                    </p>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        @method('PUT')
                        <label class="form-label">Update Status:</label>
                        <select name="status" class="form-control" style="margin-bottom: 10px;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection