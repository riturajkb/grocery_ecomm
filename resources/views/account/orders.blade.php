@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6 max-w-7xl mx-auto">
        <!-- Sidebar Navigation (Same as Dashboard) -->
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-100" style="background-color: #FDFBF7;">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">My Orders</h1>
                    <p class="text-gray-500 text-sm">View and track your previous purchases</p>
                </div>

                <div class="p-0">
                    @if($orders->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order ID</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                        <th
                                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($orders as $order)
                                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                                        #{{ $order->id }}
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                                        {{ $order->created_at->format('M d, Y') }}
                                                                        <span
                                                                            class="text-xs text-gray-400 block">{{ $order->created_at->format('h:i A') }}</span>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        @php
                                                                            $statusClass = match ($order->status) {
                                                                                'delivered' => 'bg-green-100 text-green-800',
                                                                                'shipped' => 'bg-blue-100 text-blue-800',
                                                                                'processing' => 'bg-yellow-100 text-yellow-800',
                                                                                'cancelled' => 'bg-red-100 text-red-800',
                                                                                default => 'bg-gray-100 text-gray-800'
                                                                            };
                                                                        @endphp
                                         <span
                                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                                                            {{ ucfirst($order->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                                        ₹{{ number_format($order->total_price, 2) }}
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                        <a href="{{ route('account.order.show', $order->id) }}"
                                                                            class="inline-flex items-center text-gray-700 hover:text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-md transition-all">
                                                                            Details
                                                                            <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                    d="M9 5l7 7-7 7" />
                                                                            </svg>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card Stack View -->
                        <div class="md:hidden space-y-4 p-4">
                            @foreach ($orders as $order)
                                                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                                                    <div class="flex justify-between items-start mb-3">
                                                        <div>
                                                            <span class="text-sm font-bold text-gray-900">Order #{{ $order->id }}</span>
                                                            <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}
                                                            </p>
                                                        </div>
                                       @php
                                        $statusClass = match ($order->status) {
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'shipped' => 'bg-blue-100 text-blue-800',
                                            'processing' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                 <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </div>

                                                    <div class="flex justify-between items-end border-t border-gray-100 pt-3 mt-3">
                                                        <div class="text-sm font-bold text-gray-900">
                                                            ₹{{ number_format($order->total_price, 2) }}
                                                        </div>
                                                        <a href="{{ route('account.order.show', $order->id) }}"
                                                            class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 px-6">
                            <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-2 text-sm text-gray-500 max-w-sm mx-auto">Start shopping to see your orders here.</p>
                            <a href="{{ route('home') }}"
                                class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
@endsection