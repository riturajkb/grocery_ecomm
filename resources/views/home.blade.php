@extends('layouts.app')

@section('content')
    <div x-data="productFilter()" x-init="init()">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight text-gray-900">Freshness Delivered</h1>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                Explore our curated selection of premium groceries, hand-picked for your kitchen.
            </p>
        </div>

        <!-- Dynamic Category Filter Dropdown -->
        <div class="flex justify-center mb-12">
            <div class="w-full max-w-sm">
                <label for="category-filter"
                    class="block text-sm font-semibold text-gray-700 mb-3 text-center uppercase tracking-wider">
                    Browse by Category
                </label>
                <div class="relative group">
                    <select id="category-filter" @change="setFilter($event.target.value)"
                        class="appearance-none block w-full pl-6 pr-12 py-4 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] transition-all bg-white text-gray-700 font-medium cursor-pointer hover:border-[#2D6A4F]/50">
                        <option value="all">View All Products</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-400 group-hover:text-[#2D6A4F] transition-colors">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Count -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500">
                Showing <span class="font-semibold text-gray-900" x-text="filteredProducts.length"></span> products
                <span x-show="activeFilter !== 'all'" class="ml-1">
                    in <span class="font-semibold capitalize" style="color: #2D6A4F;" x-text="activeFilter"></span>
                </span>
            </p>
            <button x-show="activeFilter !== 'all'"
                @click="setFilter('all'); document.getElementById('category-filter').value = 'all'"
                class="text-sm font-medium hover:underline" style="color: #2D6A4F;">
                Clear filter
            </button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3 sm:gap-4">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg hover:scale-[1.02] transform transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 group relative"
                    x-show="shouldShow(product)" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <!-- Image Container -->
                    <div class="relative aspect-[4/3] bg-gray-50 overflow-hidden">
                        <template x-if="product.image">
                            <img :src="'/storage/' + product.image" :alt="product.name"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </template>
                        <template x-if="!product.image">
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </template>

                        <template x-if="product.stock <= 0">
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-10">
                                <span
                                    class="bg-black/80 text-white px-3 py-1 rounded-full text-xs font-bold tracking-wide shadow-lg">
                                    SOLD OUT
                                </span>
                            </div>
                        </template>

                        <!-- Stock Badge -->
                        <template x-if="product.stock > 0 && product.stock < 5">
                            <span
                                class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                Only <span x-text="product.stock"></span> left
                            </span>
                        </template>
                    </div>

                    <!-- Content -->
                    <div class="p-3 flex-1 flex flex-col">
                        <h3 class="text-gray-900 font-semibold text-sm leading-tight mb-1 line-clamp-2 group-hover:text-[#2D6A4F] transition-colors"
                            x-text="product.name"></h3>

                        <!-- Price -->
                        <div class="flex items-center justify-between mt-auto pt-2">
                            <span class="text-lg font-bold text-gray-900">₹<span
                                    x-text="new Intl.NumberFormat('en-IN').format(product.price)"></span></span>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                :class="product.stock > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                x-text="product.stock > 0 ? 'In Stock' : 'Out'"></span>
                        </div>

                        <!-- Single Add to Cart Button -->
                        <form :action="'/cart/add/' + product.id" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full flex items-center justify-center py-2 rounded-lg font-semibold text-xs transition-all"
                                :class="product.stock > 0 ? 'text-white hover:opacity-90' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                                :style="product.stock > 0 ? 'background-color: #2D6A4F;' : ''"
                                :disabled="product.stock <= 0" x-text="product.stock > 0 ? 'Add to Cart' : 'Out of Stock'">
                            </button>
                        </form>
                    </div>
                </div>
            </template>
        </div>

        <!-- No Results -->
        <div x-show="filteredProducts.length === 0" class="text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-500 mb-4">Try selecting a different category</p>
            <button @click="setFilter('all'); document.getElementById('category-filter').value = 'all'"
                class="px-6 py-3 rounded-xl font-semibold text-white transition-all hover:opacity-90"
                style="background-color: #2D6A4F;">
                View All Products
            </button>
        </div>
    </div>

    <script>
        function productFilter() {
            return {
                activeFilter: 'all',
                searchQuery: '{{ request("search") }}',
                products: @json($products),

                init() {
                    // Apply search filter if present
                    if (this.searchQuery) {
                        this.products = this.products.filter(p =>
                            p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            (p.description && p.description.toLowerCase().includes(this.searchQuery.toLowerCase()))
                        );
                    }
                },

                get filteredProducts() {
                    if (this.activeFilter === 'all') {
                        return this.products;
                    }
                    return this.products.filter(p => p.category === this.activeFilter);
                },

                setFilter(filter) {
                    this.activeFilter = filter;
                },

                shouldShow(product) {
                    return this.activeFilter === 'all' || product.category === this.activeFilter;
                }
            }
        }
    </script>
@endsection