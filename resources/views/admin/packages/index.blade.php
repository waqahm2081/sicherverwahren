<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakete verwalten — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Pakete verwalten'])

        <div class="adm-content">
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Pakete verwalten</h1>
                    <p>Alle Preispakete und deren Optionen im Überblick.</p>
                </div>
                <a href="{{ route('admin.packages.create') }}" class="adm-btn adm-btn--primary">
                    <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Neues Paket
                </a>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @foreach(['private' => 'Private Pakete', 'business' => 'Business Pakete'] as $cat => $label)
                @php $catPackages = $packages->where('category', $cat); @endphp
                @if($catPackages->isNotEmpty())
                <div class="adm-section-block">
                    <div class="adm-section-heading">
                        <span class="adm-category-badge adm-category-badge--{{ $cat }}">{{ ucfirst($cat) }}</span>
                        {{ $label }}
                    </div>

                    <div class="adm-table-card">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Name</th>
                                    <th>Portfolio</th>
                                    <th>Digital</th>
                                    <th>Vor Ort</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Aktionen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($catPackages->sortBy('sort_order') as $pkg)
                                <tr>
                                    <td style="color:var(--muted-light);font-size:12px;">{{ $pkg->sort_order }}</td>
                                    <td>
                                        <span style="font-weight:600;color:var(--text);">{{ $pkg->name }}</span>
                                        <span style="display:block;font-size:11.5px;color:var(--muted);">{{ $pkg->slug }}</span>
                                    </td>
                                    <td style="font-size:13px;color:var(--text-2);">{{ $pkg->portfolio_label }}</td>
                                    <td>
                                        @if($pkg->digitalOption())
                                            <span class="adm-price-tag adm-price-tag--digital">
                                                CHF {{ number_format($pkg->digitalOption()->price_chf, 0, '.', "'") }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted-light);font-size:12px;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pkg->onsiteOption())
                                            <span class="adm-price-tag adm-price-tag--onsite">
                                                CHF {{ number_format($pkg->onsiteOption()->price_chf, 0, '.', "'") }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted-light);font-size:12px;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.packages.toggle', $pkg) }}" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="adm-status-toggle {{ $pkg->is_active ? 'adm-status-toggle--active' : 'adm-status-toggle--inactive' }}">
                                                {{ $pkg->is_active ? 'Aktiv' : 'Inaktiv' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="adm-actions">
                                            <a href="{{ route('admin.packages.edit', $pkg) }}" class="adm-action-btn adm-action-btn--edit" title="Bearbeiten">
                                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.packages.destroy', $pkg) }}"
                                                data-confirm="true"
                                                data-confirm-type="Paket"
                                                data-confirm-name="{{ $pkg->name }}">
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
                    </div>
                </div>
                @endif
            @endforeach

        </div>
    </main>

    @include('admin.partials.delete-modal')
</body>
</html>