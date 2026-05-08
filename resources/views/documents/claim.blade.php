<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Claim Receipt - {{ $claim->claim_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            width: 40%;
            color: #666;
            font-weight: normal;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">InsureMate</div>
        <div class="title">Claim Submission Receipt</div>
        <div>Claim # {{ $claim->claim_number }}</div>
    </div>

    <div class="section">
        <div class="section-title">Claimant Details</div>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $claim->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $claim->user->email }}</td>
            </tr>
            <tr>
                <th>Submission Date</th>
                <td>{{ $claim->created_at->format('d M, Y H:i A') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Claim Information</div>
        <table>
            <tr>
                <th>Policy Number</th>
                <td>{{ $claim->policy->policy_number }}</td>
            </tr>
            <tr>
                <th>Plan</th>
                <td>{{ $claim->policy->plan->name }}</td>
            </tr>
            <tr>
                <th>Claim Amount</th>
                <td>${{ number_format($claim->claim_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($claim->status) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Description</div>
        <p style="padding: 10px; background: #f9f9f9; border: 1px solid #eee;">
            {{ $claim->description }}
        </p>
    </div>

    <div class="footer">
        <p>This receipt confirms that your claim has been received in our system.</p>
        <p>Please retain this document for your records.</p>
        <p>InsureMate - 123 Insurance Blvd, Policy City, 10012 | Support: +1 (555) 123-4567</p>
    </div>
</body>

</html>