@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-6">
    <h2 class="text-xl font-bold mb-4">Add Product</h2>
    <form method="POST" action="{{ route('products.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Price</label>
            <input type="number" name="price" step="0.01" class="w-full border p-2 rounded" value="{{ old('price') }}">
            @error('price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Stock</label>
            <input type="number" name="stock" class="w-full border p-2 rounded" value="{{ old('stock') }}">
            @error('stock') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full border p-2 rounded">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
