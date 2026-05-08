<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Status Update</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; background-color: #f5f7fb; color: #1e293b; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; padding: 40px 0; background-color: #f5f7fb; }
        .email-content { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.07); }
        .email-header { padding: 30px 40px; text-align: center; color: white; }
        .email-header h1 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }
        .email-header p { margin: 6px 0 0; font-size: 14px; opacity: 0.85; }
        .email-body { padding: 36px 40px; }
        .email-body h2 { margin-top: 0; font-size: 20px; }
        .email-body p { line-height: 1.7; color: #475569; margin: 0 0 14px; }
        .status-badge { display: inline-block; border-radius: 50px; padding: 8px 20px; font-size: 15px; font-weight: 700; margin-bottom: 24px; }
        .claim-details { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #64748b; font-size: 13px; }
        .detail-value { font-weight: 700; color: #0f172a; font-size: 13px; }
        .btn { display: inline-block; color: #ffffff; text-decoration: none; padding: 13px 30px; border-radius: 8px; font-weight: 700; font-size: 15px; margin-top: 10px; }
        .email-footer { background: #f8fafc; padding: 20px 40px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .email-footer p { margin: 4px 0; }
        .note-box { border-radius: 8px; padding: 14px 18px; font-size: 13px; line-height: 1.6; margin-top: 20px; }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-content">

        {{-- Header --}}
        <div class="email-header" style="background: {{ $isApproved ? 'linear-gradient(135deg, #064e3b, #059669)' : 'linear-gradient(135deg, #1e293b, #7f1d1d)' }};">
            <h1>InsureMate <span style="color: #a5b4fc;">PRO</span></h1>
            <p>{{ $isApproved ? 'Great news about your claim!' : 'An update on your claim' }}</p>
        </div>

        {{-- Body --}}
        <div class="email-body">
            <p style="font-size:16px;">Dear <strong>{{ $userName }}</strong>,</p>

            @if($isApproved)
                <h2 style="color:#059669;">🎉 Your Claim Has Been Approved!</h2>
                <p>We are pleased to inform you that your insurance claim has been <strong>reviewed and approved</strong> by our claims team. The settlement will be processed as per your policy terms.</p>
                <div class="status-badge" style="background:#dcfce7; color:#166534;">✅ Claim Approved</div>
            @elseif($status === 'rejected')
                <h2 style="color:#dc2626;">Your Claim Status Update</h2>
                <p>After careful review, we regret to inform you that your claim could not be approved at this time. This may be due to policy terms, incomplete documentation, or other eligibility criteria.</p>
                <div class="status-badge" style="background:#fee2e2; color:#991b1b;">❌ Claim Rejected</div>
                <p>If you believe this is an error or need clarification, please contact our support team — we are here to help.</p>
            @else
                <h2 style="color:#d97706;">Claim Status Updated</h2>
                <p>Your claim status has been updated. Please review the details below.</p>
                <div class="status-badge" style="background:#fef3c7; color:#92400e;">⏳ Status: {{ ucfirst($status) }}</div>
            @endif

            {{-- Claim Details Box --}}
            <div class="claim-details">
                <div class="detail-row">
                    <span class="detail-label">Claim Number</span>
                    <span class="detail-value" style="color:#4f46e5;">{{ $claim->claim_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Policy Number</span>
                    <span class="detail-value">{{ $claim->policy->policy_number ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Claim Amount</span>
                    <span class="detail-value">₹{{ number_format($claim->claim_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" style="color: {{ $isApproved ? '#059669' : ($status === 'rejected' ? '#dc2626' : '#d97706') }};">
                        {{ ucfirst($status) }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date Filed</span>
                    <span class="detail-value">{{ $claim->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            @if($isApproved)
            <div class="note-box" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                <strong style="color:#166534;">💡 What Happens Next?</strong><br>
                Our finance team will process the settlement within 5–7 business days. The amount will be transferred to your registered bank account.
            </div>
            @elseif($status === 'rejected')
            <div class="note-box" style="background:#fff7ed; border:1px solid #fed7aa;">
                <strong style="color:#92400e;">💡 Need Help?</strong><br>
                Contact our support team via the Help Center or raise a support ticket on your dashboard. Our team is happy to assist you.
            </div>
            @endif

            <br>
            <center>
                <a href="{{ route('home') }}" class="btn" style="background: {{ $isApproved ? '#059669' : '#6366f1' }};">
                    View My Dashboard
                </a>
            </center>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} InsureMate. All rights reserved.</p>
            <p>This is an automated email. Please do not reply directly to this email.</p>
        </div>
    </div>
</div>
</body>
</html>
