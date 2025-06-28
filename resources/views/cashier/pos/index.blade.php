@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cashier POS</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Product Add Form --}}
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

    {{-- Prepare cart and grand total --}}
    @php
        $cart = session('cart', []);
        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }
    @endphp

    {{-- Cart and Checkout --}}
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
                        @foreach($cart as $item)
                            @php
                                $total = $item['price'] * $item['quantity'];
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
                            <td><strong>Rs.{{ number_format($grandTotal, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Hidden input to pass total to backend --}}
                <input type="hidden" name="total" value="{{ $grandTotal }}">

                {{-- Payment Method --}}
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select" required onchange="toggleCashFields()">
                        <option value="">-- Select Payment Method --</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="mobile">Mobile Payment</option>
                    </select>
                </div>

                {{-- Cash-only fields --}}
                <div id="cashFields" style="display:none;">
                    <div class="mb-3">
                        <label for="amount_given" class="form-label">Paid Amount (Rs.)</label>
                        <input type="number" name="amount_given" id="amount_given" class="form-control" min="0" step="0.01" oninput="calculateBalance()" />
                    </div>
                    <div class="mb-3">
                        <label for="balance" class="form-label">Balance (Rs.)</label>
                        <input type="text" id="balance" class="form-control" readonly />
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Checkout</button>
                </div>
            </form>
        </div>
    @endif
</div>

{{-- Scripts --}}
<script>
    function toggleCashFields() {
        const paymentMethod = document.getElementById('payment_method').value;
        const cashFields = document.getElementById('cashFields');
        if (paymentMethod === 'cash') {
            cashFields.style.display = 'block';
        } else {
            cashFields.style.display = 'none';
            document.getElementById('amount_given').value = '';
            document.getElementById('balance').value = '';
        }
    }

    function calculateBalance() {
        const paid = parseFloat(document.getElementById('amount_given').value || 0);
        const total = {{ $grandTotal }};
        const balance = paid - total;
        document.getElementById('balance').value = balance >= 0 ? balance.toFixed(2) : '0.00';
    }
</script>
@endsection
