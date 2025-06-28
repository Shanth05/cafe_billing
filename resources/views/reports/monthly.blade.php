@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">📆 Monthly Sales Report – {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h4>

    <form method="GET" class="mb-3">
        <input type="month" name="month" value="{{ $month }}" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
    </form>

    <canvas id="monthlyChart" height="100"></canvas>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Invoice</th>
                <th>Total (Rs.)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ number_format($order->total, 2) }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <strong>Total Sales:</strong> Rs. {{ number_format($total, 2) }}
    </div>
</div>

<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($orders->pluck('created_at')->map(fn($d) => $d->format('d M'))->toArray()) !!},
            datasets: [{
                label: 'Sales Amount (Rs.)',
                data: {!! json_encode($orders->pluck('total')->toArray()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.4)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        }
    });
</script>
@endsection
