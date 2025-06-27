@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cashier POS</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('cashier.pos.add') }}" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-select" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Rs.{{ $product->price }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </div>
    </form>

    @php $cart = session('cart', []); @endphp

    @if ($cart)
        <div class="mt-4">
            <h4>Cart</h4>
            <form method="POST" action="{{ route('cashier.pos.checkout') }}">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($cart as $item)
                            @php
                                $total = $item['price'] * $item['quantity'];
                                $grandTotal += $total;
                            @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rs.{{ $item['price'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rs.{{ $total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Grand Total</strong></td>
                            <td><strong>Rs.{{ $grandTotal }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Checkout</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
