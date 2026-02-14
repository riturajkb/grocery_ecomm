@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Table Header -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 border-b border-gray-100 text-sm font-semibold text-gray-500 uppercase tracking-wider" style="background-color: #FDFBF7;">
                        <div class="col-span-5">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-3 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                    </div>

                    <!-- Cart Items -->
                    <div class="divide-y divide-gray-100">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-6 items-center" data-id="{{ $id }}">
                                <!-- Product -->
                                <div class="md:col-span-5 flex items-center gap-4">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $details['name'] }}</h3>
                                        <button class="remove-from-cart text-red-500 text-sm font-medium hover:text-red-700 transition-colors flex items-center gap-1 mt-1">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="md:col-span-2 text-center">
                                    <span class="md:hidden text-sm text-gray-500 mr-2">Price:</span>
                                    <span class="font-medium text-gray-900">₹{{ number_format($details['price']) }}</span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="md:col-span-3 flex items-center justify-center">
                                    <span class="md:hidden text-sm text-gray-500 mr-2">Qty:</span>
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" class="quantity-btn minus-btn w-10 h-10 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors text-gray-600 text-lg font-medium">
                                            −
                                        </button>
                                        <input type="number" 
                                               value="{{ $details['quantity'] }}" 
                                               min="1"
                                               class="quantity-input w-14 h-10 text-center border-x border-gray-200 font-semibold text-gray-900 focus:outline-none" 
                                               data-id="{{ $id }}">
                                        <button type="button" class="quantity-btn plus-btn w-10 h-10 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors text-gray-600 text-lg font-medium">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="md:col-span-2 text-right">
                                    <span class="md:hidden text-sm text-gray-500 mr-2">Subtotal:</span>
                                    <span class="font-bold text-gray-900">₹{{ number_format($details['price'] * $details['quantity']) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continue Shopping Link -->
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-6 text-sm font-medium transition-colors hover:opacity-80" style="color: #2D6A4F;">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <div class="px-6 py-4 border-b border-gray-100" style="background-color: #FDFBF7;">
                        <h2 class="font-bold text-lg text-gray-900">Order Summary</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">₹{{ number_format($total) }}</span>
                        </div>

                        <!-- Shipping -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold text-green-600">FREE</span>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 pt-4">
                            <!-- Grand Total -->
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Grand Total</span>
                                <span class="text-2xl font-bold" style="color: #2D6A4F;">₹{{ number_format($total) }}</span>
                            </div>
                        </div>

                        <!-- COD Badge -->
                        <div class="flex items-center gap-2 p-3 rounded-lg border" style="border-color: #2D6A4F; background-color: rgba(45, 106, 79, 0.05);">
                            <svg class="h-5 w-5" style="color: #2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-sm font-medium" style="color: #2D6A4F;">Pay on Delivery Available</span>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout.index') }}" 
                           class="w-full flex items-center justify-center gap-2 py-4 px-6 rounded-xl font-bold text-white transition-all hover:opacity-90 hover:shadow-lg text-lg"
                           style="background-color: #2D6A4F;">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Proceed to COD Checkout
                        </a>

                        <!-- Secure Checkout Notice -->
                        <p class="text-center text-xs text-gray-500 flex items-center justify-center gap-1">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Secure checkout
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="text-center py-16 px-6">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all hover:opacity-90" style="background-color: #2D6A4F;">
                    Start Shopping
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    // Quantity Button Controls
    document.querySelectorAll('.minus-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const container = this.closest('[data-id]');
            const input = container.querySelector('.quantity-input');
            const currentVal = parseInt(input.value);
            if (currentVal > 1) {
                input.value = currentVal - 1;
                updateCart(container.getAttribute('data-id'), currentVal - 1);
            }
        });
    });

    document.querySelectorAll('.plus-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const container = this.closest('[data-id]');
            const input = container.querySelector('.quantity-input');
            const currentVal = parseInt(input.value);
            input.value = currentVal + 1;
            updateCart(container.getAttribute('data-id'), currentVal + 1);
        });
    });

    // Quantity Input Change
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const quantity = parseInt(this.value);
            if (quantity >= 1) {
                updateCart(id, quantity);
            } else {
                this.value = 1;
                updateCart(id, 1);
            }
        });
    });

    // Update Cart Function
    function updateCart(id, quantity) {
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity
            })
        }).then(response => {
            window.location.reload();
        });
    }

    // Remove from Cart
    document.querySelectorAll('.remove-from-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('[data-id]');
            const id = container.getAttribute('data-id');

            if (confirm('Remove this item from your cart?')) {
                fetch('{{ route('cart.remove') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                }).then(response => {
                    window.location.reload();
                });
            }
        });
    });
</script>
@endsection
