@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Add Product</a>
    </div>

    <!-- Modern Search & Filter Bar -->
    <div class="mb-8 bg-white rounded-2xl shadow-sm border border-slate-100 p-1">
        <form action="{{ route('admin.products') }}" method="GET" class="flex gap-2 relative">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D6A4F] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <!-- Search Input -->
                <input type="text" name="search" 
                    class="block w-full pl-11 pr-4 py-3.5 bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 font-medium text-base rounded-xl transition-all"
                    placeholder="Search by name, ID, or category..." 
                    value="{{ request('search') }}"
                    autocomplete="off">
            </div>
            
            <div class="flex items-center gap-2 pr-1">
                @if(request('search'))
                    <a href="{{ route('admin.products') }}" 
                        class="px-4 py-2.5 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 font-medium transition-all text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear
                    </a>
                @endif

                <button type="submit" 
                    class="px-8 py-3 bg-[#2D6A4F] hover:bg-[#23553f] text-white font-semibold rounded-xl transition-all shadow-lg shadow-[#2D6A4F]/20 hover:shadow-[#2D6A4F]/40 active:scale-95 flex items-center gap-2">
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="60">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>₹{{ number_format($product->price) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection