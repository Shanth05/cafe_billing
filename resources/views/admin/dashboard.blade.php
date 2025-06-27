@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2>Welcome, Admin!</h2>
            <p>You have full access to manage users, settings, and reports.</p>
            <div class="mt-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Manage Categories</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Manage Products</a>
            </div>
        </div>
    </div>
</div>
@endsection