<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuer Lead</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center" style="padding:30px 10px;">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:6px;overflow:hidden;border:1px solid #e0e0e0;">

                <tr>
                    <td align="center" style="background-color:#6f54a4;padding:24px 30px;">
                        <img src="https://sicher-bitcoin-verwahren.ch/images/logo.jpg"
                             alt="Sicher Bitcoin Verwahren" width="120"
                             style="display:block;border:0;max-width:120px;">
                    </td>
                </tr>

                <tr>
                    <td style="padding:32px 36px 20px;">
                        <p style="margin:0 0 6px 0;font-size:13px;color:#888888;text-transform:uppercase;letter-spacing:1px;">Admin Benachrichtigung</p>
                        <h1 style="margin:0 0 20px 0;font-size:22px;color:#2d2d2d;font-weight:bold;">Neuer Lead eingegangen</h1>
                        <p style="margin:0 0 20px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Ein neuer Interessent hat den Bitcoin Sicherheits-Selbsttest angefordert. Die Details finden Sie unten.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:24px;">
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Name</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $lead->name }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">E-Mail</td>
                                            <td style="font-size:14px;color:#2d2d2d;"><a href="mailto:{{ $lead->email }}" style="color:#6f54a4;text-decoration:none;">{{ $lead->email }}</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="120" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Quelle</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $lead->source === 'training' ? 'Videokurse / Pricing' : 'Bitcoin Sicherheits-Selbsttest' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 36px;background-color:#f9f7ff;border-top:1px solid #e4ddf5;">
                        <p style="margin:0;font-size:12px;color:#999999;text-align:center;">
                            © 2026 Sicher Bitcoin Verwahren · Admin-Benachrichtigung
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
