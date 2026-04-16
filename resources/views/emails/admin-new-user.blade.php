<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Registration</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center" style="padding:30px 10px;">

            {{-- Outer container --}}
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
                        <p style="margin:0 0 6px 0;font-size:13px;color:#888888;text-transform:uppercase;letter-spacing:1px;">Admin Notification</p>
                        <h1 style="margin:0 0 20px 0;font-size:22px;color:#2d2d2d;font-weight:bold;">New User Registration</h1>
                        <p style="margin:0 0 20px 0;font-size:15px;color:#444444;line-height:1.6;">
                            A new user has registered and paid for a service package. Please review their details below and approve their account from the admin dashboard.
                        </p>

                        {{-- User details table --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:24px;">
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Name</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->name }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Email</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->email }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Phone</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->phone ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Package</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->selected_package ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Service Type</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ ucfirst($user->selected_option_type ?? '—') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        {{-- CTA --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                            <tr>
                                <td style="background-color:#fff8e6;border-left:4px solid #f0a500;padding:14px 16px;border-radius:4px;">
                                    <p style="margin:0;font-size:14px;color:#7a5200;">
                                        <strong>Action required:</strong> Please log in to the admin dashboard and approve this user so they can access their account.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" style="background-color:#6f54a4;border-radius:5px;">
                                    <a href="{{ url('/admin/users') }}"
                                       style="display:inline-block;padding:12px 28px;font-size:14px;color:#ffffff;text-decoration:none;font-weight:bold;">
                                        Go to Admin Dashboard
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:20px 36px 28px;border-top:1px solid #eeeeee;">
                        <p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;">
                            This is an automated notification from your website. Registered on {{ now()->format('d M Y, H:i') }} (UTC).
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>