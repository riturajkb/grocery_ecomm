@extends('layouts.app')

@section('content')
<!-- 3-Step Progress Bar -->
<div class="max-w-3xl mx-auto mb-10">
    <div class="flex items-center justify-between">
        <!-- Step 1: Address -->
        <div class="flex-1 flex flex-col items-center">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold shadow-lg" style="background-color: #2D6A4F;">
                1
            </div>
            <span class="mt-2 text-sm font-semibold" style="color: #2D6A4F;">Address</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-1 mx-2" style="background: linear-gradient(to right, #2D6A4F, #d1d5db);"></div>
        
        <!-- Step 2: Confirmation -->
        <div class="flex-1 flex flex-col items-center">
            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shadow-lg bg-gray-200 text-gray-500">
                2
            </div>
            <span class="mt-2 text-sm font-medium text-gray-400">Confirmation</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-1 mx-2 bg-gray-200"></div>
        
        <!-- Step 3: Success -->
        <div class="flex-1 flex flex-col items-center">
            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shadow-lg bg-gray-200 text-gray-500">
                3
            </div>
            <span class="mt-2 text-sm font-medium text-gray-400">Success</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <h2 class="text-2xl font-bold mb-6" style="color: #475569;">Checkout</h2>
        
        @if($addresses->count() > 0)
            <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
                @csrf
                
                <!-- Address Selection Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center" style="background-color: #FDFBF7;">
                        <h3 class="font-bold text-lg" style="color: #475569;">📍 Delivery Address</h3>
                        <a href="{{ route('account.addresses.create') }}" class="text-sm font-semibold px-4 py-2 rounded-lg transition-all hover:opacity-80" style="background-color: #2D6A4F; color: white;">
                            + Add New
                        </a>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        @foreach($addresses as $address)
                            <label class="block p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 address-option {{ $defaultAddress && $defaultAddress->id == $address->id ? 'selected' : '' }}"
                                   style="border-color: {{ $defaultAddress && $defaultAddress->id == $address->id ? '#2D6A4F' : '#e5e7eb' }}; background-color: {{ $defaultAddress && $defaultAddress->id == $address->id ? 'rgba(45, 106, 79, 0.05)' : 'white' }};"
                                   onclick="selectAddress(this, '{{ $address->id }}')">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" 
                                           {{ $defaultAddress && $defaultAddress->id == $address->id ? 'checked' : '' }}
                                           required
                                           class="mt-1 w-5 h-5" style="accent-color: #2D6A4F;">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="font-bold text-gray-900">{{ $address->name }}</span>
                                            @if($address->is_default)
                                                <span class="text-xs font-bold px-2 py-0.5 rounded-full text-white" style="background-color: #2D6A4F;">DEFAULT</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-600 text-sm space-y-1">
                                            <div class="flex items-center gap-2">
                                                <span>📞</span>
                                                <span>{{ $address->phone }}</span>
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <span>🏠</span>
                                                <span>{{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Note Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-100" style="background-color: #FDFBF7;">
                        <h3 class="font-bold text-lg" style="color: #475569;">📝 Delivery Instructions</h3>
                    </div>
                    <div class="p-6">
                        <textarea name="delivery_note" 
                                  placeholder="Add any special instructions for the delivery driver (e.g., ring the bell twice, leave at door, call before arriving...)"
                                  class="w-full p-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#2D6A4F] transition-colors resize-none"
                                  rows="3"></textarea>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-100" style="background-color: #FDFBF7;">
                        <h3 class="font-bold text-lg" style="color: #475569;">💳 Payment Method</h3>
                    </div>
                    <div class="p-6">
                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer" style="border-color: #2D6A4F; background-color: rgba(45, 106, 79, 0.05);">
                            <input type="radio" name="payment_method" value="COD" checked class="w-5 h-5" style="accent-color: #2D6A4F;">
                            <span class="ml-3 font-bold text-gray-900">💵 Cash on Delivery (COD)</span>
                        </label>
                    </div>
                </div>

                <!-- Place Order Button with Pay on Delivery Badge -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <button type="submit" class="w-full sm:flex-1 py-4 px-8 rounded-xl font-bold text-lg text-white transition-all hover:opacity-90 hover:shadow-lg flex items-center justify-center gap-3" style="background-color: #2D6A4F;">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Place Order
                    </button>
                    
                    <!-- Pay on Delivery Badge -->
                    <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2" style="border-color: #2D6A4F; background-color: rgba(45, 106, 79, 0.05);">
                        <svg class="h-8 w-8" style="color: #2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <div class="font-bold text-sm" style="color: #2D6A4F;">Pay on Delivery</div>
                            <div class="text-xs text-gray-500">No payment now</div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="text-center py-16 px-6">
                    <div class="text-6xl mb-4">📍</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">No Saved Addresses</h4>
                    <p class="text-gray-500 mb-6">Please add a delivery address to continue with checkout.</p>
                    <a href="{{ route('account.addresses.create') }}" class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white transition-all hover:opacity-90" style="background-color: #2D6A4F;">
                        Add Delivery Address
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Order Summary Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
            <div class="px-6 py-4 border-b border-gray-100" style="background-color: #FDFBF7;">
                <h3 class="font-bold text-lg" style="color: #475569;">🛒 Order Summary</h3>
            </div>
            <div class="p-6">
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <span class="font-bold" style="color: #2D6A4F;">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                    </div>
                @endforeach
                
                <div class="mt-6 pt-4 border-t-2 border-gray-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-semibold">₹{{ number_format($total) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Delivery</span>
                        <span class="font-semibold text-green-600">FREE</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-bold" style="color: #2D6A4F;">₹{{ number_format($total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAddress(element, addressId) {
    // Remove selected styling from all options
    document.querySelectorAll('.address-option').forEach(opt => {
        opt.style.borderColor = '#e5e7eb';
        opt.style.backgroundColor = 'white';
        opt.classList.remove('selected');
    });
    
    // Add selected styling to clicked option
    element.style.borderColor = '#2D6A4F';
    element.style.backgroundColor = 'rgba(45, 106, 79, 0.05)';
    element.classList.add('selected');
    
    // Check the radio button
    element.querySelector('input[type="radio"]').checked = true;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedOption = document.querySelector('.address-option.selected');
    if (selectedOption) {
        selectedOption.style.borderColor = '#2D6A4F';
        selectedOption.style.backgroundColor = 'rgba(45, 106, 79, 0.05)';
    }
});
</script>
@endsection