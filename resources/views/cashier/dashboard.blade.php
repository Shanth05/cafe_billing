@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2>Welcome, Cashier!</h2>
            <p>Process bills and manage daily transactions.</p>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('cashier.pos') }}" class="btn btn-primary">Create New Order</a>
                <a href="{{ route('cashier.orders') }}" class="btn btn-secondary">View All Orders</a>
            </div>
        </div>
    </div>
</div>
@endsection
