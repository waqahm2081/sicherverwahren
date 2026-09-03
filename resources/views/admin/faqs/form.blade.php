<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $faq ? 'FAQ bearbeiten' : 'Neue FAQ' }} — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => $faq ? 'FAQ bearbeiten' : 'Neue FAQ'])

        <div class="adm-content">
            <form method="POST" action="{{ $faq ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
                  style="width:100%;background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:24px;">
                @csrf
                @if($faq) @method('PUT') @endif

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Frage</label>
                    <input type="text" name="question" value="{{ old('question', $faq?->question) }}" required
                           style="width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;">
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Antwort (HTML erlaubt)</label>
                    <textarea name="answer" rows="12" required
                              style="width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;">{{ old('answer', $faq?->answer) }}</textarea>
                </div>

                <div style="display:flex;gap:16px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:6px;">Reihenfolge</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $faq?->sort_order ?? 0) }}"
                               style="width:100px;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;">
                    </div>
                    <div style="padding-top:28px;">
                        <label style="display:flex;align-items:center;gap:8px;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq?->is_active ?? true) ? 'checked' : '' }}>
                            Aktiv
                        </label>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit" class="adm-btn adm-btn--primary">Speichern</button>
                    <a href="{{ route('admin.faqs.index') }}" class="adm-btn adm-btn--secondary">Abbrechen</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
