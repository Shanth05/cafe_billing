@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Products</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Product</a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Name</th>
                <th class="p-2">Price</th>
                <th class="p-2">Stock</th>
                <th class="p-2">Category</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="border-t">
                <td class="p-2">{{ $product->name }}</td>
                <td class="p-2">Rs. {{ $product->price }}</td>
                <td class="p-2">{{ $product->stock }}</td>
                <td class="p-2">{{ $product->category->name }}</td>
                <td class="p-2">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block ml-2">
                        @csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
