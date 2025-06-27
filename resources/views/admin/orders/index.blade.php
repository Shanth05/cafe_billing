@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Manage Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th>Customer Name</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Total (Rs.)</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->item }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>
                    <!-- View Button -->
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewOrderModal{{ $order->id }}">
                        View
                    </button>

                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                        Edit
                    </button>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- View Modal -->
            <div class="modal fade" id="viewOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewOrderLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="viewOrderLabel{{ $order->id }}">Bill for Order #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Item:</strong> {{ $order->item }}</p>
                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                            <p><strong>Total:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="editOrderLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editOrderLabel{{ $order->id }}">Edit Order #{{ $order->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Item</label>
                                    <input type="text" name="item" class="form-control" value="{{ old('item', $order->item) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $order->quantity) }}" min="1" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total (Rs.)</label>
                                    <input type="number" step="0.01" name="total" class="form-control" value="{{ old('total', $order->total) }}" min="0" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
