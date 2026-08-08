<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $subject }}</title>
<style>
    body { margin:0; padding:0; background-color:#F0F4F8; font-family: Inter, Arial, sans-serif; }
    .wrapper { max-width:560px; margin:0 auto; background:#FFFFFF; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(30,41,59,.06); }
    .header { background:linear-gradient(135deg,#DC2626 0%,#EA580C 100%); padding:28px 32px; text-align:center; }
    .header h1 { color:#FFFFFF; font-family:'Fraunces',Georgia,serif; font-size:22px; font-weight:600; margin:0; }
    .body { padding:32px; }
    .content { font-size:15px; line-height:1.6; color:#334155; word-wrap:break-word; }
    .footer { padding:24px 32px; background:#F8FAFC; text-align:center; font-size:12px; color:#64748B; }
    p { margin:0 0 16px 0; }
    a { color:#DC2626; }
</style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div style="font-size:32px;">📧</div>
            <h1>{{ $subject }}</h1>
        </div>

        <div class="body">
            <div class="content">
                {!! $body !!}
            </div>
        </div>

        <div class="footer">
            Blood Link · Smart Blood Bank Management System<br>
            This is an automated message. Please don't reply to this email.
        </div>
    </div>
</body>
</html>
