<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer verwalten — Admin</title>
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
            max-width: 340px;
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
            text-decoration: none;
            transition: background .15s;
        }
        .adm-filter-btn:hover { background: var(--bg); }
        .adm-filter-btn--active {
            background: rgba(111,84,164,.08);
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }

        /* Mini stats */
        .adm-mini-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        @media (max-width: 800px) { .adm-mini-stats { grid-template-columns: repeat(2, 1fr); } }
        .adm-mini-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .adm-mini-stat__icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .adm-mini-stat__icon svg { width: 18px; height: 18px; fill: white; }
        .adm-mini-stat__icon--purple { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .adm-mini-stat__icon--pink   { background: linear-gradient(135deg, var(--secondary), #d4a0d4); }
        .adm-mini-stat__icon--blue   { background: linear-gradient(135deg, #4a90d9, #6aaae8); }
        .adm-mini-stat__icon--teal   { background: linear-gradient(135deg, #2e9e6b, #3dbb82); }
        .adm-mini-stat__val  { font-size: 22px; font-weight: 700; color: var(--text); letter-spacing: -1px; line-height: 1; }
        .adm-mini-stat__lbl  { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

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
            transition: background .15s;
        }
        .adm-pagination__links a:hover { background: var(--bg); }
        .adm-pagination__links span[aria-current] {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border-color: var(--primary); font-weight: 600;
        }
        .adm-pagination__links span.disabled { opacity: .4; pointer-events: none; }

        .adm-user-cell { display:flex;align-items:center;gap:10px; }
        .adm-user-avatar {
            width:32px;height:32px;border-radius:50%;
            background:linear-gradient(135deg,var(--primary),var(--secondary));
            display:flex;align-items:center;justify-content:center;
            font-size:12px;font-weight:700;color:white;flex-shrink:0;
        }
        .adm-tag { display:inline-block;font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px; }
        .adm-tag--digital  { background:rgba(74,144,217,.1);color:#2d74be; }
        .adm-tag--onsite   { background:rgba(46,158,107,.1);color:#1d7a53; }
        .adm-tag--none     { background:var(--border);color:var(--muted); }
        .adm-tag--approved { background:rgba(46,158,107,.1);color:#1d7a53; }
        .adm-tag--pending  { background:rgba(230,160,30,.1);color:#b57d0a; }

        /* Approve button */
        .adm-approve-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            color: #1d7a53;
            background: rgba(46,158,107,.08);
            border: 1.5px solid rgba(46,158,107,.25);
            border-radius: 7px;
            padding: 4px 10px;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
        }
        .adm-approve-btn:hover { background: rgba(46,158,107,.16); }
        .adm-approve-btn svg  { width:12px;height:12px;fill:currentColor; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Benutzer verwalten'])

        <div class="adm-content">
            <div class="adm-page-header">
                <h1>Benutzer verwalten</h1>
                <p>Alle registrierten Kunden im Überblick.</p>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="adm-mini-stats">
                <div class="adm-mini-stat">
                    <div class="adm-mini-stat__icon adm-mini-stat__icon--purple">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div>
                        <div class="adm-mini-stat__val">{{ $stats['total'] }}</div>
                        <div class="adm-mini-stat__lbl">Benutzer gesamt</div>
                    </div>
                </div>
                <div class="adm-mini-stat">
                    <div class="adm-mini-stat__icon adm-mini-stat__icon--pink">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div>
                        <div class="adm-mini-stat__val">{{ $stats['ordered'] }}</div>
                        <div class="adm-mini-stat__lbl">Mit Bestellung</div>
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
            <form method="GET" action="{{ route('admin.users.index') }}" class="adm-filter-bar">
                <div class="adm-search-wrap">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, E-Mail oder Telefon...">
                </div>
                <select name="package" class="adm-filter-select">
                    <option value="">Alle Pakete</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg }}" {{ request('package') === $pkg ? 'selected' : '' }}>{{ $pkg }}</option>
                    @endforeach
                </select>
                <select name="type" class="adm-filter-select">
                    <option value="">Alle Typen</option>
                    <option value="digital" {{ request('type') === 'digital' ? 'selected' : '' }}>Digital</option>
                    <option value="onsite"  {{ request('type') === 'onsite'  ? 'selected' : '' }}>Vor Ort</option>
                </select>
                <select name="order_status" class="adm-filter-select">
                    <option value="">Alle Status</option>
                    <option value="ordered"  {{ request('order_status') === 'ordered'  ? 'selected' : '' }}>Mit Bestellung</option>
                    <option value="no_order" {{ request('order_status') === 'no_order' ? 'selected' : '' }}>Ohne Bestellung</option>
                </select>
                <button type="submit" class="adm-filter-btn {{ request()->hasAny(['search','package','type','order_status']) ? 'adm-filter-btn--active' : '' }}">
                    Filtern
                </button>
                @if(request()->hasAny(['search','package','type','order_status']))
                    <a href="{{ route('admin.users.index') }}" class="adm-filter-btn">Zurücksetzen</a>
                @endif
            </form>

            {{-- Table --}}
            <div class="adm-table-card">
                @if($users->isEmpty())
                    <div style="text-align:center;padding:48px;color:var(--muted);font-size:13.5px;">
                        Keine Benutzer gefunden.
                    </div>
                @else
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Benutzer</th>
                                <th>Telefon</th>
                                <th>Paket</th>
                                <th>Typ</th>
                                <th>Status</th>
                                <th>Registriert</th>
                                <th style="text-align:right;">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="adm-user-cell">
                                        <div class="adm-user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight:600;font-size:13.5px;color:var(--text);">{{ $user->name }}</div>
                                            <div style="font-size:12px;color:var(--muted);">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--muted);">{{ $user->phone ?? '—' }}</td>
                                <td style="font-size:13px;font-weight:500;color:var(--text-2);">
                                    {{ $user->selected_package ?? '—' }}
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
                                <td>
                                    @if($user->is_approved)
                                        <span class="adm-tag adm-tag--approved">✓ Freigegeben</span>
                                    @else
                                        <span class="adm-tag adm-tag--pending">⏳ Ausstehend</span>
                                    @endif
                                </td>
                                <td style="font-size:12.5px;color:var(--muted);">
                                    {{ $user->created_at->format('d.m.Y') }}<br>
                                    <span style="font-size:11px;">{{ $user->created_at->format('H:i') }} Uhr</span>
                                </td>
                                <td>
                                    <div class="adm-actions">
                                        {{-- Approve button — only shown if not yet approved --}}
                                        @if(! $user->is_approved)
                                            <form method="POST"
                                                  action="{{ route('admin.users.approve', $user) }}"
                                                  style="display:inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="adm-approve-btn" title="Freischalten">
                                                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                                    Freischalten
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="adm-action-btn adm-action-btn--edit" title="Bearbeiten">
                                            <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              data-confirm="true"
                                              data-confirm-type="Benutzer"
                                              data-confirm-name="{{ $user->name }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="adm-action-btn adm-action-btn--delete" title="Löschen">
                                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($users->hasPages())
                    <div class="adm-pagination">
                        <span>{{ $users->firstItem() }}–{{ $users->lastItem() }} von {{ $users->total() }} Benutzern</span>
                        <div class="adm-pagination__links">
                            @if($users->onFirstPage())
                                <span class="disabled"><svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"><svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></a>
                            @endif

                            @foreach($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
                                @if($page == $users->currentPage())
                                    <span aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"><svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></a>
                            @else
                                <span class="disabled"><svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></span>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </main>

    @include('admin.partials.delete-modal')
</body>
</html>