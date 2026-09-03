<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Leads'])

        <div class="adm-content">
            @if(session('success'))
                <div class="adm-alert adm-alert--success">{{ session('success') }}</div>
            @endif

            <div class="adm-page-header">
                <div>
                    <h1>Leads</h1>
                    <p>Selbsttest- und Trainingsanfragen verwalten.</p>
                </div>
            </div>

            <form method="GET" class="adm-filter-bar" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name oder E-Mail suchen…"
                       style="flex:1;min-width:200px;padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;">
                <select name="status" style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;">
                    <option value="">Alle Status</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="adm-btn adm-btn--primary">Filtern</button>
            </form>

            <div class="adm-detail-card" style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;">
                <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                    <thead>
                        <tr style="background:var(--surface-2);text-align:left;">
                            <th style="padding:12px 16px;">Datum</th>
                            <th style="padding:12px 16px;">Name</th>
                            <th style="padding:12px 16px;">E-Mail</th>
                            <th style="padding:12px 16px;">Quelle</th>
                            <th style="padding:12px 16px;">Status</th>
                            <th style="padding:12px 16px;">Follow-up</th>
                            <th style="padding:12px 16px;">Notizen</th>
                            <th style="padding:12px 16px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr style="border-top:1px solid var(--border-light);vertical-align:top;">
                                <td style="padding:12px 16px;white-space:nowrap;">{{ $lead->created_at->format('d.m.Y H:i') }}</td>
                                <td style="padding:12px 16px;">{{ $lead->name }}</td>
                                <td style="padding:12px 16px;"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
                                <td style="padding:12px 16px;">{{ $lead->source }}</td>
                                <td style="padding:12px 16px;">
                                    <form method="POST" action="{{ route('admin.leads.update', $lead) }}" id="lead-form-{{ $lead->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" style="padding:6px 8px;border:1px solid var(--border);border-radius:6px;font-size:12px;">
                                            @foreach($statuses as $value => $label)
                                                <option value="{{ $value }}" @selected(($lead->status ?? 'new') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td style="padding:12px 16px;color:var(--muted);font-size:12px;">
                                    @if($lead->followup_sent_at)
                                        {{ $lead->followup_sent_at->format('d.m.Y') }}
                                    @else
                                        Ausstehend
                                    @endif
                                </td>
                                <td style="padding:12px 16px;">
                                        <textarea name="notes" rows="2" placeholder="Notizen…"
                                                  style="width:100%;min-width:180px;padding:6px 8px;border:1px solid var(--border);border-radius:6px;font-size:12px;">{{ $lead->notes }}</textarea>
                                </td>
                                <td style="padding:12px 16px;white-space:nowrap;">
                                        <button type="submit" class="adm-btn adm-btn--secondary" style="padding:4px 10px;font-size:12px;margin-bottom:6px;display:block;">Speichern</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Lead löschen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;font-size:12px;">Löschen</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:24px;text-align:center;color:var(--muted);">Keine Leads gefunden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">{{ $leads->links() }}</div>
        </div>
    </main>
</body>
</html>
