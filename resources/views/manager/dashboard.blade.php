@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2>Welcome, Manager!</h2>
            <p>Monitor sales, manage orders, and oversee staff operations.</p>
            <div class="mt-3">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">View Categories</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">View Products</a>
                <a href="#" class="btn btn-info">View Sales Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection