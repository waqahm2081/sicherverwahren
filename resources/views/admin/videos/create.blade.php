<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neues Video — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .pkg-checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; margin-top: 8px; }
        .pkg-checkbox-item { display: flex; align-items: center; gap: 8px; padding: 10px 14px;
                             border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer;
                             transition: border-color .15s, background .15s; }
        .pkg-checkbox-item:has(input:checked) { border-color: #6f54a4; background: #f5f1fc; }
        .pkg-checkbox-item input { accent-color: #6f54a4; width: 16px; height: 16px; cursor: pointer; }
        .pkg-checkbox-item label { cursor: pointer; font-size: 13.5px; font-weight: 500; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Neues Video'])
        <div class="adm-content">
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Neues Video erstellen</h1>
                    <p>Video-URL von S3 einfügen und Pakete zuweisen.</p>
                </div>
                <a href="{{ route('admin.videos.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zurück
                </a>
            </div>

            @if($errors->any())
                <div class="adm-alert adm-alert--error" style="margin-bottom:20px;">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Bitte korrigieren Sie die markierten Felder.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.videos.store') }}">
                @csrf
                <div class="adm-form-card">
                    <div class="adm-form-card__title">Video-Informationen</div>

                    <div class="adm-field {{ $errors->has('title') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                        <label for="title">Titel *</label>
                        <input type="text" id="title" name="title"
                               value="{{ old('title') }}" placeholder="z.B. Bitcoin Grundlagen erklärt" required>
                        @error('title') <div class="adm-field__error">{{ $message }}</div> @enderror
                    </div>

                    <div class="adm-field {{ $errors->has('description') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                        <label for="description">Kurzbeschreibung</label>
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Was lernt der Nutzer in diesem Video?">{{ old('description') }}</textarea>
                        @error('description') <div class="adm-field__error">{{ $message }}</div> @enderror
                    </div>

                    <div class="adm-field {{ $errors->has('video_url') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                        <label for="video_url">Video-URL (S3) *</label>
                        <input type="url" id="video_url" name="video_url"
                               value="{{ old('video_url') }}"
                               placeholder="https://your-bucket.s3.eu-central-1.amazonaws.com/videos/intro.mp4" required>
                        @error('video_url') <div class="adm-field__error">{{ $message }}</div> @enderror
                    </div>

                    <div class="adm-form-row adm-form-row--3">
                        <div class="adm-field {{ $errors->has('tag') ? 'adm-field--error' : '' }}">
                            <label for="tag">Tag / Kategorie</label>
                            <input type="text" id="tag" name="tag"
                                   value="{{ old('tag') }}" placeholder="z.B. Einführung">
                            @error('tag') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                        <div class="adm-field {{ $errors->has('duration') ? 'adm-field--error' : '' }}">
                            <label for="duration">Dauer</label>
                            <input type="text" id="duration" name="duration"
                                   value="{{ old('duration') }}" placeholder="z.B. 18:42">
                            @error('duration') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                        <div class="adm-field {{ $errors->has('sort_order') ? 'adm-field--error' : '' }}">
                            <label for="sort_order">Reihenfolge *</label>
                            <input type="number" id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', 0) }}" min="0" required>
                            @error('sort_order') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="adm-checkbox-row" style="margin-top:16px;">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active">Video aktiv (im Dashboard sichtbar)</label>
                    </div>
                </div>

                <div class="adm-form-card">
                    <div class="adm-form-card__title">Pakete zuweisen</div>
                    <p style="font-size:13px;color:#888;margin-bottom:12px;">
                        Wählen Sie, welche Pakete Zugriff auf dieses Video erhalten.
                    </p>
                    <div class="pkg-checkbox-grid">
                        @foreach($packages as $pkg)
                        <div class="pkg-checkbox-item">
                            <input type="checkbox" id="pkg_{{ $pkg->id }}"
                                   name="packages[]" value="{{ $pkg->id }}"
                                   {{ in_array($pkg->id, old('packages', [])) ? 'checked' : '' }}>
                            <label for="pkg_{{ $pkg->id }}">{{ $pkg->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="adm-form-footer">
                    <button type="submit" class="adm-btn adm-btn--primary">
                        <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                        Video erstellen
                    </button>
                    <a href="{{ route('admin.videos.index') }}" class="adm-btn adm-btn--secondary">Abbrechen</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>