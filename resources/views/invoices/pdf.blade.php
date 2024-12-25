<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .invoice-box table {
            width: 100%;
            line-height: 24px;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 10px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }
        .invoice-box table th {
            padding: 10px;
            background: #f4f4f4;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Invoice #{{ $invoice->invoice_number }}</h2>
        <p><strong>Issued Date:</strong> {{ $invoice->issued_date->format('Y-m-d') }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}</p>
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product/Service</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->product->title ?? 'Custom Request' }}</td>
                        <td>{{ $order->quantity ?? 1 }}</td>
                        <td>@rupiah($order->product->price ?? $order->customRequest->price)</td>
                        <td>@rupiah(($order->product->price ?? $order->customRequest->price) * ($order->quantity ?? 1))</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <p><strong>Total Amount:</strong> @rupiah($invoice->total_amount)</p>
        <p><strong>Discount:</strong> @rupiah($invoice->discount_amount)</p>
        <p class="total"><strong>Grand Total:</strong> @rupiah($invoice->total_amount - $invoice->discount_amount)</p>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
