@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-6">
    <h2 class="text-xl font-bold mb-4">Add Category</h2>
    <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Category Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
