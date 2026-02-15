<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 14px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2D6A4F;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .company-info h1 {
            color: #2D6A4F;
            margin: 0;
            font-size: 24px;
        }

        .invoice-details {
            text-align: right;
        }

        .details-container {
            width: 100%;
            margin-bottom: 30px;
        }

        .details-container td {
            vertical-align: top;
        }

        .customer-info {
            width: 50%;
        }

        .order-info {
            width: 50%;
            text-align: right;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        .table td {
            border-bottom: 1px solid #dee2e6;
            padding: 10px;
        }

        .total-section {
            width: 100%;
            text-align: right;
        }

        .total-section table {
            width: 250px;
            margin-left: auto;
        }

        .total-section td {
            padding: 5px 10px;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #2D6A4F;
            border-top: 2px solid #2D6A4F;
            margin-top: 10px;
            padding-top: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table class="details-container">
            <tr>
                <td class="company-info">
                    <h1>Dipika Store</h1>
                    <p>Your Trusted Grocery Partner</p>
                </td>
                <td class="invoice-details">
                    <h2 style="color: #2D6A4F;">INVOICE</h2>
                    <p>#INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p>Date: {{ $order->created_at->format('d M Y') }}</p>
                </td>
            </tr>
        </table>

        <table class="details-container">
            <tr>
                <td class="customer-info">
                    <h3 style="color: #2D6A4F; margin-bottom: 10px;">Bill To:</h3>
                    <p><strong>{{ $order->customer_name }}</strong></p>
                    <p>{{ $order->phone }}</p>
                    <p style="white-space: pre-wrap;">{{ $order->address }}</p>
                </td>
                <td class="order-info">
                    <h3 style="color: #2D6A4F; margin-bottom: 10px;">Order Summary:</h3>
                    <p>Order ID: #{{ $order->id }}</p>
                    <p>Status: {{ ucfirst($order->status) }}</p>
                    <p>Payment: {{ ucfirst($order->payment_method) }}</p>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product ? $item->product->name : 'Product Deleted' }}</td>
                        <td>&#8377;{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&#8377;{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>&#8377;{{ number_format($order->total_price, 2) }}</td>
                </tr>
                <tr>
                    <td>Delivery Charge:</td>
                    <td>&#8377;0.00</td>
                </tr>
                <tr class="grand-total">
                    <td>Total:</td>
                    <td>&#8377;{{ number_format($order->total_price, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for shopping with Dipika Store!</p>
            <p>This is a computer-generated invoice and doesn't require a signature.</p>
        </div>
    </div>
</body>

</html>