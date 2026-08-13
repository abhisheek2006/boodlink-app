<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Happy Birthday from Blood Link!</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: Arial, Helvetica, sans-serif;
            color: #172033;
        }

        table {
            border-collapse: collapse;
        }

        .email-wrapper {
            width: 100%;
            padding: 40px 15px;
            background: #f5f7fa;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #edf0f4;
            box-shadow: 0 10px 35px rgba(20, 33, 61, 0.08);
        }

        /* Header */

        .header {
            background: #ffffff;
            padding: 32px 30px 28px;
            text-align: center;
            border-bottom: 1px solid #edf0f4;
        }

        .birthday-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #fff0f1;
            color: #ef233c;
            font-size: 36px;
            line-height: 72px;
        }

        .brand {
            margin: 0 0 6px;
            font-size: 14px;
            font-weight: 700;
            color: #ef233c;
            letter-spacing: .3px;
        }

        .header h1 {
            margin: 0;
            color: #14213d;
            font-size: 25px;
            line-height: 1.35;
            font-weight: 700;
        }

        .header p {
            margin: 8px 0 0;
            color: #7a8494;
            font-size: 13px;
        }

        /* Birthday Banner */

        .birthday-banner {
            margin: 25px 30px 5px;
            padding: 22px 20px;
            border-radius: 15px;
            background: linear-gradient(
                135deg,
                #fff4f5 0%,
                #fff9f9 100%
            );
            border: 1px solid #ffe0e3;
            text-align: center;
        }

        .birthday-emojis {
            font-size: 36px;
            letter-spacing: 7px;
            margin-bottom: 10px;
        }

        .birthday-banner-title {
            margin: 0;
            color: #ef233c;
            font-size: 18px;
            font-weight: 700;
        }

        .birthday-banner-text {
            margin: 6px 0 0;
            color: #7a8494;
            font-size: 12px;
        }

        /* Body */

        .body {
            padding: 28px 35px 35px;
        }

        .greeting {
            margin: 0 0 18px;
            color: #172033;
            font-size: 16px;
            font-weight: 600;
        }

        .message {
            margin: 0 0 18px;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.75;
        }

        .highlight {
            margin: 24px 0;
            padding: 16px 18px;
            background: #f8fafc;
            border-left: 4px solid #ef233c;
            border-radius: 8px;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.65;
        }

        .highlight strong {
            color: #172033;
        }

        /* CTA */

        .cta {
            text-align: center;
            margin: 28px 0;
        }

        .cta a {
            display: inline-block;
            padding: 13px 30px;
            border-radius: 11px;
            background: #ef233c;
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 5px 14px rgba(239, 35, 60, .18);
        }

        .cta a:hover {
            background: #d91f35;
        }

        /* Closing */

        .closing {
            margin: 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.7;
        }

        .closing strong {
            color: #172033;
        }

        /* Footer */

        .divider {
            height: 1px;
            background: #edf0f4;
            margin: 0 35px;
        }

        .footer {
            padding: 25px 30px 28px;
            background: #fafbfc;
            text-align: center;
        }

        .footer-brand {
            margin-bottom: 6px;
            color: #172033;
            font-size: 14px;
            font-weight: 700;
        }

        .footer-brand span {
            color: #ef233c;
        }

        .footer-text {
            margin: 0;
            color: #8a94a6;
            font-size: 11px;
            line-height: 1.6;
        }

        .heart {
            color: #ef233c;
        }

        /* Mobile */

        @media only screen and (max-width: 600px) {

            .email-wrapper {
                padding: 20px 10px;
            }

            .email-container {
                border-radius: 15px;
            }

            .header {
                padding: 27px 20px 25px;
            }

            .header h1 {
                font-size: 22px;
            }

            .birthday-banner {
                margin: 20px 18px 5px;
            }

            .body {
                padding: 24px 20px 28px;
            }

            .divider {
                margin: 0 20px;
            }

            .footer {
                padding: 22px 18px 25px;
            }

            .birthday-emojis {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
>
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

                        <div class="birthday-icon">
                            🎂
                        </div>

                        <div class="brand">
                            BLOOD LINK
                        </div>

                        <h1>
                            Happy Birthday, {{ $user->name }}!
                        </h1>

                        <p>
                            A special celebration from the Blood Link family
                        </p>

                    </td>
                </tr>


                {{-- Birthday Banner --}}
                <tr>
                    <td>

                        <div class="birthday-banner">

                            <div class="birthday-emojis">
                                🎉 🎂 🎉
                            </div>

                            <p class="birthday-banner-title">
                                Today is all about you!
                            </p>

                            <p class="birthday-banner-text">
                                Wishing you happiness, health and wonderful memories.
                            </p>

                        </div>

                    </td>
                </tr>


                {{-- Body --}}
                <tr>
                    <td class="body">

                        <p class="greeting">
                            Dear {{ $user->name }},
                        </p>


                        <p class="message">
                            Today is your special day, and we wanted to
                            take a moment to celebrate you!
                        </p>


                        <p class="message">
                            On your birthday, we're reminded that every
                            gift of life — whether it's your time, your
                            kindness, or your generous spirit — makes the
                            world a little brighter for those who need it most.
                        </p>


                        <div class="highlight">

                            <strong>
                                A special thank you from Blood Link.
                            </strong>

                            <br>

                            As a valued member of our community, your
                            compassion and willingness to help others
                            don't go unnoticed.

                        </div>


                        <p class="message">
                            May your year ahead be filled with the same
                            warmth, health, and joy that you share with
                            others every single day.
                        </p>


                        {{-- CTA --}}
                        <div class="cta">

                            <a href="{{ config('app.url') }}">
                                Visit Blood Link
                            </a>

                        </div>


                        <p class="closing">

                            Wishing you a fantastic birthday and a
                            wonderful year ahead!

                            <br><br>

                            <strong>
                                — The Blood Link Team ❤️
                            </strong>

                        </p>

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

                        <p class="footer-text" style="margin-top:9px;">
                            Made with
                            <span class="heart">♥</span>
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