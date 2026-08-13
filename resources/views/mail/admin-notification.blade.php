<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>

<body style="
    margin:0;
    padding:0;
    background-color:#F4F7FA;
    font-family:Arial, Helvetica, sans-serif;
">

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        width:100%;
        background-color:#F4F7FA;
        padding:40px 16px;
    "
>
<tr>
<td align="center">

    <!-- Main Email Container -->
    <table
        role="presentation"
        width="600"
        cellpadding="0"
        cellspacing="0"
        border="0"
        style="
            width:100%;
            max-width:600px;
            background-color:#FFFFFF;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 8px 30px rgba(15,23,42,0.08);
        "
    >

        <!-- Header -->
        <tr>
            <td
                style="
                    background-color:#C81E3A;
                    padding:28px 32px;
                "
            >

                <table
                    role="presentation"
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                >
                <tr>

                    <td align="left">

                        <div
                            style="
                                font-size:25px;
                                font-weight:700;
                                color:#FFFFFF;
                                font-family:Georgia, 'Times New Roman', serif;
                            "
                        >
                            ❤️ Blood Link
                        </div>

                        <div
                            style="
                                margin-top:5px;
                                color:#FFE4E8;
                                font-size:12px;
                                letter-spacing:0.3px;
                            "
                        >
                            Smart Blood Bank Management System
                        </div>

                    </td>

                    <td
                        align="right"
                        style="
                            font-size:30px;
                            color:#FFFFFF;
                        "
                    >
                        🩸
                    </td>

                </tr>
                </table>

            </td>
        </tr>


        <!-- Accent Line -->
        <tr>
            <td
                style="
                    height:4px;
                    background-color:#991B1B;
                    font-size:0;
                    line-height:0;
                "
            >
                &nbsp;
            </td>
        </tr>


        <!-- Content -->
        <tr>
            <td
                style="
                    padding:38px 36px 30px 36px;
                "
            >

                <!-- Email Label -->
                <div
                    style="
                        display:inline-block;
                        background-color:#FEF2F2;
                        color:#C81E3A;
                        border-radius:50px;
                        padding:7px 13px;
                        font-size:11px;
                        font-weight:700;
                        letter-spacing:0.5px;
                        text-transform:uppercase;
                        margin-bottom:16px;
                    "
                >
                    Blood Link Notification
                </div>


                <!-- Subject -->
                <h1
                    style="
                        margin:0 0 18px 0;
                        color:#172033;
                        font-family:Georgia, 'Times New Roman', serif;
                        font-size:25px;
                        line-height:1.3;
                        font-weight:700;
                    "
                >
                    {{ $subject }}
                </h1>


                <!-- Divider -->
                <div
                    style="
                        width:50px;
                        height:3px;
                        background-color:#C81E3A;
                        border-radius:5px;
                        margin-bottom:22px;
                    "
                ></div>


                <!-- Message -->
                <div
                    style="
                        background-color:#F8FAFC;
                        border:1px solid #E5E7EB;
                        border-radius:12px;
                        padding:22px 20px;
                        color:#334155;
                        font-size:15px;
                        line-height:1.7;
                    "
                >
                    {!! nl2br(e($body)) !!}
                </div>


                <!-- Blood Link Note -->
                <table
                    role="presentation"
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    style="
                        margin-top:24px;
                    "
                >
                <tr>

                    <td
                        width="4"
                        style="
                            background-color:#C81E3A;
                            border-radius:4px;
                            font-size:0;
                        "
                    >
                        &nbsp;
                    </td>

                    <td
                        style="
                            padding:4px 0 4px 14px;
                            color:#64748B;
                            font-size:13px;
                            line-height:1.6;
                        "
                    >
                        Every connection can make a difference.
                        Thank you for being part of the Blood Link community.
                    </td>

                </tr>
                </table>

            </td>
        </tr>


        <!-- Footer -->
        <tr>
            <td
                style="
                    background-color:#F8FAFC;
                    border-top:1px solid #E5E7EB;
                    padding:24px 30px;
                    text-align:center;
                "
            >

                <div
                    style="
                        color:#172033;
                        font-family:Georgia, 'Times New Roman', serif;
                        font-size:16px;
                        font-weight:700;
                        margin-bottom:7px;
                    "
                >
                    ❤️ Blood Link
                </div>

                <div
                    style="
                        color:#64748B;
                        font-size:12px;
                        line-height:1.6;
                    "
                >
                    Smart Blood Bank Management System
                </div>

                <div
                    style="
                        color:#94A3B8;
                        font-size:11px;
                        line-height:1.6;
                        margin-top:5px;
                    "
                >
                    This is an automated message.
                    Please don't reply to this email.
                </div>

            </td>
        </tr>


    </table>


    <!-- Outside Footer -->
    <div
        style="
            max-width:600px;
            padding:18px 10px 0 10px;
            text-align:center;
            color:#94A3B8;
            font-size:11px;
            line-height:1.5;
        "
    >
        © {{ date('Y') }} Blood Link. All rights reserved.
    </div>


</td>
</tr>
</table>

</body>
</html>