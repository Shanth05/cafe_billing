@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">🗓️ Daily Sales Report – {{ $date }}</h4>

    <form method="GET" class="mb-3">
        <input type="date" name="date" value="{{ $date }}" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
    </form>

    <canvas id="dailyChart" height="100"></canvas>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Invoice</th>
                <th>Total (Rs.)</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ number_format($order->total, 2) }}</td>
                <td>{{ $order->created_at->format('H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <strong>Total Sales:</strong> Rs. {{ number_format($total, 2) }}
    </div>
</div>

<script>
    const ctx = document.getElementById('dailyChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($orders->pluck('created_at')->map(fn($d) => $d->format('H:i'))->toArray()) !!},
            datasets: [{
                label: 'Sales Amount (Rs.)',
                data: {!! json_encode($orders->pluck('total')->toArray()) !!},
                backgroundColor: '#4e73df'
            }]
        }
    });
</script>
@endsection
