@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">🗓️ Daily Sales Report – {{ $date }}</h4>

    <!-- Date Filter -->
    <form method="GET" class="mb-3">
        <input type="date" name="date" value="{{ $date }}" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
    </form>

    <!-- Sales Chart -->
    <canvas id="dailyChart" height="100" class="mb-4"></canvas>

    <!-- Orders Table -->
    <table class="table table-bordered">
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

    <!-- Total Sales Summary -->
    <div class="text-center mt-4">
        <span class="fs-5 fw-bold text-primary bg-light px-4 py-2 border rounded shadow-sm">
            Total Sales: Rs. {{ number_format($total, 2) }}
        </span>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Rendering -->
<script>
    const ctx = document.getElementById('dailyChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($orders->pluck('created_at')->map(fn($d) => $d->format('H:i'))->toArray()) !!},
            datasets: [{
                label: 'Sales Amount (Rs.)',
                data: {!! json_encode($orders->pluck('total')->toArray()) !!},
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#858796', '#fd7e14', '#20c997', '#6f42c1', '#0d6efd'
                ],
                borderRadius: 5,
                borderSkipped: false
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
