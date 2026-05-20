<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Received</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center" style="padding:30px 10px;">

            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:6px;overflow:hidden;border:1px solid #e0e0e0;">

                {{-- Header --}}
                <tr>
                    <td align="center" style="background-color:#6f54a4;padding:24px 30px;">
                        <img
                            src="https://sicher-bitcoin-verwahren.ch/images/logo.jpg"
                            alt="Sicher Bitcoin Verwahren"
                            width="120"
                            style="display:block;border:0;max-width:120px;"
                        >
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:32px 36px 20px;">
                        <h1 style="margin:0 0 16px 0;font-size:22px;color:#2d2d2d;font-weight:bold;">Dear {{ $user->name }},</h1>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Thank you for your payment.
                        </p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            We have received your payment and are now ordering the hardware required for your package.
                        </p>
                        <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Once the hardware has arrived, we will notify you about the start of your project and activate your access to the training content.
                        </p>

                        {{-- Package summary --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:24px;">
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Package</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->selected_package ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Service Type</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ ucfirst($user->selected_option_type ?? '—') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        {{-- Pending notice --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                            <tr>
                                <td style="background-color:#f0f7ff;border-left:4px solid #6f54a4;padding:14px 16px;border-radius:4px;">
                                    <p style="margin:0;font-size:14px;color:#2d2d2d;line-height:1.6;">
                                        Your account is currently <strong>pending review</strong>. Our team will verify your registration and you will receive another email once your account has been approved.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 6px 0;font-size:15px;color:#444444;line-height:1.6;">
                            If you have any questions in the meantime, please contact us at
                            <a href="mailto:{{ config('mail.from.address') }}" style="color:#6f54a4;text-decoration:none;">{{ config('mail.from.address') }}</a>.
                        </p>
                        <p style="margin:8px 0 0;font-size:12px;color:#aaaaaa;line-height:1.6;">
                            You received this email because you registered at sicher-bitcoin-verwahren.ch. If this was not you, please contact us immediately.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:20px 36px 28px;border-top:1px solid #eeeeee;">
                        <p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;">
                            Best regards<br>
                            Your Sicher Bitcoin Verwahren Team<br>
                            <a href="https://www.sicher-bitcoin-verwahren.ch" style="color:#aaaaaa;text-decoration:none;">www.sicher-bitcoin-verwahren.ch</a> &nbsp;|&nbsp;
                            <a href="mailto:info@sicher-bitcoin-verwahren.ch" style="color:#aaaaaa;text-decoration:none;">info@sicher-bitcoin-verwahren.ch</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>