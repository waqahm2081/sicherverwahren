<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung bestätigt – Business Enterprise</title>
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
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">vielen Dank für Ihr Vertrauen.</p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Wir bestätigen den erfolgreichen Zahlungseingang für Ihr Business-Enterprise-Projekt.</p>
                        <p style="margin:0 0 8px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Betrag:</strong> CHF {{ number_format((float) ($user->quoted_amount_chf ?? 0), 0, '.', "'") }}</p>
                        @if($user->appointment_date)
                            <p style="margin:0 0 8px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Termin:</strong> {{ $user->appointment_date }}</p>
                        @endif
                        @if($user->appointment_location)
                            <p style="margin:0 0 8px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Ort:</strong> {{ $user->appointment_location }}</p>
                        @endif
                        @if($user->contact_person)
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;"><strong>Ansprechperson:</strong> {{ $user->contact_person }}</p>
                        @endif
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Ihr Termin ist damit verbindlich bestätigt.</p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">Weitere organisatorische Hinweise und die benötigten Vorbereitungen erhalten Sie rechtzeitig vor dem vereinbarten Termin.</p>
                        <p style="margin:0;font-size:15px;color:#444444;line-height:1.6;">Bei Fragen erreichen Sie uns jederzeit unter info@sicher-bitcoin-verwahren.ch.</p>
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
