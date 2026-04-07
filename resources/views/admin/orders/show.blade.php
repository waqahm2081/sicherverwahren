<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellung #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }} — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        /* ── Detail grid layout ── */
        .adm-detail-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 960px) {
            .adm-detail-grid { grid-template-columns: 1fr; }
        }

        /* ── Section card ── */
        .adm-detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .adm-detail-card:last-child { margin-bottom: 0; }

        .adm-detail-card__header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
            background: var(--surface-2);
        }

        .adm-detail-card__header-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .adm-detail-card__header-icon svg { width: 16px; height: 16px; fill: white; }
        .adm-detail-card__header-icon--purple { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .adm-detail-card__header-icon--blue   { background: linear-gradient(135deg, #4a90d9, #6aaae8); }
        .adm-detail-card__header-icon--teal   { background: linear-gradient(135deg, #2e9e6b, #3dbb82); }
        .adm-detail-card__header-icon--pink   { background: linear-gradient(135deg, var(--secondary), #d4a0d4); }

        .adm-detail-card__title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .adm-detail-card__body { padding: 20px; }

        /* ── Field rows ── */
        .adm-field-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .adm-field-row:last-child { border-bottom: none; padding-bottom: 0; }
        .adm-field-row:first-child { padding-top: 0; }

        .adm-field-row__label {
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            width: 120px;
            flex-shrink: 0;
            padding-top: 2px;
        }

        .adm-field-row__value {
            font-size: 13.5px;
            color: var(--text);
            font-weight: 500;
            flex: 1;
        }

        /* ── Hero banner ── */
        .adm-order-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, #3d2d7a 100%);
            border-radius: 12px;
            padding: 28px;
            color: white;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .adm-order-hero::before {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }

        .adm-order-hero::after {
            content: '';
            position: absolute;
            right: 60px; bottom: -40px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .adm-order-hero__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .adm-order-hero__id {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            opacity: .7;
        }

        .adm-order-hero__badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(255,255,255,.15);
            backdrop-filter: blur(4px);
        }

        .adm-order-hero__name {
            font-family: 'DM Serif Display', serif;
            font-size: 28px;
            font-weight: 400;
            line-height: 1.1;
            letter-spacing: -.4px;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .adm-order-hero__pkg {
            font-size: 14px;
            opacity: .8;
            position: relative;
            z-index: 1;
        }

        .adm-order-hero__price-row {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,.15);
            position: relative;
            z-index: 1;
        }

        .adm-order-hero__currency { font-size: 16px; opacity: .8; }
        .adm-order-hero__amount  { font-size: 36px; font-weight: 700; letter-spacing: -1.5px; line-height: 1; }
        .adm-order-hero__type    { font-size: 13px; opacity: .7; margin-left: 4px; }

        /* ── Feature list in package card ── */
        .adm-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 8px 0;
            font-size: 13.5px;
            color: var(--text-2);
            border-bottom: 1px solid var(--border-light);
        }

        .adm-feature-item:last-child { border-bottom: none; }

        .adm-feature-item__check {
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }

        .adm-feature-item__check svg { width: 10px; height: 10px; fill: white; }
        .adm-feature-item__check--normal   { background: var(--primary); }
        .adm-feature-item__check--inherited { background: var(--secondary); }

        .adm-inherited-note {
            font-size: 10px;
            color: var(--muted-light);
            font-style: italic;
            display: block;
            margin-top: 1px;
        }

        /* ── Avatar large ── */
        .adm-avatar-lg {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 700; color: white;
            flex-shrink: 0;
        }

        /* ── Tag ── */
        .adm-tag { display:inline-block;font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px; }
        .adm-tag--digital { background:rgba(74,144,217,.1);color:#2d74be; }
        .adm-tag--onsite  { background:rgba(46,158,107,.1);color:#1d7a53; }

        /* ── No package fallback ── */
        .adm-no-package {
            text-align: center;
            padding: 32px 20px;
            color: var(--muted);
            font-size: 13.5px;
        }

        .adm-no-package svg {
            width: 40px; height: 40px;
            fill: var(--border);
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Bestellung #'.str_pad($user->id, 5, '0', STR_PAD_LEFT)])

        <div class="adm-content">
            {{-- Page header --}}
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div>
                    <h1>Bestelldetails</h1>
                    <p>Vollständige Informationen zu dieser Buchung.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zurück zur Liste
                </a>
            </div>

            {{-- Hero --}}
            <div class="adm-order-hero">
                <div class="adm-order-hero__top">
                    <div class="adm-order-hero__id">Bestellung #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    @if($user->selected_option_type === 'digital')
                        <span class="adm-order-hero__badge">Digital</span>
                    @elseif($user->selected_option_type === 'onsite')
                        <span class="adm-order-hero__badge">Vor Ort</span>
                    @endif
                </div>
                <div class="adm-order-hero__name">{{ $user->name }}</div>
                <div class="adm-order-hero__pkg">{{ $user->selected_package }}</div>

                @if($option)
                <div class="adm-order-hero__price-row">
                    <span class="adm-order-hero__currency">CHF</span>
                    <span class="adm-order-hero__amount">{{ number_format($option->price_chf, 0, '.', "'") }}</span>
                    <span class="adm-order-hero__type">· {{ $option->label }}</span>
                </div>
                @endif
            </div>

            {{-- Two-column grid --}}
            <div class="adm-detail-grid">
                {{-- LEFT COLUMN --}}
                <div>
                    {{-- Customer info --}}
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--purple">
                                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Kundendaten</div>
                        </div>
                        <div class="adm-detail-card__body">
                            <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border-light);">
                                <div class="adm-avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div style="font-size:17px;font-weight:700;color:var(--text);letter-spacing:-.3px;">{{ $user->name }}</div>
                                    <div style="font-size:13px;color:var(--muted);margin-top:2px;">Benutzer-ID #{{ $user->id }}</div>
                                </div>
                            </div>

                            <div class="adm-field-row">
                                <div class="adm-field-row__label">E-Mail</div>
                                <div class="adm-field-row__value">
                                    <a href="mailto:{{ $user->email }}" style="color:var(--primary);text-decoration:none;">{{ $user->email }}</a>
                                </div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Telefon</div>
                                <div class="adm-field-row__value">
                                    @if($user->phone)
                                        <a href="tel:{{ $user->phone }}" style="color:var(--primary);text-decoration:none;">{{ $user->phone }}</a>
                                    @else
                                        <span style="color:var(--muted-light);">—</span>
                                    @endif
                                </div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Registriert</div>
                                <div class="adm-field-row__value">{{ $user->created_at->format('d. F Y, H:i') }} Uhr</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Zuletzt aktiv</div>
                                <div class="adm-field-row__value">{{ $user->updated_at->format('d. F Y, H:i') }} Uhr</div>
                            </div>
                        </div>
                    </div>

                    {{-- Order info --}}
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--blue">
                                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Bestellinformationen</div>
                        </div>
                        <div class="adm-detail-card__body">
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Bestell-Nr.</div>
                                <div class="adm-field-row__value" style="font-family:monospace;font-size:14px;">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Paket</div>
                                <div class="adm-field-row__value" style="font-weight:600;">{{ $user->selected_package }}</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Lieferart</div>
                                <div class="adm-field-row__value">
                                    @if($user->selected_option_type === 'digital')
                                        <span class="adm-tag adm-tag--digital">Digital</span>
                                    @elseif($user->selected_option_type === 'onsite')
                                        <span class="adm-tag adm-tag--onsite">Vor Ort</span>
                                    @endif
                                </div>
                            </div>
                            @if($option)
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Preis</div>
                                <div class="adm-field-row__value" style="font-size:16px;font-weight:700;color:var(--primary);">
                                    CHF {{ number_format($option->price_chf, 0, '.', "'") }}
                                </div>
                            </div>
                            @endif
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Bestellt am</div>
                                <div class="adm-field-row__value">{{ $user->created_at->format('d. F Y') }}</div>
                            </div>
                            @if($package)
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Kategorie</div>
                                <div class="adm-field-row__value" style="text-transform:capitalize;">{{ $package->category }}</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Portfolio</div>
                                <div class="adm-field-row__value">{{ $package->portfolio_label }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Account access (digital only) --}}
                    @if($user->selected_option_type === 'digital')
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--teal">
                                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Videozugang</div>
                        </div>
                        <div class="adm-detail-card__body">
                            @php
                                $daysSince    = $user->created_at->diffInDays(now());
                                $daysLeft     = max(0, 30 - $daysSince);
                                $expired      = $daysSince > 30;
                            @endphp
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Zugang seit</div>
                                <div class="adm-field-row__value">{{ $user->created_at->format('d.m.Y') }}</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Läuft ab</div>
                                <div class="adm-field-row__value">{{ $user->created_at->addDays(30)->format('d.m.Y') }}</div>
                            </div>
                            <div class="adm-field-row">
                                <div class="adm-field-row__label">Status</div>
                                <div class="adm-field-row__value">
                                    @if($expired)
                                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:#d94f4f;background:#fef2f2;padding:3px 10px;border-radius:20px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#d94f4f;display:inline-block;"></span>
                                            Abgelaufen
                                        </span>
                                    @else
                                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:#2e9e6b;background:#edfaf4;padding:3px 10px;border-radius:20px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#2e9e6b;display:inline-block;"></span>
                                            Aktiv — noch {{ $daysLeft }} {{ $daysLeft === 1 ? 'Tag' : 'Tage' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- RIGHT COLUMN --}}
                <div>
                    {{-- Package features --}}
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--pink">
                                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Enthaltene Leistungen</div>
                        </div>
                        <div class="adm-detail-card__body">
                            @if($option && $option->features->isNotEmpty())
                                @foreach($option->features as $feature)
                                    <div class="adm-feature-item">
                                        <div class="adm-feature-item__check {{ $feature->is_inherited ? 'adm-feature-item__check--inherited' : 'adm-feature-item__check--normal' }}">
                                            <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                        </div>
                                        <div>
                                            {{ $feature->feature }}
                                            @if($feature->is_inherited)
                                                <span class="adm-inherited-note">inklusive aus Digital-Paket</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="adm-no-package">
                                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                    <p>Keine Features gefunden.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Quick actions --}}
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--purple">
                                <svg viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Schnellaktionen</div>
                        </div>
                        <div class="adm-detail-card__body" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="mailto:{{ $user->email }}" class="adm-btn adm-btn--secondary" style="justify-content:center;">
                                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                E-Mail senden
                            </a>
                            @if($user->phone)
                            <a href="tel:{{ $user->phone }}" class="adm-btn adm-btn--secondary" style="justify-content:center;">
                                <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                                Anrufen
                            </a>
                            @endif
                            <a href="{{ route('admin.orders.index') }}" class="adm-btn adm-btn--secondary" style="justify-content:center;">
                                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                                Zurück zur Liste
                            </a>
                        </div>
                    </div>

                    {{-- All available options for this package --}}
                    @if($package && $package->options->count() > 1)
                    <div class="adm-detail-card">
                        <div class="adm-detail-card__header">
                            <div class="adm-detail-card__header-icon adm-detail-card__header-icon--teal">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                            </div>
                            <div class="adm-detail-card__title">Andere Paketoption</div>
                        </div>
                        <div class="adm-detail-card__body">
                            @foreach($package->options as $opt)
                                @if($opt->type !== $user->selected_option_type)
                                <div style="padding:12px;background:var(--bg);border-radius:8px;border:1px solid var(--border-light);">
                                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                        <span style="font-size:13px;font-weight:600;color:var(--text);">{{ $opt->label }}</span>
                                        <span style="font-size:14px;font-weight:700;color:var(--muted);">CHF {{ number_format($opt->price_chf, 0, '.', "'") }}</span>
                                    </div>
                                    <div style="font-size:12px;color:var(--muted);">Nicht gewählt — Kunde hat {{ $user->selected_option_type === 'digital' ? 'Digital' : 'Vor Ort' }} gebucht</div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</body>
</html>