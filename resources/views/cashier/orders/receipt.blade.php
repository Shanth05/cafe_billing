<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 8px 4px;
            text-align: left;
        }
        tfoot td {
            font-weight: bold;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            /* Hide anything unwanted when printing */
        }
    </style>
</head>
<body>
    <h2>Receipt #{{ $order->id }}</h2>
    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th><th>Qty</th><th>Total (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->item }}</td>
                <td>{{ $order->quantity }}</td>
                <td>Rs. {{ number_format($order->total, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>Rs. {{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <button onclick="window.print()" style="width:100%; padding:10px; font-size:16px; cursor:pointer;">
        Print Receipt
    </button>
</body>
</html>
