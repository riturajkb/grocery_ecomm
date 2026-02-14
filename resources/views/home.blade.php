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

        <!-- Quick Filter Chips -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button @click="setFilter('all')" :class="activeFilter === 'all' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'all' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🛒</span> All Products
            </button>
            <button @click="setFilter('vegetables')"
                :class="activeFilter === 'vegetables' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'vegetables' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🥦</span> Vegetables
            </button>
            <button @click="setFilter('dairy')"
                :class="activeFilter === 'dairy' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'dairy' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🥛</span> Dairy
            </button>
            <button @click="setFilter('grains')"
                :class="activeFilter === 'grains' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'grains' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🍚</span> Grains
            </button>
            <button @click="setFilter('fruits')"
                :class="activeFilter === 'fruits' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'fruits' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🍎</span> Fruits
            </button>
            <button @click="setFilter('beverages')"
                :class="activeFilter === 'beverages' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'beverages' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🧃</span> Beverages
            </button>
            <button @click="setFilter('snacks')"
                :class="activeFilter === 'snacks' ? 'ring-2 ring-offset-2' : 'hover:shadow-md'"
                class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                :style="activeFilter === 'snacks' ? 'background-color: #2D6A4F; color: white; ring-color: #2D6A4F;' : 'background-color: white; color: #475569; border: 1px solid #e5e7eb;'">
                <span>🍪</span> Snacks
            </button>
        </div>

        <!-- Results Count -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500">
                Showing <span class="font-semibold text-gray-900" x-text="filteredProducts.length"></span> products
                <span x-show="activeFilter !== 'all'" class="ml-1">
                    in <span class="font-semibold capitalize" style="color: #2D6A4F;" x-text="activeFilter"></span>
                </span>
            </p>
            <button x-show="activeFilter !== 'all'" @click="setFilter('all')" class="text-sm font-medium hover:underline"
                style="color: #2D6A4F;">
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
        <button @click="setFilter('all')"
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