<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erinnerung – Zugang endet in 10 Tagen</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center" style="padding:30px 10px;">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:6px;overflow:hidden;border:1px solid #e0e0e0;">
                <tr>
                    <td align="center" style="background-color:#6f54a4;padding:24px 30px;">
                        <img src="https://sicher-bitcoin-verwahren.ch/images/logo.jpg" alt="Sicher Bitcoin Verwahren" width="120" style="display:block;border:0;max-width:120px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px 36px 20px;">
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Guten Tag {{ $user->name }},</p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">dies ist eine kurze Erinnerung: Ihr Zugang zum Videokurs {{ $user->selected_package }} endet in 10 Tagen.</p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Zugangsende:</strong> {{ optional($user->access_ends_at)->format('d.m.Y') }}</p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Bitte stellen Sie sicher, dass Sie alle relevanten Module abgeschlossen und die einzelnen Sicherheitsschritte vollständig umgesetzt haben.</p>
                        <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">Bei offenen Fragen können Sie uns vor Ablauf Ihres Zugangs unter info@sicher-bitcoin-verwahren.ch kontaktieren.</p>
                        <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:8px;">
                            <tr>
                                <td align="center" style="background-color:#6f54a4;border-radius:5px;">
                                    <a href="{{ url('/user-dashboard') }}" style="display:inline-block;padding:12px 28px;font-size:14px;color:#ffffff;text-decoration:none;font-weight:bold;">Zum Dashboard</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 36px 28px;border-top:1px solid #eeeeee;">
                        <p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;">
                            Freundliche Grüsse<br>Ihr Team von Sicher Bitcoin Verwahren<br>
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
