<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->selected_option_type === 'onsite' ? 'Anfrage eingegangen' : 'Bestellung bestätigt' }}</title>
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
                        <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                            Guten Tag {{ $user->name }},
                        </p>

                        @if($user->selected_option_type === 'onsite')
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                vielen Dank für Ihr Interesse an {{ $user->selected_package ?? 'Business Enterprise' }}.
                            </p>
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Da jede Unternehmensstruktur unterschiedliche Anforderungen an Rollen, Berechtigungen, Governance, Notfallplanung und technische Umsetzung stellt, prüfen wir Ihre Angaben persönlich.
                            </p>
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Wir melden uns innerhalb von 1–2 Arbeitstagen bei Ihnen, um Ihre Ausgangslage, den gewünschten Projektumfang und das weitere Vorgehen zu besprechen.
                            </p>
                            <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Zu diesem Zeitpunkt ist noch keine Zahlung erforderlich. Den persönlichen Zahlungslink erhalten Sie erst nach der gemeinsamen Abstimmung und Terminvereinbarung.
                            </p>
                        @else
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                vielen Dank für Ihr Vertrauen und Ihre Bestellung bei Sicher Bitcoin Verwahren.
                            </p>
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Wir bestätigen den erfolgreichen Zahlungseingang für folgendes Paket:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9f7ff;border-radius:5px;border:1px solid #e4ddf5;margin-bottom:24px;">
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
                                    <td style="padding:14px 18px;border-bottom:1px solid #e4ddf5;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Leistungsart</td>
                                                <td style="font-size:14px;color:#2d2d2d;">Digital</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="130" style="font-size:13px;color:#888888;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;">Betrag</td>
                                                <td style="font-size:14px;color:#2d2d2d;">CHF {{ $amountFormatted ?? '—' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Ihr persönliches Hardware-Paket wird nun für Sie vorbereitet. Sobald es versendet wurde, erhalten Sie eine separate Versandbestätigung.
                            </p>
                            <p style="margin:0 0 16px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Nach der Zustellung aktivieren wir Ihren persönlichen Zugang zur Trainingsplattform. Ab der Freischaltung stehen Ihnen die zu Ihrem Paket gehörenden Videoinhalte während 60 Tagen zur Verfügung.
                            </p>
                            <p style="margin:0 0 24px 0;font-size:15px;color:#444444;line-height:1.6;">
                                Bei Fragen erreichen Sie uns jederzeit unter
                                <a href="mailto:info@sicher-bitcoin-verwahren.ch" style="color:#6f54a4;text-decoration:none;">info@sicher-bitcoin-verwahren.ch</a>.
                            </p>
                        @endif
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
