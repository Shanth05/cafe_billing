@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-6">
    <h2 class="text-xl font-bold mb-4">Edit Category</h2>
    <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block mb-1">Category Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name', $category->name) }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
