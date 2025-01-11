<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            background-color: #FED361; /* System yellow color */
            padding: 10px; /* Add some padding for better appearance */
        }
        .logo {
            width: 200px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px;
        }
        .charges {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .charges th, .charges td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .charges th {
            background-color: #f8f9fa;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .footer p {
            margin-bottom: 10px;
        }
        .footer-logo {
            width: 100px;
            height: auto;
            display: block;
            margin: 10px auto;
        }
        .powered-by {
            font-size: 10px;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Invoice #{{ $invoice->id }}</p>
    </div>

    <div class="invoice-info">
        <table>
            <tr>
                <td><strong>To:</strong></td>
                <td>{{ $invoice->tenant->name }} {{ $invoice->tenant->last_name }}</td>
                <td><strong>Issue Date:</strong></td>
                <td>{{ Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Room:</strong></td>
                <td>{{ $invoice->room->name }} ({{ $invoice->room->site->name }})</td>
                <td><strong>Due Date:</strong></td>
                <td>{{ Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="charges">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rent Amount</td>
                <td>R{{ number_format($invoice->amount, 2) }}</td>
            </tr>
            @if($invoice->water_charge)
            <tr>
                <td>Water Charge</td>
                <td>R{{ number_format($invoice->water_charge, 2) }}</td>
            </tr>
            @endif
            @if($invoice->electricity_charge)
            <tr>
                <td>Electricity Charge</td>
                <td>R{{ number_format($invoice->electricity_charge, 2) }}</td>
            </tr>
            @endif
            @if($invoice->other_charges)
            <tr>
                <td>Other Charges</td>
                <td>R{{ number_format($invoice->other_charges, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total Amount</td>
                <td>R{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @if($invoice->description)
    <div class="description">
        <h3>Description</h3>
        <p>{{ $invoice->description }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <div class="powered-by">Powered by</div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_black.png'))) }}" 
             class="footer-logo" 
             alt="TM System Logo">
    </div>
</body>
</html> 