<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thank You for Your Life-Saving Donation!</title>

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

        .donation-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #fff0f1;
            color: #ef233c;
            font-size: 35px;
            line-height: 72px;
        }

        .brand {
            margin: 0 0 6px;
            color: #ef233c;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .header h1 {
            margin: 0;
            color: #14213d;
            font-size: 24px;
            line-height: 1.4;
            font-weight: 700;
        }

        .header p {
            margin: 8px 0 0;
            color: #7a8494;
            font-size: 13px;
        }

        /* Success Banner */

        .success-banner {
            margin: 24px 30px 5px;
            padding: 18px 20px;
            border-radius: 14px;
            background: #f0fdf7;
            border: 1px solid #d5f3e5;
            text-align: center;
        }

        .success-title {
            margin: 0;
            color: #14865d;
            font-size: 16px;
            font-weight: 700;
        }

        .success-text {
            margin: 6px 0 0;
            color: #5f766d;
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

        .message strong {
            color: #172033;
        }

        /* Donation Stats */

        .stats-box {
            margin: 25px 0;
            padding: 22px 15px;
            background: #fff7f8;
            border: 1px solid #ffe0e3;
            border-radius: 15px;
            text-align: center;
        }

        .stats-icon {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #ef233c;
            font-size: 32px;
            line-height: 1.2;
            font-weight: 700;
        }

        .stat-label {
            margin-top: 5px;
            color: #7a8494;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* Impact Box */

        .impact-box {
            margin: 24px 0;
            padding: 17px 18px;
            background: #f8fafc;
            border-left: 4px solid #ef233c;
            border-radius: 8px;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.65;
        }

        .impact-box strong {
            color: #172033;
        }

        /* Quote */

        .quote {
            margin: 25px 0;
            padding: 18px 20px;
            border-top: 1px solid #edf0f4;
            border-bottom: 1px solid #edf0f4;
            text-align: center;
            color: #7a8494;
            font-size: 13px;
            font-style: italic;
            line-height: 1.65;
        }

        .quote-icon {
            color: #ef233c;
            font-size: 18px;
            margin-bottom: 5px;
        }

        /* Next Donation */

        .next-donation {
            margin: 24px 0;
            padding: 16px 18px;
            background: #f8fafc;
            border: 1px solid #edf0f4;
            border-radius: 11px;
        }

        .next-donation-label {
            color: #8a94a6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 5px;
        }

        .next-donation-date {
            color: #172033;
            font-size: 15px;
            font-weight: 700;
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
                font-size: 21px;
            }

            .success-banner {
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

            .stat-value {
                font-size: 28px;
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

                        <div class="donation-icon">
                            ❤️
                        </div>

                        <div class="brand">
                            BLOOD LINK
                        </div>

                        <h1>
                            Thank You for Donating!
                        </h1>

                        <p>
                            Your life-saving gift makes a difference
                        </p>

                    </td>
                </tr>


                {{-- Success Banner --}}
                <tr>
                    <td>

                        <div class="success-banner">

                            <p class="success-title">
                                ✓ Donation Successfully Completed
                            </p>

                            <p class="success-text">
                                Your generosity could help save lives.
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
                            On behalf of everyone at Blood Link and the
                            patients whose lives your gift will touch,
                            we sincerely thank you for completing a blood
                            donation.
                        </p>


                        <p class="message">
                            Your courage, compassion, and commitment to
                            helping others make a real difference in our
                            community.
                        </p>


                        {{-- Donation Statistics --}}
                        <div class="stats-box">

                            <div class="stats-icon">
                                🩸
                            </div>

                            <div class="stat-value">
                                {{ $user->donor->total_donations + 1 }}
                            </div>

                            <div class="stat-label">
                                Total Donations
                            </div>

                        </div>


                        {{-- Impact --}}
                        <div class="impact-box">

                            <strong>
                                Your donation can make an incredible impact.
                            </strong>

                            <br>

                            Your blood has the potential to help save up to
                            <strong>three lives</strong>. Because of you,
                            families facing medical emergencies have hope,
                            hospitals have the supply they need, and someone
                            gets another chance to fight on.

                        </div>


                        {{-- Quote --}}
                        <div class="quote">

                            <div class="quote-icon">
                                ❤️
                            </div>

                            "The blood you gave is now a part of
                            someone's story of survival."

                        </div>


                        <p class="message">
                            Please remember to take care of yourself in
                            the days following your donation. Stay hydrated,
                            rest well, and eat nutritious, iron-rich foods.
                        </p>


                        {{-- Next Donation --}}
                        <div class="next-donation">

                            <div class="next-donation-label">
                                Next Eligible Donation
                            </div>

                            <div class="next-donation-date">
                                {{ \Carbon\Carbon::parse($user->donor->next_eligible_date)->toFormattedDateString() }}
                            </div>

                        </div>


                        {{-- CTA --}}
                        <div class="cta">

                            <a href="{{ config('app.url') }}">
                                View Your Donor Profile
                            </a>

                        </div>


                        <p class="message">

                            With heartfelt gratitude,

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