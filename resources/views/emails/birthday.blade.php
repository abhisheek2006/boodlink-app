<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Happy Birthday from Blood Link!</title>
<style>
    body { margin:0; padding:0; background-color:#F0F4F8; font-family: Inter, Arial, sans-serif; }
    .wrapper { max-width:560px; margin:0 auto; background:#FFFFFF; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(30,41,59,.06); }
    .header { background:linear-gradient(135deg,#DC2626 0%,#EA580C 100%); padding:36px 32px; text-align:center; }
    .header h1 { color:#FFFFFF; font-family:'Fraunces',Georgia,serif; font-size:26px; font-weight:600; margin:0; }
    .header p { color:rgba(255,255,255,.88); font-size:14px; margin-top:6px; }
    .body { padding:32px; }
    .greeting { font-size:16px; color:#1E293B; margin-bottom:16px; }
    .message { font-size:15px; line-height:1.6; color:#334155; margin-bottom:24px; }
    .birthday-cake { text-align:center; font-size:48px; margin:24px 0; }
    .cta { text-align:center; margin:24px 0; }
    .cta a {
        display:inline-block; padding:12px 32px; border-radius:8px;
        background:#DC2626; color:#FFFFFF; text-decoration:none; font-weight:600; font-size:15px;
    }
    .footer { padding:24px 32px; background:#F8FAFC; text-align:center; font-size:12px; color:#64748B; }
</style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div style="font-size:40px;">🎂</div>
            <h1>Happy Birthday, {{ $user->name }}!</h1>
            <p>A special day from the Blood Link family</p>
        </div>

        <div class="body">
            <p class="greeting">Dear {{ $user->name }},</p>

            <div class="birthday-cake">🎉 🎂 🎉</div>

            <p class="message">
                Today is your special day, and we wanted to take a moment to celebrate you!
                On your birthday, we're reminded that every gift of life — whether it's your
                time, your kindness, or your generous spirit — makes the world a little brighter
                for those who need it most.
            </p>

            <p class="message">
                As a valued member of the Blood Link community, your compassion and willingness
                to help others don't go unnoticed. May your year ahead be filled with the same
                warmth, health, and joy that you share with others every single day.
            </p>

            <div class="cta">
                <a href="{{ config('app.url') }}">Visit Blood Link</a>
            </div>

            <p class="message">Wishing you a fantastic birthday and a wonderful year ahead!<br><strong> — The Blood Link Team</strong></p>
        </div>

        <div class="footer">
            Blood Link · Smart Blood Bank Management System<br>
            This is an automated message. Please don't reply to this email.
        </div>
    </div>
</body>
</html>
