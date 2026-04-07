<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellungen — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .adm-filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .adm-search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
            max-width: 360px;
        }
        .adm-search-wrap svg {
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            width: 15px; height: 15px;
            fill: var(--muted-light);
            pointer-events: none;
        }
        .adm-search-wrap input {
            width: 100%;
            padding: 8px 12px 8px 34px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .adm-search-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(111,84,164,.1);
        }
        .adm-filter-select {
            padding: 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--surface);
            outline: none;
            cursor: pointer;
            transition: border-color .15s;
        }
        .adm-filter-select:focus { border-color: var(--primary); }
        .adm-filter-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            transition: background .15s;
        }
        .adm-filter-btn:hover { background: var(--bg); }
        .adm-filter-btn--active {
            background: rgba(111,84,164,.08);
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }

        /* Mini stat row */
        .adm-mini-stats {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .adm-mini-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 140px;
        }
        .adm-mini-stat__icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .adm-mini-stat__icon svg { width: 18px; height: 18px; fill: white; }
        .adm-mini-stat__icon--purple { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .adm-mini-stat__icon--blue   { background: linear-gradient(135deg, #4a90d9, #6aaae8); }
        .adm-mini-stat__icon--teal   { background: linear-gradient(135deg, #2e9e6b, #3dbb82); }
        .adm-mini-stat__val  { font-size: 22px; font-weight: 700; color: var(--text); letter-spacing: -1px; line-height: 1; }
        .adm-mini-stat__lbl  { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

        /* Order ID chip */
        .adm-order-id {
            font-size: 11px; font-weight: 700;
            font-variant-numeric: tabular-nums;
            color: var(--muted);
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 2px 7px; border-radius: 5px;
            letter-spacing: .3px;
        }

        /* Pagination */
        .adm-pagination {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px;
            border-top: 1px solid var(--border-light);
            font-size: 13px; color: var(--muted);
        }
        .adm-pagination__links { display: flex; gap: 4px; }
        .adm-pagination__links a,
        .adm-pagination__links span {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px;
            font-size: 13px; text-decoration: none;
            border: 1px solid var(--border); color: var(--text);
            transition: background .15s, border-color .15s, color .15s;
        }
        .adm-pagination__links a:hover { background: var(--bg); }
        .adm-pagination__links span[aria-current] {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border-color: var(--primary);
            font-weight: 600;
        }
        .adm-pagination__links span.disabled { opacity: .4; pointer-events: none; }

        .adm-view-btn {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12.5px; font-weight: 500;
            color: var(--primary); text-decoration: none;
            padding: 5px 10px; border-radius: 7px;
            border: 1px solid rgba(111,84,164,.2);
            background: rgba(111,84,164,.05);
            transition: background .15s;
        }
        .adm-view-btn:hover { background: rgba(111,84,164,.1); }
        .adm-view-btn svg { width: 13px; height: 13px; fill: currentColor; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Bestellungen'])

        <div class="adm-content">
            <div class="adm-page-header">
                <h1>Bestellungen verwalten</h1>
                <p>Alle eingegangenen Paketbuchungen im Überblick.</p>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Mini stats --}}
            <div class="adm-mini-stats">
                <div class="adm-mini-stat">
                    <div class="adm-mini-stat__icon adm-mini-stat__icon--purple">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div>
                        <div class="adm-mini-stat__val">{{ $stats['total'] }}</div>
                        <div class="adm-mini-stat__lbl">Bestellungen gesamt</div>
                    </div>
                </div>
                <div class="adm-mini-stat">
                    <div class="adm-mini-stat__icon adm-mini-stat__icon--blue">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25S13.24 11.25 12 11.25 9.75 10.24 9.75 9 10.76 6.75 12 6.75zM17 17H7v-.75c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                    </div>
                    <div>
                        <div class="adm-mini-stat__val">{{ $stats['digital'] }}</div>
                        <div class="adm-mini-stat__lbl">Digital</div>
                    </div>
                </div>
                <div class="adm-mini-stat">
                    <div class="adm-mini-stat__icon adm-mini-stat__icon--teal">
                        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <div>
                        <div class="adm-mini-stat__val">{{ $stats['onsite'] }}</div>
                        <div class="adm-mini-stat__lbl">Vor Ort</div>
                    </div>
                </div>
            </div>

            {{-- Filter bar --}}
            <form method="GET" action="{{ route('admin.orders.index') }}" class="adm-filter-bar">
                <div class="adm-search-wrap">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, E-Mail oder Paket...">
                </div>
                <select name="type" class="adm-filter-select">
                    <option value="">Alle Typen</option>
                    <option value="digital" {{ request('type') === 'digital' ? 'selected' : '' }}>Digital</option>
                    <option value="onsite"  {{ request('type') === 'onsite'  ? 'selected' : '' }}>Vor Ort</option>
                </select>
                <button type="submit" class="adm-filter-btn {{ request()->hasAny(['search','type']) ? 'adm-filter-btn--active' : '' }}">
                    Filtern
                </button>
                @if(request()->hasAny(['search','type']))
                    <a href="{{ route('admin.orders.index') }}" class="adm-filter-btn">Zurücksetzen</a>
                @endif
            </form>

            {{-- Table --}}
            <div class="adm-table-card">
                @if($orders->isEmpty())
                    <div class="adm-empty-state" style="text-align:center;padding:48px;color:var(--muted);font-size:13.5px;">
                        Keine Bestellungen gefunden.
                    </div>
                @else
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Bestell-Nr.</th>
                                <th>Kunde</th>
                                <th>Paket</th>
                                <th>Typ</th>
                                <th>Telefon</th>
                                <th>Datum</th>
                                <th style="text-align:right;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <span class="adm-order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="adm-user-cell">
                                        <div class="adm-user-avatar">{{ strtoupper(substr($order->name, 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight:600;font-size:13.5px;">{{ $order->name }}</div>
                                            <div style="font-size:12px;color:var(--muted);">{{ $order->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;font-weight:500;color:var(--text-2);">
                                    {{ $order->selected_package }}
                                </td>
                                <td>
                                    @if($order->selected_option_type === 'digital')
                                        <span class="adm-tag adm-tag--digital">Digital</span>
                                    @elseif($order->selected_option_type === 'onsite')
                                        <span class="adm-tag adm-tag--onsite">Vor Ort</span>
                                    @else
                                        <span class="adm-tag adm-tag--none">—</span>
                                    @endif
                                </td>
                                <td style="font-size:13px;color:var(--muted);">
                                    {{ $order->phone ?? '—' }}
                                </td>
                                <td style="font-size:12.5px;color:var(--muted);">
                                    {{ $order->created_at->format('d.m.Y') }}<br>
                                    <span style="font-size:11px;">{{ $order->created_at->format('H:i') }} Uhr</span>
                                </td>
                                <td style="text-align:right;">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="adm-view-btn">
                                        <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                        Anzeigen
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if($orders->hasPages())
                    <div class="adm-pagination">
                        <span>{{ $orders->firstItem() }}–{{ $orders->lastItem() }} von {{ $orders->total() }} Bestellungen</span>
                        <div class="adm-pagination__links">
                            {{-- Previous --}}
                            @if($orders->onFirstPage())
                                <span class="disabled">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @foreach($orders->getUrlRange(max(1,$orders->currentPage()-2), min($orders->lastPage(),$orders->currentPage()+2)) as $page => $url)
                                @if($page == $orders->currentPage())
                                    <span aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                </a>
                            @else
                                <span class="disabled">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </main>

    <style>
        .adm-user-cell { display:flex;align-items:center;gap:10px; }
        .adm-user-avatar {
            width:32px;height:32px;border-radius:50%;
            background:linear-gradient(135deg,var(--primary),var(--secondary));
            display:flex;align-items:center;justify-content:center;
            font-size:12px;font-weight:700;color:white;flex-shrink:0;
        }
        .adm-tag {
            display:inline-block;font-size:11px;font-weight:600;
            padding:3px 8px;border-radius:20px;text-transform:capitalize;
        }
        .adm-tag--digital { background:rgba(74,144,217,.1);color:#2d74be; }
        .adm-tag--onsite  { background:rgba(46,158,107,.1);color:#1d7a53; }
        .adm-tag--none    { background:var(--border);color:var(--muted); }
    </style>
</body>
</html>