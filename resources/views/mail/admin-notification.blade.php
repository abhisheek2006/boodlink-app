<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $subject }}</title>
</head>
<body style="margin:0; padding:0; background-color:#FBF7F4; font-family: Georgia, 'Times New Roman', serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF7F4; padding: 32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px; width:100%; background-color:#FFFFFF; border:1px solid #E9E2DC; border-radius:10px; overflow:hidden;">

    <tr>
        <td style="background-color:#C81E3A; padding:28px 32px;">
            <span style="font-family: Georgia, 'Times New Roman', serif; font-size:22px; font-weight:bold; color:#FFFFFF;">
                &#129766;&nbsp; Blood Link
            </span>
        </td>
    </tr>

    <tr>
        <td style="padding:36px 32px 8px 32px; font-family: Arial, Helvetica, sans-serif;">
            <h1 style="margin:0 0 16px 0; font-family: Georgia, 'Times New Roman', serif; font-size:22px; color:#1B1B1F;">
                {{ $subject }}
            </h1>
            <div style="margin:0 0 24px 0; font-size:15px; line-height:1.6; color:#1B1B1F;">
                {!! nl2br(e($body)) !!}
            </div>
        </td>
    </tr>

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
