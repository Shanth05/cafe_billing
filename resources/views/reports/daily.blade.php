@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Daily Sales Report - {{ $date }}</h4>
    <form method="GET">
        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
    </form>
    <table class="table mt-3">
        <thead><tr><th>Invoice</th><th>Total</th><th>Date</th></tr></thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>Rs. {{ number_format($order->total, 2) }}</td>
                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h5>Total: Rs. {{ number_format($total, 2) }}</h5>
</div>
@endsection
