<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $subject }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            font-family: Arial, Helvetica, sans-serif;
            color: #172033;
        }

        table {
            border-collapse: collapse;
        }

        .email-wrapper {
            width: 100%;
            padding: 40px 15px;
            background-color: #f5f7fa;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #edf0f4;
            box-shadow: 0 8px 30px rgba(20, 33, 61, 0.08);
        }

        /* Header */

        .header {
            padding: 30px 35px;
            background: #ffffff;
            border-bottom: 1px solid #edf0f4;
            text-align: center;
        }

        .logo {
            display: inline-block;
            margin-bottom: 14px;
        }

        .logo-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto;
            border-radius: 50%;
            background: #fff0f1;
            color: #ef233c;
            font-size: 29px;
            line-height: 58px;
            text-align: center;
        }

        .brand-name {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: -0.4px;
            color: #111827;
        }

        .brand-name span {
            color: #ef233c;
        }

        .tagline {
            margin: 6px 0 0;
            font-size: 12px;
            color: #7a8494;
        }

        /* Subject */

        .subject-section {
            padding: 28px 35px 10px;
        }

        .subject-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #fff0f1;
            color: #ef233c;
            font-size: 21px;
            line-height: 42px;
            text-align: center;
            margin-bottom: 13px;
        }

        .subject {
            margin: 0;
            color: #14213d;
            font-size: 23px;
            line-height: 1.35;
            font-weight: 700;
        }

        /* Content */

        .content-section {
            padding: 20px 35px 35px;
        }

        .content {
            font-size: 15px;
            line-height: 1.7;
            color: #4b5563;
            word-wrap: break-word;
        }

        .content p {
            margin: 0 0 17px;
        }

        .content a {
            color: #ef233c;
            text-decoration: none;
            font-weight: 600;
        }

        .content a:hover {
            text-decoration: underline;
        }

        .content strong {
            color: #172033;
        }

        .content img {
            max-width: 100%;
            height: auto;
        }

        /* Divider */

        .divider {
            height: 1px;
            background: #edf0f4;
            margin: 0 35px;
        }

        /* Footer */

        .footer {
            padding: 25px 35px 30px;
            background: #fafbfc;
            text-align: center;
        }

        .footer-brand {
            font-size: 14px;
            font-weight: 700;
            color: #172033;
            margin-bottom: 7px;
        }

        .footer-brand span {
            color: #ef233c;
        }

        .footer-text {
            margin: 0;
            font-size: 11px;
            line-height: 1.6;
            color: #8a94a6;
        }

        .footer-heart {
            color: #ef233c;
        }

        /* Mobile */

        @media only screen and (max-width: 600px) {

            .email-wrapper {
                padding: 20px 10px;
            }

            .email-container {
                border-radius: 14px;
            }

            .header {
                padding: 25px 20px;
            }

            .subject-section {
                padding: 24px 22px 10px;
            }

            .content-section {
                padding: 18px 22px 28px;
            }

            .divider {
                margin: 0 22px;
            }

            .footer {
                padding: 22px 20px 25px;
            }

            .subject {
                font-size: 20px;
            }

            .brand-name {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td class="email-wrapper">

            <table
                class="email-container"
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
            >

                {{-- Header --}}
                <tr>
                    <td class="header">

                        <div class="logo">
                            <div class="logo-icon">
                                ❤️
                            </div>
                        </div>

                        <h1 class="brand-name">
                            Blood <span>Link</span>
                        </h1>

                        <p class="tagline">
                            Save a life, Be a hero ❤️
                        </p>

                    </td>
                </tr>


                {{-- Subject --}}
                <tr>
                    <td class="subject-section">

                        <div class="subject-icon">
                            ✉
                        </div>

                        <h2 class="subject">
                            {{ $subject }}
                        </h2>

                    </td>
                </tr>


                {{-- Email Content --}}
                <tr>
                    <td class="content-section">

                        <div class="content">
                            {!! $body !!}
                        </div>

                    </td>
                </tr>


                {{-- Divider --}}
                <tr>
                    <td>
                        <div class="divider"></div>
                    </td>
                </tr>


                {{-- Footer --}}
                <tr>
                    <td class="footer">

                        <div class="footer-brand">
                            Blood <span>Link</span>
                        </div>

                        <p class="footer-text">
                            Smart Blood Bank Management System
                        </p>

                        <p class="footer-text">
                            This is an automated message.
                            Please don't reply to this email.
                        </p>

                        <p class="footer-text" style="margin-top: 10px;">
                            Made with <span class="footer-heart">♥</span>
                            to help save lives.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>