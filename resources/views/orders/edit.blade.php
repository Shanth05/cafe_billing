@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Order</h2>
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" value="{{ $order->customer_name }}" required>
        </div>

        <div class="mb-3">
            <label>Item</label>
            <input type="text" name="item" class="form-control" value="{{ $order->item }}" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $order->quantity }}" required>
        </div>

        <div class="mb-3">
            <label>Total</label>
            <input type="number" name="total" class="form-control" value="{{ $order->total }}" step="0.01" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
