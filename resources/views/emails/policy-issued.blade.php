<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Policy is Ready</title>
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f5f7fb; color: #1e293b; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; padding: 40px 0; background-color: #f5f7fb; }
        .email-content { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .email-header { background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); padding: 30px 40px; text-align: center; color: white; }
        .email-header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
        .email-body { padding: 40px; }
        .email-body h2 { margin-top: 0; color: #0f172a; font-size: 20px; }
        .email-body p { line-height: 1.6; color: #475569; }
        .policy-details { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 25px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #64748b; font-size: 14px; }
        .detail-value { font-weight: 700; color: #0f172a; font-size: 14px; }
        .btn { display: inline-block; background: #6366f1; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; margin-top: 20px; transition: background 0.2s; }
        .btn:hover { background: #4f46e5; }
        .email-footer { background: #f8fafc; padding: 20px 40px; text-align: center; font-size: 13px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .email-footer p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h1>InsureMate <span style="color: #818cf8;">PRO</span></h1>
            </div>
            <div class="email-body">
                <h2>Welcome to InsureMate!</h2>
                <p>Dear {{ $policy->user->name }},</p>
                <p>Thank you for choosing InsureMate. Your payment was successful and your insurance policy is now active. We have attached your official policy document (PDF) to this email for your records.</p>
                
                <div class="policy-details">
                    <div class="detail-row">
                        <span class="detail-label">Policy Number</span>
                        <span class="detail-value" style="color: #4f46e5;">{{ $policy->policy_number }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Plan Name</span>
                        <span class="detail-value">{{ $policy->plan->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Premium Paid</span>
                        <span class="detail-value">₹{{ number_format($policy->premium_amount, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Coverage Amount</span>
                        <span class="detail-value">₹{{ number_format($policy->coverage_amount, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Valid Until</span>
                        <span class="detail-value">{{ $policy->end_date->format('M d, Y') }}</span>
                    </div>
                </div>

                <p>You can manage your policy, view coverage details, and file claims directly from your secure dashboard.</p>
                
                <center>
                    <a href="{{ route('home') }}" class="btn">View My Dashboard</a>
                </center>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} InsureMate. All rights reserved.</p>
                <p>This is an automated email, please do not reply.</p>
            </div>
        </div>
    </div>
</body>
</html>
