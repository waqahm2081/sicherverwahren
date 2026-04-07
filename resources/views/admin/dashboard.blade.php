<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:        #6f54a4;
            --primary-light:  #8b6fc2;
            --primary-dark:   #5a4389;
            --secondary:      #c086c0;
            --bg:             #f4f2f9;
            --surface:        #ffffff;
            --surface-2:      #faf8fd;
            --border:         #e4dff0;
            --border-light:   #ede9f5;
            --text:           #1a1625;
            --text-2:         #3d3456;
            --muted:          #7a728f;
            --muted-light:    #a89fc0;
            --success:        #2e9e6b;
            --success-bg:     #edfaf4;
            --sidebar-width:  256px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ─── Sidebar ─── */
        .adm-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
        }

        .adm-sidebar__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 20px;
            border-bottom: 1px solid var(--border-light);
        }

        .adm-sidebar__logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(111, 84, 164, 0.25);
        }

        .adm-sidebar__logo svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .adm-sidebar__brand-name {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.2px;
            line-height: 1.2;
        }

        .adm-sidebar__brand-sub {
            display: block;
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 500;
        }

        .adm-sidebar__nav {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .adm-sidebar__section-label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted-light);
            padding: 0 8px;
            margin-bottom: 8px;
        }

        .adm-sidebar__link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 2px;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .adm-sidebar__link svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .adm-sidebar__link:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .adm-sidebar__link--active {
            background: linear-gradient(135deg, rgba(111,84,164,0.1), rgba(192,134,192,0.08));
            color: var(--primary);
            font-weight: 600;
        }

        .adm-sidebar__link--active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 0 3px 3px 0;
        }

        .adm-sidebar__link--soon {
            opacity: 0.55;
            pointer-events: none;
        }

        .adm-sidebar__badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            background: var(--border);
            color: var(--muted);
            padding: 2px 7px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .adm-sidebar__footer {
            padding: 14px 16px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adm-sidebar__user {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .adm-sidebar__avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .adm-sidebar__user-name {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .adm-sidebar__user-role {
            display: block;
            font-size: 11px;
            color: var(--muted);
        }

        .adm-sidebar__logout {
            width: 32px;
            height: 32px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }

        .adm-sidebar__logout svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .adm-sidebar__logout:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #d94f4f;
        }

        /* ─── Main content ─── */
        .adm-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Topbar ─── */
        .adm-topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .adm-topbar__breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            color: var(--muted);
        }

        .adm-topbar__breadcrumb span {
            color: var(--text);
            font-weight: 600;
        }

        .adm-topbar__breadcrumb svg {
            width: 14px;
            height: 14px;
            fill: var(--muted-light);
        }

        .adm-topbar__right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .adm-topbar__date {
            font-size: 12.5px;
            color: var(--muted);
            background: var(--bg);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* ─── Content area ─── */
        .adm-content {
            padding: 28px;
            flex: 1;
        }

        .adm-page-header {
            margin-bottom: 24px;
        }

        .adm-page-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            font-weight: 400;
            color: var(--text);
            letter-spacing: -0.4px;
        }

        .adm-page-header p {
            font-size: 13.5px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ─── Stats grid ─── */
        .adm-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .adm-stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
        }

        .adm-stat-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            opacity: 0.06;
            transform: translate(20px, -20px);
        }

        .adm-stat-card--purple::after  { background: var(--primary); }
        .adm-stat-card--pink::after    { background: var(--secondary); }
        .adm-stat-card--teal::after    { background: #2e9e6b; }
        .adm-stat-card--blue::after    { background: #4a90d9; }

        .adm-stat-card__icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .adm-stat-card__icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .adm-stat-card--purple .adm-stat-card__icon { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .adm-stat-card--pink   .adm-stat-card__icon { background: linear-gradient(135deg, var(--secondary), #d4a0d4); }
        .adm-stat-card--teal   .adm-stat-card__icon { background: linear-gradient(135deg, #2e9e6b, #3dbb82); }
        .adm-stat-card--blue   .adm-stat-card__icon { background: linear-gradient(135deg, #4a90d9, #6aaae8); }

        .adm-stat-card__label {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .adm-stat-card__value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -1px;
            line-height: 1;
            font-feature-settings: 'tnum';
        }

        .adm-stat-card__sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }

        /* ─── Order breakdown row ─── */
        .adm-breakdown-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }

        .adm-breakdown-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
        }

        .adm-breakdown-card__title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .adm-breakdown-card__title svg {
            width: 16px;
            height: 16px;
            fill: var(--primary);
        }

        .adm-breakdown-bar {
            margin-bottom: 14px;
        }

        .adm-breakdown-bar__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .adm-breakdown-bar__label {
            font-size: 13px;
            color: var(--text-2);
            font-weight: 500;
        }

        .adm-breakdown-bar__count {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .adm-breakdown-bar__track {
            height: 6px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .adm-breakdown-bar__fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.4s ease;
        }

        .adm-breakdown-bar__fill--teal {
            background: linear-gradient(90deg, #2e9e6b, #3dbb82);
        }

        /* ─── Recent users table ─── */
        .adm-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .adm-section-title a {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--primary);
            text-decoration: none;
            opacity: 0.7;
        }

        .adm-table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .adm-table {
            width: 100%;
            border-collapse: collapse;
        }

        .adm-table thead tr {
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
        }

        .adm-table th {
            text-align: left;
            padding: 11px 16px;
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
        }

        .adm-table td {
            padding: 13px 16px;
            font-size: 13.5px;
            color: var(--text);
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .adm-table tr:last-child td { border-bottom: none; }

        .adm-table tbody tr:hover td { background: var(--surface-2); }

        .adm-user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adm-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .adm-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            text-transform: capitalize;
        }

        .adm-tag--digital {
            background: rgba(74, 144, 217, 0.1);
            color: #2d74be;
        }

        .adm-tag--onsite {
            background: rgba(46, 158, 107, 0.1);
            color: #1d7a53;
        }

        .adm-tag--none {
            background: var(--border);
            color: var(--muted);
        }

        .adm-empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
            font-size: 13.5px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .adm-breakdown-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 700px) {
            .adm-sidebar { transform: translateX(-100%); }
            .adm-main    { margin-left: 0; }
            .adm-stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    @include('admin.partials.sidebar')

    <main class="adm-main">
        <!-- Topbar -->
        <div class="adm-topbar">
            <div class="adm-topbar__breadcrumb">
                Admin
                <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                <span>Dashboard</span>
            </div>
            <div class="adm-topbar__right">
                <span class="adm-topbar__date">{{ now()->format('d. M Y') }}</span>
            </div>
        </div>

        <!-- Content -->
        <div class="adm-content">
            <div class="adm-page-header">
                <h1>Übersicht</h1>
                <p>Willkommen zurück, {{ auth()->user()->name }}. Hier ist der aktuelle Stand.</p>
            </div>

            <!-- Stats cards -->
            <div class="adm-stats-grid">
                <div class="adm-stat-card adm-stat-card--purple">
                    <div class="adm-stat-card__icon">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div class="adm-stat-card__label">Benutzer gesamt</div>
                    <div class="adm-stat-card__value">{{ $stats['total_users'] }}</div>
                    <div class="adm-stat-card__sub">Registrierte Kunden</div>
                </div>

                <div class="adm-stat-card adm-stat-card--pink">
                    <div class="adm-stat-card__icon">
                        <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.35C18 2.53 15.9.5 13.35.5c-1.3 0-2.43.52-3.25 1.33L9 2.96l-1.1-1.13C7.08 1.01 5.95.5 4.65.5 2.1.5 0 2.53 0 4.65c0 .47.08.91.18 1.35H0v14h24V6h-4zm-3.65-4c1.08 0 2.15.92 2.15 2.15 0 .69-.31 1.38-.88 1.88L12 11.5 6.38 6.03c-.57-.5-.88-1.19-.88-1.88C5.5 3.27 6.42 2 7.65 2c.59 0 1.14.24 1.55.66l1.82 1.87.98 1.02.98-1.02 1.82-1.87c.41-.42.96-.66 1.55-.66zM2 18V8h8.55L8 10.75l2.08 2 3.92-4 3.92 4L20 10.75 17.45 8H22v10H2z"/></svg>
                    </div>
                    <div class="adm-stat-card__label">Pakete</div>
                    <div class="adm-stat-card__value">{{ $stats['total_packages'] }}</div>
                    <div class="adm-stat-card__sub">Verfügbare Angebote</div>
                </div>

                <div class="adm-stat-card adm-stat-card--teal">
                    <div class="adm-stat-card__icon">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="adm-stat-card__label">Bestellungen</div>
                    <div class="adm-stat-card__value">{{ $stats['total_orders'] }}</div>
                    <div class="adm-stat-card__sub">Pakete gekauft</div>
                </div>

                <div class="adm-stat-card adm-stat-card--blue">
                    <div class="adm-stat-card__icon">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                    </div>
                    <div class="adm-stat-card__label">Ohne Bestellung</div>
                    <div class="adm-stat-card__value">{{ $stats['total_users'] - $stats['total_orders'] }}</div>
                    <div class="adm-stat-card__sub">Noch kein Paket gewählt</div>
                </div>
            </div>

            <!-- Order type breakdown -->
            <div class="adm-breakdown-row">
                <div class="adm-breakdown-card">
                    <div class="adm-breakdown-card__title">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                        Bestellungen nach Typ
                    </div>

                    @php
                        $total = max($stats['total_orders'], 1);
                        $digitalPct = round(($stats['digital_orders'] / $total) * 100);
                        $onsitePct  = round(($stats['onsite_orders']  / $total) * 100);
                    @endphp

                    <div class="adm-breakdown-bar">
                        <div class="adm-breakdown-bar__header">
                            <span class="adm-breakdown-bar__label">Digital</span>
                            <span class="adm-breakdown-bar__count">{{ $stats['digital_orders'] }}</span>
                        </div>
                        <div class="adm-breakdown-bar__track">
                            <div class="adm-breakdown-bar__fill" style="width: {{ $digitalPct }}%"></div>
                        </div>
                    </div>

                    <div class="adm-breakdown-bar">
                        <div class="adm-breakdown-bar__header">
                            <span class="adm-breakdown-bar__label">Vor Ort (Onsite)</span>
                            <span class="adm-breakdown-bar__count">{{ $stats['onsite_orders'] }}</span>
                        </div>
                        <div class="adm-breakdown-bar__track">
                            <div class="adm-breakdown-bar__fill adm-breakdown-bar__fill--teal" style="width: {{ $onsitePct }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="adm-breakdown-card">
                    <div class="adm-breakdown-card__title">
                        <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                        Schnellübersicht
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: var(--bg); border-radius: 8px; border: 1px solid var(--border-light);">
                            <span style="font-size: 13px; color: var(--muted);">Konversionsrate</span>
                            <span style="font-size: 15px; font-weight: 700; color: var(--primary);">
                                {{ $stats['total_users'] > 0 ? round(($stats['total_orders'] / $stats['total_users']) * 100) : 0 }}%
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: var(--bg); border-radius: 8px; border: 1px solid var(--border-light);">
                            <span style="font-size: 13px; color: var(--muted);">Digitale Bestellungen</span>
                            <span style="font-size: 15px; font-weight: 700; color: #4a90d9;">{{ $stats['digital_orders'] }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: var(--bg); border-radius: 8px; border: 1px solid var(--border-light);">
                            <span style="font-size: 13px; color: var(--muted);">Vor-Ort Bestellungen</span>
                            <span style="font-size: 15px; font-weight: 700; color: #2e9e6b;">{{ $stats['onsite_orders'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent users -->
            <div class="adm-section-title">
                Neueste Benutzer
                <a href="#">Alle anzeigen →</a>
            </div>

            <div class="adm-table-card">
                @if($stats['recent_users']->isEmpty())
                    <div class="adm-empty-state">Noch keine Benutzer registriert.</div>
                @else
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Paket</th>
                                <th>Typ</th>
                                <th>Registriert</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['recent_users'] as $user)
                            <tr>
                                <td>
                                    <div class="adm-user-cell">
                                        <div class="adm-user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td style="color: var(--muted);">{{ $user->email }}</td>
                                <td>
                                    @if($user->selected_package)
                                        <span style="font-size: 13px; font-weight: 500;">{{ $user->selected_package }}</span>
                                    @else
                                        <span style="font-size: 12px; color: var(--muted-light);">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->selected_option_type === 'digital')
                                        <span class="adm-tag adm-tag--digital">Digital</span>
                                    @elseif($user->selected_option_type === 'onsite')
                                        <span class="adm-tag adm-tag--onsite">Vor Ort</span>
                                    @else
                                        <span class="adm-tag adm-tag--none">—</span>
                                    @endif
                                </td>
                                <td style="color: var(--muted); font-size: 12.5px;">
                                    {{ $user->created_at->format('d.m.Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div><!-- /adm-content -->
    </main>

</body>
</html>