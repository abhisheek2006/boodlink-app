<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Your Blood Link Password</title>
</head>
<body style="margin:0; padding:0; background-color:#FBF7F4; font-family: Georgia, 'Times New Roman', serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF7F4; padding: 32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px; width:100%; background-color:#FFFFFF; border:1px solid #E9E2DC; border-radius:10px; overflow:hidden;">

    <!-- Header -->
    <tr>
        <td style="background-color:#C81E3A; padding:28px 32px;">
            <span style="font-family: Georgia, 'Times New Roman', serif; font-size:22px; font-weight:bold; color:#FFFFFF;">
                &#129766;&nbsp; Blood Link
            </span>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:36px 32px 8px 32px; font-family: Arial, Helvetica, sans-serif;">
            <h1 style="margin:0 0 16px 0; font-family: Georgia, 'Times New Roman', serif; font-size:22px; color:#1B1B1F;">
                Reset your password
            </h1>
            <p style="margin:0 0 16px 0; font-size:15px; line-height:1.6; color:#1B1B1F;">
                Hi {{ $user->name }},
            </p>
            <p style="margin:0 0 24px 0; font-size:15px; line-height:1.6; color:#1B1B1F;">
                We received a request to reset the password for your Blood Link account
                (<strong>{{ $user->email }}</strong>). Click the button below to choose a new one.
            </p>
        </td>
    </tr>

    <!-- CTA button -->
    <tr>
        <td align="center" style="padding: 0 32px 32px 32px; font-family: Arial, Helvetica, sans-serif;">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="border-radius:6px; background-color:#C81E3A;">
                        <a href="{{ $url }}"
                           style="display:inline-block; padding:14px 32px; font-size:15px; font-weight:bold;
                                  color:#FFFFFF; text-decoration:none; border-radius:6px;">
                            Reset Password
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Fallback link + expiry -->
    <tr>
        <td style="padding: 0 32px 28px 32px; font-family: Arial, Helvetica, sans-serif;">
            <p style="margin:0 0 12px 0; font-size:13px; line-height:1.6; color:#6B6F76;">
                This link will expire in {{ $expiryMinutes }} minutes. If the button above doesn't work,
                copy and paste this URL into your browser:
            </p>
            <p style="margin:0; font-size:13px; line-height:1.6; word-break:break-all;">
                <a href="{{ $url }}" style="color:#C81E3A;">{{ $url }}</a>
            </p>
        </td>
    </tr>

    <!-- Divider -->
    <tr>
        <td style="padding: 0 32px;">
            <div style="border-top:1px solid #E9E2DC;"></div>
        </td>
    </tr>

    <!-- Safety note -->
    <tr>
        <td style="padding:24px 32px; font-family: Arial, Helvetica, sans-serif;">
            <p style="margin:0; font-size:13px; line-height:1.6; color:#6B6F76;">
                If you didn't request a password reset, no action is needed — your account is safe
                and your password hasn't been changed. This request came from someone who knew your
                email address; if it wasn't you, you can safely ignore this email.
            </p>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background-color:#FBF7F4; padding:20px 32px; font-family: Arial, Helvetica, sans-serif;" align="center">
            <p style="margin:0; font-size:12px; color:#6B6F76;">
                Blood Link — Smart Blood Bank Management System
            </p>
            <p style="margin:4px 0 0 0; font-size:12px; color:#6B6F76;">
                This is an automated message. Please don't reply to this email.
            </p>
        </td>
    </tr>

</table>
</td>
</tr>
</table>
</body>
</html>
