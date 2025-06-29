@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">📆 Monthly Sales Report – {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h4>

    <!-- Month Picker -->
    <form method="GET" class="mb-3">
        <input type="month" name="month" value="{{ $month }}" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
    </form>

    <!-- Monthly Sales Chart -->
    <canvas id="monthlyChart" height="100" class="mb-4"></canvas>

    <!-- Orders Table -->
    <table class="table table-bordered">
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

    <!-- Total Sales Summary -->
    <div class="text-center mt-4">
        <span class="fs-5 fw-bold text-success bg-light px-4 py-2 border rounded shadow-sm">
            Total Sales: Rs. {{ number_format($total, 2) }}
        </span>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Rendering -->
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($orders->pluck('created_at')->map(fn($d) => $d->format('d M'))->toArray()) !!},
            datasets: [{
                label: 'Sales Amount (Rs.)',
                data: {!! json_encode($orders->pluck('total')->toArray()) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
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
