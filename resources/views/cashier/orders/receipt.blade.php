<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Receipt #{{ $order->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            background: #fff;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        .info {
            margin-bottom: 8px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            font-size: 14px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 8px 4px;
            text-align: left;
        }
        tfoot td {
            font-weight: bold;
            font-size: 15px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: none;
                color: #000;
            }
            button.print-btn {
                display: none;
            }
        }
        button.print-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Receipt #{{ $order->invoice_number }}</h2>

    <p class="info"><strong>Cashier:</strong> {{ $cashierName }}</p>
    <p class="info"><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rs. {{ number_format($item->price, 2) }}</td>
                    <td>Rs. {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Grand Total</td>
                <td>Rs. {{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- Payment summary moved below the table --}}
    <p class="info"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>

    @if($order->payment_method === 'cash')
        <p class="info"><strong>Paid Amount:</strong> Rs. {{ number_format($order->amount_given ?? 0, 2) }}</p>
        <p class="info"><strong>Balance Returned:</strong> Rs. {{ number_format($order->balance ?? 0, 2) }}</p>
    @endif

    <button class="print-btn" onclick="window.print()">Print Receipt</button>

    <!-- Back to POS Button -->
    <button class="print-btn" style="background-color: #007bff; margin-top: 10px;" onclick="window.location.href='{{ url('/cashier/pos') }}'">
        Back to POS
    </button>
    
</body>
</html>
