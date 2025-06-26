@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Categories</h2>
    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Category</a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Name</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr class="border-t">
                <td class="p-2">{{ $category->name }}</td>
                <td class="p-2">
                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block ml-2">
                        @csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
