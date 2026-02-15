<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dipika Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="background-color: #FDFBF7; color: #475569;">
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 mb-8">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex-shrink-0 w-[200px]">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="h-10 w-10 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform duration-300"
                        style="background: linear-gradient(135deg, #2D6A4F, #1d4430); box-shadow: 0 10px 15px -3px rgba(45, 106, 79, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span
                        class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 font-display">Dipika
                        Store</span>
                </a>
            </div>

            <!-- Centered Search Bar -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <form action="{{ route('home') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search for groceries..." 
                               class="w-full px-5 py-3 pl-12 rounded-full border-2 border-gray-200 focus:border-[#2D6A4F] focus:outline-none transition-all duration-200 text-gray-700 placeholder-gray-400"
                               style="background-color: #FDFBF7;">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-4">
                <a href="{{ route('home') }}"
                    class="text-sm font-medium px-4 py-2 rounded-full transition-all duration-200"
                    style="{{ request()->routeIs('home') ? 'color: #2D6A4F; background-color: rgba(45, 106, 79, 0.1);' : 'color: #6b7280;' }}">
                    Home
                </a>
                <a href="{{ route('cart.index') }}"
                    class="text-sm font-medium px-4 py-2 rounded-full transition-all duration-200 flex items-center gap-2"
                    style="{{ request()->routeIs('cart.*') ? 'color: #2D6A4F; background-color: rgba(45, 106, 79, 0.1);' : 'color: #6b7280;' }}">
                    Cart
                    @if(count((array) session('cart')) > 0)
                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white {{ session('success') ? 'animate-bounce-short' : '' }}">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('account.dashboard') }}"
                        class="text-sm font-medium px-4 py-2 rounded-full transition-all duration-200"
                        style="{{ request()->routeIs('account.*') || request()->routeIs('account.*') ? 'color: #2D6A4F; background-color: #E8F5E9;' : 'color: #6b7280;' }}">
                        Account
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-medium px-4 py-2 rounded-full transition-all duration-200 flex items-center gap-1"
                            style="{{ request()->routeIs('admin.*') ? 'color: #2D6A4F; background-color: rgba(45, 106, 79, 0.1);' : 'color: #6b7280;' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center justify-end w-[200px] gap-4">
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700 hidden lg:block">Hi, {{ Auth::user()->name }}</span>
                        <div class="h-8 w-px bg-gray-200 mx-1 hidden lg:block"></div>
                        <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit"
                                class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-200"
                                title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Log in</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-medium bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 shadow-sm hover:shadow transition-all transform hover:-translate-y-0.5">Sign
                            up</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 mb-20 md:mb-0">
        @if(session('success'))
            <div
                class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 animate-fade-in-down shadow-sm max-w-4xl mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm max-w-4xl mx-auto">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation -->
    <div
        class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 px-6 py-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <div class="flex justify-around items-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 min-w-[44px]"
                style="color: {{ request()->routeIs('home') ? '#2D6A4F' : '#6b7280' }};">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-1 min-w-[44px] relative"
                style="color: {{ request()->routeIs('cart.*') ? '#2D6A4F' : '#6b7280' }};">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(count((array) session('cart')) > 0)
                        <span
                            class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white shadow-sm ring-1 ring-white {{ session('success') ? 'animate-bounce-short' : '' }}">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </div>
                <span class="text-[10px] font-medium">Cart</span>
            </a>

            @auth
                <a href="{{ route('account.dashboard') }}" class="flex flex-col items-center gap-1 min-w-[44px]"
                    style="color: {{ request()->routeIs('account.*') ? '#2D6A4F' : '#6b7280' }};">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-[10px] font-medium">Account</span>
                </a>
                
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 min-w-[44px]"
                        style="color: {{ request()->routeIs('admin.*') ? '#2D6A4F' : '#6b7280' }};">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-[10px] font-medium">Admin</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 min-w-[44px]"
                    style="color: {{ request()->routeIs('login') ? '#2D6A4F' : '#6b7280' }};">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-[10px] font-medium">Login</span>
                </a>
            @endauth
        </div>
    </div>

    <!-- Mini-Cart Slide-Over -->
    <div id="miniCart" class="fixed inset-0 z-[100] pointer-events-none">
        <!-- Backdrop -->
        <div id="miniCartBackdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"
            onclick="closeMiniCart()"></div>

        <!-- Slide-over Panel -->
        <div id="miniCartPanel"
            class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col pointer-events-auto">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b"
                style="background: linear-gradient(135deg, #2D6A4F, #1d4430);">
                <div class="flex items-center gap-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-bold text-white">Your Cart</h3>
                    @if(count((array) session('cart')) > 0)
                        <span
                            class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ count((array) session('cart')) }}
                            items</span>
                    @endif
                </div>
                <button onclick="closeMiniCart()"
                    class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                @php $cart = session('cart', []);
                $total = 0; @endphp
                @if(count($cart) > 0)
                    <div class="space-y-4">
                        @foreach($cart as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <div class="flex gap-4 p-3 bg-gray-50 rounded-xl">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                        class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    <p class="font-bold mt-1" style="color: #2D6A4F;">
                                        ₹{{ number_format($item['price'] * $item['quantity']) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500">Your cart is empty</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            @if(count($cart) > 0)
                <div class="border-t p-6 space-y-4" style="background-color: #FDFBF7;">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-2xl font-bold" style="color: #2D6A4F;">₹{{ number_format($total) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('cart.index') }}"
                            class="flex items-center justify-center px-4 py-3 border-2 rounded-xl font-semibold text-sm transition-all hover:bg-gray-50"
                            style="border-color: #2D6A4F; color: #2D6A4F;">
                            View Cart
                        </a>
                        <a href="{{ route('checkout.index') }}"
                            class="flex items-center justify-center px-4 py-3 rounded-xl font-semibold text-sm text-white transition-all hover:opacity-90"
                            style="background-color: #2D6A4F;">
                            Checkout
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 mt-auto py-12 mb-16 md:mb-0">
        <div class="max-w-[1440px] mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Dipika Store. All rights reserved.
        </div>
    </footer>
    <style>
        @keyframes bounce-short {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25%);
            }
        }

        .animate-bounce-short {
            animation: bounce-short 0.5s ease-in-out 2;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .mini-cart-open #miniCartBackdrop {
            opacity: 1;
            pointer-events: auto;
        }

        .mini-cart-open #miniCartPanel {
            transform: translateX(0);
        }

        .mini-cart-open #miniCart {
            pointer-events: auto;
        }
    </style>

    <script>
        function openMiniCart() {
            document.body.classList.add('mini-cart-open');
            document.body.style.overflow = 'hidden';
        }

        function closeMiniCart() {
            document.body.classList.remove('mini-cart-open');
            document.body.style.overflow = '';
        }

        // Auto-open mini cart if item was just added (check for success message about cart)
        @if(session('success') && str_contains(session('success'), 'cart'))
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(openMiniCart, 300);
            });
        @endif
    </script>
</body>

</html>