<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lease Agreement #{{ $leaseAgreement->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 200px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
        .agreement-info {
            margin-bottom: 30px;
        }
        .agreement-info table {
            width: 100%;
        }
        .agreement-info td {
            padding: 5px;
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
        <h1>LEASE AGREEMENT</h1>
        <p>Agreement #{{ $leaseAgreement->id }}</p>
    </div>

    <div class="agreement-info">
        <table>
            <tr>
                <td><strong>Tenant:</strong></td>
                <td>{{ $leaseAgreement->tenant->name }} {{ $leaseAgreement->tenant->last_name }}</td>
                <td><strong>Start Date:</strong></td>
                <td>{{ Carbon\Carbon::parse($leaseAgreement->start_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Property:</strong></td>
                <td>
                    {{ $leaseAgreement->room->site->name }}<br>
                    {{ $leaseAgreement->room->site->address_line1 }}<br>
                    @if($leaseAgreement->room->site->address_line2)
                        {{ $leaseAgreement->room->site->address_line2 }}<br>
                    @endif
                    {{ $leaseAgreement->room->site->city }}{{ $leaseAgreement->room->site->postal_code ? ', ' . $leaseAgreement->room->site->postal_code : '' }}
                </td>
                <td><strong>End Date:</strong></td>
                <td>{{ Carbon\Carbon::parse($leaseAgreement->end_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Room:</strong></td>
                <td>{{ $leaseAgreement->room->name }}</td>
                <td><strong>Status:</strong></td>
                <td>{{ $leaseAgreement->is_terminated ? 'Terminated' : 'Active' }}</td>
            </tr>
            @if($leaseAgreement->is_terminated && $leaseAgreement->termination_date)
            <tr>
                <td><strong>Termination Date:</strong></td>
                <td colspan="3">{{ Carbon\Carbon::parse($leaseAgreement->termination_date)->format('d M Y') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>This document serves as an official lease agreement record.</p>
        <div class="powered-by">Powered by</div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_black.png'))) }}" 
             class="footer-logo" 
             alt="TM System Logo">
    </div>
</body>
</html> 