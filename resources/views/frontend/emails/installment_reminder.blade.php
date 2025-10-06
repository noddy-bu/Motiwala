<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Payment Reminder | Motiwala Jewels</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:'Helvetica Neue', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                @php
                    $isOverdue = $days == 'passed';
                    $isSameDay = $days == 'same_day';
                @endphp

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:{{ $isOverdue ? '#d9534f' : ($isSameDay ? 'linear-gradient(135deg,#b8860b,#f2c94c)' : 'linear-gradient(135deg,#b8860b,#f2c94c)') }};
                                   padding:30px;">
                            <img src="https://motiwalajewels.in/public/assets/img/logo.png" alt="Motiwala Jewels" width="120"
                                style="display:block; margin-bottom:10px;">
                            <h1 style="color:#fff; font-size:24px; margin:0;">
                                @if ($isOverdue)
                                    Payment Overdue Notice
                                @elseif($isSameDay)
                                    Payment Due Today
                                @else
                                    Upcoming Payment Reminder
                                @endif
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px 30px;">
                            <p style="font-size:16px; color:#333;">Dear <strong>{{ $name ?? 'Customer' }}</strong>,</p>

                            @if (!$isOverdue && !$isSameDay)
                                <p style="font-size:16px; color:#555; line-height:1.6;">
                                    We hope this message finds you well.
                                    This is a friendly reminder that your payment for
                                    <strong>{{ $plan }}</strong> (Installment
                                    <strong>{{ $installment }}</strong>)
                                    is due on <strong>{{ date('d M Y', strtotime($due_date)) }}</strong>.
                                    We're sending this {{ $days }}-day reminder to help you stay on track.
                                </p>
                            @elseif($isSameDay)
                                <p style="font-size:16px; color:#555; line-height:1.6;">
                                    We hope this message finds you well.
                                    This is a reminder that your payment for
                                    <strong>{{ $plan }}</strong> (Installment
                                    <strong>{{ $installment }}</strong>)
                                    is <strong>due today</strong> and must be completed by
                                    <strong>{{ date('d M Y', strtotime($due_date_end)) }}</strong>.
                                </p>
                            @else
                                <p style="font-size:16px; color:#555; line-height:1.6;">
                                    We hope this message finds you well.
                                    Your payment for
                                    <strong>{{ $plan }}</strong> (Installment
                                    <strong>{{ $installment }}</strong>)
                                    was due on <strong>{{ date('d M Y', strtotime($due_date_end)) }}</strong>
                                    and is now <strong>overdue</strong>.
                                    Please make your payment as soon as possible to avoid penalties.
                                </p>
                            @endif

                            <!-- Payment Details Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin:25px 0; background:#fafafa; border-radius:10px; padding:15px;">
                                <tr>
                                    <td style="padding:10px 15px; font-size:15px; color:#333;">
                                        <strong>Plan Name:</strong> {{ $plan }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 15px; font-size:15px; color:#333;">
                                        <strong>Installment No.:</strong> {{ $installment }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 15px; font-size:15px; color:#333;">
                                        <strong>Due Date:</strong> {{ date('d M Y', strtotime($due_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 15px; font-size:15px; color:#333;">
                                        <strong>Amount:</strong> ₹{{ $amount }}
                                    </td>
                                </tr>
                            </table>

                            <div style="text-align:center; margin:30px 0;">
                                <a href="https://treasure.motiwalajewels.in/?login=true"
                                    style="background:{{ $isOverdue ? '#d9534f' : 'linear-gradient(135deg,#b8860b,#f2c94c)' }};
                                          color:#fff; text-decoration:none; padding:12px 35px;
                                          border-radius:30px; font-weight:bold; display:inline-block;">
                                    Visit Us
                                </a>
                            </div>

                            <p style="font-size:15px; color:#555; line-height:1.6;">
                                If you have any questions or need assistance, please contact our support team —
                                we’re happy to help.
                            </p>

                            <p style="color:#888; font-size:14px; line-height:1.6; margin-top:40px; text-align:center;">
                                Best regards,<br>
                                <strong>{{ env('COMPANY_NAME', 'Motiwala Jewels') }}</strong><br>
                                Mob: <a href="tel:{{ env('COMPANY_NUMBER', '+919920077780') }}"
                                    style="color:#b8860b; text-decoration:none;">{{ env('COMPANY_NUMBER', '+91 9920077780') }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#fafafa; padding:20px; font-size:13px; color:#999;">
                            © {{ date('Y') }} {{ env('COMPANY_NAME', 'Motiwala Jewels') }}. All rights
                            reserved.<br>
                            <a href="https://treasure.motiwalajewels.in" style="color:#b8860b; text-decoration:none;">Visit
                                Website</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
