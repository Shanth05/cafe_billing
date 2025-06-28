@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">All Orders</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Invoice Number</th>
                    <th>Total</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>Rs. {{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
