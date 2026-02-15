@extends('admin.layout')

@section('content')
    <h1>Edit Product</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control" required onchange="toggleNewCategory(this)">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                        <option value="new">+ Add New Category</option>
                    </select>
                </div>
                <div class="mb-3" id="new_category_div" style="display: none;">
                    <label for="new_category" class="form-label">New Category Name</label>
                    <input type="text" name="new_category" id="new_category" class="form-control"
                        placeholder="Enter new category name">
                </div>

                <script>
                    function toggleNewCategory(select) {
                        const newCatDiv = document.getElementById('new_category_div');
                        const newCatInput = document.getElementById('new_category');
                        if (select.value === 'new') {
                            newCatDiv.style.display = 'block';
                            newCatInput.setAttribute('required', 'required');
                        } else {
                            newCatDiv.style.display = 'none';
                            newCatInput.removeAttribute('required');
                        }
                    }
                </script>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description"
                        class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control"
                        value="{{ old('price', $product->price) }}" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if ($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products') }}" class="btn">Cancel</a>
            </form>
        </div>
    </div>
@endsection