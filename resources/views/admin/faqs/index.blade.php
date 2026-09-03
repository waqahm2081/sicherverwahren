<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'FAQs verwalten'])

        <div class="adm-content">
            @if(session('success'))
                <div class="adm-alert adm-alert--success">{{ session('success') }}</div>
            @endif

            <div class="adm-page-header" style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <h1>FAQs</h1>
                    <p>Fragen und Antworten auf der FAQ-Seite bearbeiten.</p>
                </div>
                <a href="{{ route('admin.faqs.create') }}" class="adm-btn adm-btn--primary">Neue FAQ</a>
            </div>

            <div class="adm-detail-card" style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;">
                <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                    <thead>
                        <tr style="background:var(--surface-2);text-align:left;">
                            <th style="padding:12px 16px;">#</th>
                            <th style="padding:12px 16px;">Frage</th>
                            <th style="padding:12px 16px;">Aktiv</th>
                            <th style="padding:12px 16px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr style="border-top:1px solid var(--border-light);">
                                <td style="padding:12px 16px;">{{ $faq->sort_order + 1 }}</td>
                                <td style="padding:12px 16px;">{{ Str::limit($faq->question, 80) }}</td>
                                <td style="padding:12px 16px;">{{ $faq->is_active ? 'Ja' : 'Nein' }}</td>
                                <td style="padding:12px 16px;white-space:nowrap;">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}">Bearbeiten</a>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" style="display:inline;" onsubmit="return confirm('FAQ löschen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;margin-left:8px;">Löschen</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding:24px;text-align:center;color:var(--muted);">
                                    Keine FAQs. <a href="{{ route('admin.faqs.create') }}">Erste FAQ anlegen</a> oder <code>php artisan db:seed --class=FaqSeeder</code> ausführen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
