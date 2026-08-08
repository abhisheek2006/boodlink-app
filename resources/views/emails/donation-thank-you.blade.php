<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You for Your Life-Saving Donation!</title>
<style>
    body { margin:0; padding:0; background-color:#F0F4F8; font-family: Inter, Arial, sans-serif; }
    .wrapper { max-width:560px; margin:0 auto; background:#FFFFFF; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(30,41,59,.06); }
    .header { background:linear-gradient(135deg,#DC2626 0%,#EA580C 100%); padding:36px 32px; text-align:center; }
    .header h1 { color:#FFFFFF; font-family:'Fraunces',Georgia,serif; font-size:24px; font-weight:600; margin:0; }
    .header p { color:rgba(255,255,255,.88); font-size:14px; margin-top:6px; }
    .body { padding:32px; }
    .greeting { font-size:16px; color:#1E293B; margin-bottom:16px; }
    .message { font-size:15px; line-height:1.6; color:#334155; margin-bottom:20px; }
    .stats-box {
        background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px;
        padding:20px; margin:24px 0; text-align:center;
    }
    .stats-box .stat-value { font-size:28px; font-weight:700; color:#DC2626; }
    .stats-box .stat-label { font-size:13px; color:#64748B; text-transform:uppercase; letter-spacing:.04em; }
    .cta { text-align:center; margin:24px 0; }
    .cta a {
        display:inline-block; padding:12px 32px; border-radius:8px;
        background:#DC2626; color:#FFFFFF; text-decoration:none; font-weight:600; font-size:15px;
    }
    .quote {
        font-style:italic; color:#64748B; text-align:center;
        padding:16px; border-top:1px solid #E2E8F0; border-bottom:1px solid #E2E8F0;
        margin:24px 0; font-size:14px;
    }
    .footer { padding:24px 32px; background:#F8FAFC; text-align:center; font-size:12px; color:#64748B; }
</style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div style="font-size:44px;">❤️</div>
            <h1>Thank You for Donating!</h1>
            <p>Your life-saving gift</p>
        </div>

        <div class="body">
            <p class="greeting">Dear {{ $user->name }},</p>

            <p class="message">
                On behalf of everyone at Blood Link and the patients whose lives your gift will touch,
                we sincerely thank you for completing a blood donation. Your courage, compassion,
                and commitment to helping others make a real difference in our community.
            </p>

            <div class="stats-box">
                <div class="stat-value">{{ $user->donor->total_donations }}</div>
                <div class="stat-label">Total Donations</div>
            </div>

            <p class="message">
                Your blood has the power to save up to <strong>three lives</strong>. Because of you,
                families facing medical crises have hope, hospitals have the supply they need,
                and someone gets the chance to fight on.
            </p>

            <div class="quote">
                "The blood you gave is now a part of someone's story of survival."
            </div>

            <p class="message">
                Please remember to take care of yourself in the days following your donation.
                Stay hydrated, rest well, and eat iron-rich foods. Your next eligible donation
                date is <strong>{{ \Carbon\Carbon::parse($user->donor->next_eligible_date)->toFormattedDateString() }}</strong>.
            </p>

            <div class="cta">
                <a href="{{ config('app.url') }}">View Your Donor Profile</a>
            </div>

            <p class="message">With heartfelt gratitude,<br><strong> — The Blood Link Team</strong></p>
        </div>

        <div class="footer">
            Blood Link · Smart Blood Bank Management System<br>
            This is an automated message. Please don't reply to this email.
        </div>
    </div>
</body>
</html>
