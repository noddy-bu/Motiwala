<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to Motiwala Jewels</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:'Helvetica Neue', Arial, sans-serif;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:linear-gradient(135deg,#b8860b,#f2c94c); padding:30px;">
                            <img src="https://motiwalajewels.in/public/assets/img/logo.png" alt="Motiwala Jewels" width="120"
                                style="display:block; margin-bottom:10px;">
                            <h1 style="color:#fff; font-size:24px; margin:0;">Welcome to Motiwala Jewels</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <h2 style="color:#b8860b; font-size:22px; margin-bottom:10px;">Congratulations!</h2>
                            <p style="color:#333; font-size:16px; line-height:1.6; margin-bottom:20px;">
                                Dear Valued Customer,<br>
                                We’re delighted to welcome you to <strong>Motiwala Jewels</strong>. Your registration
                                was successful!
                            </p>

                            <table cellpadding="0" cellspacing="0" border="0"
                                style="width:100%; margin-bottom:20px; background:#faf7f0; border-radius:8px; padding:15px;">
                                <tr>
                                    <td style="color:#555; font-size:15px;">
                                        <strong>User ID:</strong> {{ $phone }}<br>
                                        <strong>Password:</strong> {{ $phone }}
                                    </td>
                                </tr>
                            </table>

                            {{-- <p style="color:#555; font-size:16px; line-height:1.6;">
                                You can now explore our exclusive jewelry collections and manage your account easily.
                            </p> --}}

                            <div style="text-align:center; margin:30px 0;">
                                <a href="https://treasure.motiwalajewels.in/?login=true"
                                    style="background:linear-gradient(135deg,#b8860b,#f2c94c); color:#fff; text-decoration:none; padding:12px 30px; border-radius:30px; font-weight:bold; display:inline-block;">
                                    Login Now
                                </a>
                            </div>

                            <p style="color:#888; font-size:14px; line-height:1.6; text-align:center;">
                                Thank you for joining the Motiwala family.<br>
                                <strong>— The Motiwala Jewels Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f9f9f9; padding:20px; font-size:13px; color:#999;">
                            © {{ date('Y') }} Motiwala Jewels. All rights reserved.<br>
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

