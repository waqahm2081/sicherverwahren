<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persönlicher Zahlungslink</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center" style="padding:30px 10px;">

            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:6px;overflow:hidden;border:1px solid #e0e0e0;">

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

                <tr>
                    <td style="padding:32px 36px 20px;">
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Guten Tag {{ $user->name }},
                        </p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            vielen Dank für das persönliche Gespräch und die gemeinsame Abstimmung Ihres {{ $user->selected_package ?? 'Business-Enterprise' }}-Projekts.
                        </p>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Nachfolgend finden Sie die vereinbarten Angaben:
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:28px;">
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Paket</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->selected_package ?? 'Business Enterprise' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Betrag</td>
                                            <td style="font-size:14px;color:#2d2d2d;">CHF {{ number_format((float) ($user->quoted_amount_chf ?? 0), 0, '.', "'") }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @if($user->appointment_date)
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Termin</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->appointment_date }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif
                            @if($user->appointment_location)
                            <tr>
                                <td style="padding:14px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Ort</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->appointment_location }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif
                        </table>

                        <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Über den folgenden Button können Sie die vereinbarte Leistung sicher bezahlen.
                        </p>

                        <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                            <tr>
                                <td align="center" style="background-color:#6f54a4;border-radius:5px;">
                                    <a href="{{ url('/pay/' . $user->payment_token) }}"
                                       style="display:inline-block;padding:12px 28px;font-size:14px;color:#ffffff;text-decoration:none;font-weight:bold;">
                                        Jetzt sicher bezahlen
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px 0;font-size:13px;color:#888888;line-height:1.5;">
                            Oder kopieren Sie diesen Link in Ihren Browser:<br>
                            <a href="{{ url('/pay/' . $user->payment_token) }}" style="color:#6f54a4;word-break:break-all;">{{ url('/pay/' . $user->payment_token) }}</a>
                        </p>

                        <p style="margin:16px 0 0 0;font-size:14px;color:#666666;line-height:1.6;">
                            Nach erfolgreicher Zahlung erhalten Sie eine Bestätigung. Der vereinbarte Termin wird damit verbindlich reserviert.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 36px 28px;border-top:1px solid #eeeeee;">
                        <p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;">
                            Freundliche Grüsse<br>
                            Ihr Team von Sicher Bitcoin Verwahren<br>
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
