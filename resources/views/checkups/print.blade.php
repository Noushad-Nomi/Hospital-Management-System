<!DOCTYPE html>
<html>
<head>
    <title>Checkup Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; }
        .invoice-box { border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: auto; }
        table { width: 100%; }
        th, td { padding: 8px; text-align: left; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #777; }
        .btn-print { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Patient Checkup Invoice</h2>
        <table>
            <tr>
                <th>Patient Name:</th>
                <td>{{ $checkup->patient->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Doctor:</th>
                <td>{{ $checkup->doctor->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ \Carbon\Carbon::parse($checkup->date)->format('d-m-Y') }}</td>
            </tr>

             <tr>
                <th>Phone:</th>
                <td>{{ $checkup->patient->phone ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Diagnosis:</th>
                <td>{{ $checkup->diagnosis }}</td>
            </tr>
            <tr>
                <th>Checkup Fee:</th>
                <td>Rs. {{ $checkup->fee }}</td>
            </tr>
        </table>

        <div class="btn-print">
            <button onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
