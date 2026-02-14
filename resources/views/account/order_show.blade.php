@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6 max-w-7xl mx-auto">
        <!-- Sidebar Navigation -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                <!-- User Profile Section -->
                <div class="p-6 border-b border-gray-100" style="background: linear-gradient(135deg, #2D6A4F, #1d4430);">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-white truncate">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-white/80 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-2">
                    <a href="{{ route('account.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all mb-1">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('account.orders') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all mb-1"
                        style="background-color: #E8F5E9; color: #2D6A4F;">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        My Orders
                    </a>
                    <a href="{{ route('account.addresses') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all mb-1">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Addresses
                    </a>
                    <a href="{{ route('account.profile') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile Settings
                    </a>
                </nav>

                <!-- Logout Button -->
                <div class="p-4 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-all">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('account.orders') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <!-- Header -->
                <div
                    class="px-8 py-6 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">Order #{{ $order->id }}</h1>
                        <p class="text-gray-500 text-sm">Placed on {{ $order->created_at->format('M d, Y') }} at
                            {{ $order->created_at->format('h:i A') }}</p>
                    </div>
                    <div>
                        @php
                            $statusClass = match ($order->status) {
                                'delivered' => 'bg-green-100 text-green-800 border border-green-200',
                                'shipped' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                'processing' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                default => 'bg-gray-100 text-gray-800 border border-gray-200'
                            };
                        @endphp
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100">
                    <!-- Shipping Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Shipping Information
                        </h3>
                        <div class="bg-gray-50 text-gray-700 rounded-lg p-4 border border-gray-100">
                            <div class="mb-2">
                                <span class="block text-xs font-medium text-gray-500 uppercase">Address</span>
                                <span class="text-sm font-medium">{{ $order->address }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-500 uppercase">Phone</span>
                                <span class="text-sm font-medium">{{ $order->phone }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info (Placeholder as not in DB yet) -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Order Summary</h3>
                        <div class="bg-gray-50 text-gray-700 rounded-lg p-4 border border-gray-100">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm">Subtotal</span>
                                <span class="text-sm font-medium">₹{{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm">Shipping</span>
                                <span class="text-sm font-medium text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                                <span class="text-base font-bold text-gray-900">Total</span>
                                <span
                                    class="text-base font-bold text-gray-900">₹{{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="px-8 py-8">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Items Ordered</h3>
                    <div class="border border-gray-100 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <div class="h-10 w-10 flex-shrink-0 mr-3">
                                                        <img class="h-10 w-10 rounded-md object-cover"
                                                            src="{{ asset('storage/' . $item->product->image) }}"
                                                            alt="{{ $item->product->name }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right">
                                            ₹{{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                @if($order->status == 'pending')
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                        <form action="{{ route('account.order.cancel', $order->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.');">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection