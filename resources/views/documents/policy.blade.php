<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Policy Document - {{ $policy->policy_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0056b3;
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

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: white;
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">InsureMate</div>
        <div class="title">Certificate of Insurance</div>
        <div>Policy No: {{ $policy->policy_number }}</div>
    </div>

    <div class="section">
        <div class="section-title">Policyholder Details</div>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $policy->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $policy->user->email }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Plan Details</div>
        <table>
            <tr>
                <th>Plan Name</th>
                <td>{{ $policy->plan->name }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $policy->plan->category->name }}</td>
            </tr>
            <tr>
                <th>Policy Period</th>
                <td>{{ $policy->plan->policy_period_years }} Years</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Coverage & Premium Information</div>
        <table>
            <tr>
                <th>Coverage Amount</th>
                <td>${{ number_format($policy->coverage_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Annual Premium</th>
                <td>${{ number_format($policy->premium_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Policy Start Date</th>
                <td>{{ $policy->start_date->format('d M, Y') }}</td>
            </tr>
            <tr>
                <th>Policy End Date</th>
                <td>{{ $policy->end_date->format('d M, Y') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class="badge">{{ ucfirst($policy->status) }}</span></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Included Benefits</div>
        @if(is_array($policy->plan->benefits))
            <ul>
                @foreach($policy->plan->benefits as $benefit)
                    <li>{{ trim($benefit) }}</li>
                @endforeach
            </ul>
        @else
            No specific benefits listed.
        @endif
    </div>

    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
        <p>Generated on: {{ now()->format('d M, Y H:i A') }}</p>
        <p>InsureMate - 123 Insurance Blvd, Policy City, 10012 | Support: +1 (555) 123-4567</p>
    </div>
</body>

</html>