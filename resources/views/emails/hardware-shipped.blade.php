<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ihr Hardware-Paket wurde versendet</title>
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
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">gute Nachrichten: Ihr persönliches Hardware-Paket für {{ $user->selected_package }} wurde heute versendet.</p>
                        <p style="margin:0 0 8px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Versanddatum:</strong> {{ optional($user->shipping_date)->format('d.m.Y') ?? now()->format('d.m.Y') }}</p>
                        @if($user->tracking_number)
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Sendungsnummer:</strong> {{ $user->tracking_number }}</p>
                        @endif
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Bitte kontrollieren Sie das Paket nach Erhalt auf Vollständigkeit und bewahren Sie sämtliche Bestandteile bis zum Start der Videoreihe sicher auf.</p>
                        <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">Ihr persönlicher Zugang zur Trainingsplattform wird nach der erwarteten Zustellung separat freigeschaltet. Sie erhalten dazu eine weitere E-Mail.</p>
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
