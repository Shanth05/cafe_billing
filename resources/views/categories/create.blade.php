@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Add Category</h2>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
