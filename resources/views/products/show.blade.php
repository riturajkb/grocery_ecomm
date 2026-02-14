@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=No+Image" class="img-fluid rounded" alt="No Image">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <h3 class="text-muted">₹{{ $product->price }}</h3>
            <p class="mt-3">{{ $product->description }}</p>

            <p><strong>Stock:</strong> {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of Stock' }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Quantity</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1"
                            max="{{ $product->stock }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to Catalogue</a>
        </div>
    </div>
@endsection