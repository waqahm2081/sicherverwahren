<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung abschliessen</title>
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

                {{-- Banner --}}
                <tr>
                    <td align="center" style="background-color:#e8f5e9;padding:16px 36px;">
                        <p style="margin:0;font-size:15px;color:#2e7d32;font-weight:bold;">
                            ✔ Ihr Termin wurde bestätigt
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:32px 36px 20px;">
                        <h1 style="margin:0 0 16px 0;font-size:22px;color:#2d2d2d;font-weight:bold;">Guten Tag {{ $user->name }},</h1>
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Ihr Vor-Ort-Termin wurde von unserem Team bestätigt. Um Ihren Zugang freizuschalten, schliessen Sie bitte die Zahlung über den untenstehenden Link ab.
                        </p>
                        <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Der Zahlungslink ist personalisiert und nur für Ihr Konto gültig.
                        </p>

                        {{-- Package reminder --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:28px;">
                            <tr>
                                <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Paket</td>
                                            <td style="font-size:14px;color:#2d2d2d;">{{ $user->selected_package ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Service-Typ</td>
                                            <td style="font-size:14px;color:#2d2d2d;">Vor-Ort-Service</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        {{-- Payment CTA --}}
                        <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                            <tr>
                                <td align="center" style="background-color:#6f54a4;border-radius:5px;">
                                    <a href="{{ url('/pay/' . $user->payment_token) }}"
                                       style="display:inline-block;padding:12px 28px;font-size:14px;color:#ffffff;text-decoration:none;font-weight:bold;">
                                        Jetzt bezahlen & Zugang aktivieren
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px 0;font-size:13px;color:#888888;line-height:1.5;">
                            Oder kopieren Sie diesen Link in Ihren Browser:<br>
                            <a href="{{ url('/pay/' . $user->payment_token) }}" style="color:#6f54a4;word-break:break-all;">{{ url('/pay/' . $user->payment_token) }}</a>
                        </p>

                        <p style="margin:16px 0 0 0;font-size:14px;color:#666666;line-height:1.6;">
                            Bei Fragen erreichen Sie uns unter
                            <a href="mailto:{{ config('mail.from.address') }}" style="color:#6f54a4;text-decoration:none;">{{ config('mail.from.address') }}</a>.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
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