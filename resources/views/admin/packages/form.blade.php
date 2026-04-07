<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($package) ? 'Paket bearbeiten' : 'Neues Paket' }} — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => isset($package) ? 'Paket bearbeiten' : 'Neues Paket'])

        <div class="adm-content">
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>{{ isset($package) ? 'Paket bearbeiten' : 'Neues Paket erstellen' }}</h1>
                    <p>{{ isset($package) ? 'Änderungen an "'.$package->name.'" vornehmen.' : 'Ein neues Preispaket anlegen.' }}</p>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zurück
                </a>
            </div>

            @if($errors->any())
                <div class="adm-alert adm-alert--error" style="margin-bottom:20px;">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span>Bitte korrigieren Sie die markierten Felder.</span>
                </div>
            @endif

            <form method="POST" action="{{ isset($package) ? route('admin.packages.update', $package) : route('admin.packages.store') }}" id="packageForm">
                @csrf
                @if(isset($package)) @method('PUT') @endif

                {{-- Basic Info --}}
                <div class="adm-form-card">
                    <div class="adm-form-card__title">Paketinformationen</div>

                    <div class="adm-form-row adm-form-row--2">
                        <div class="adm-field {{ $errors->has('name') ? 'adm-field--error' : '' }}">
                            <label for="name">Paketname *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $package->name ?? '') }}" placeholder="z.B. Private Starter" required>
                            @error('name') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>

                        <div class="adm-field {{ $errors->has('category') ? 'adm-field--error' : '' }}">
                            <label for="category">Kategorie *</label>
                            <select id="category" name="category" required>
                                <option value="">— Wählen —</option>
                                <option value="private"  {{ old('category', $package->category ?? '') === 'private'  ? 'selected' : '' }}>Private</option>
                                <option value="business" {{ old('category', $package->category ?? '') === 'business' ? 'selected' : '' }}>Business</option>
                            </select>
                            @error('category') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="adm-form-row adm-form-row--2">
                        <div class="adm-field {{ $errors->has('portfolio_label') ? 'adm-field--error' : '' }}">
                            <label for="portfolio_label">Portfolio-Label *</label>
                            <input type="text" id="portfolio_label" name="portfolio_label" value="{{ old('portfolio_label', $package->portfolio_label ?? '') }}" placeholder="z.B. bis 25.000 CHF Portfolio" required>
                            @error('portfolio_label') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>

                        <div class="adm-field {{ $errors->has('sort_order') ? 'adm-field--error' : '' }}">
                            <label for="sort_order">Reihenfolge *</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $package->sort_order ?? 1) }}" min="0" required>
                            @error('sort_order') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="adm-checkbox-row">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active">Paket aktiv (auf der Website sichtbar)</label>
                    </div>
                </div>

                {{-- Options --}}
                <div class="adm-form-card">
                    <div class="adm-form-card__title" style="display:flex;align-items:center;justify-content:space-between;">
                        Optionen & Preise
                        <button type="button" class="adm-btn adm-btn--secondary" style="font-size:12px;padding:6px 12px;" onclick="addOption()">
                            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            Option hinzufügen
                        </button>
                    </div>

                    <div id="optionsContainer">
                        @php
                            $existingOptions = isset($package) ? $package->options : collect();
                            $oldOptions = old('options', []);
                        @endphp

                        @if($existingOptions->isNotEmpty())
                            @foreach($existingOptions as $i => $opt)
                                <div class="adm-option-block" data-index="{{ $i }}">
                                    <div class="adm-option-block__header">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <span class="adm-option-type-badge adm-option-type-badge--{{ $opt->type }}">
                                                {{ $opt->type === 'digital' ? 'Digital' : 'Vor Ort' }}
                                            </span>
                                            <span class="adm-option-block__title">{{ $opt->label }}</span>
                                        </div>
                                        <button type="button" class="adm-btn adm-btn--danger" style="font-size:12px;padding:5px 10px;" onclick="removeOption(this)">
                                            Entfernen
                                        </button>
                                    </div>

                                    <input type="hidden" name="options[{{ $i }}][type]" value="{{ $opt->type }}">

                                    <div class="adm-form-row adm-form-row--3" style="margin-bottom:14px;">
                                        <div class="adm-field">
                                            <label>Typ</label>
                                            <select name="options[{{ $i }}][type]" onchange="updateBadge(this)">
                                                <option value="digital" {{ $opt->type === 'digital' ? 'selected' : '' }}>Digital</option>
                                                <option value="onsite"  {{ $opt->type === 'onsite'  ? 'selected' : '' }}>Vor Ort</option>
                                            </select>
                                        </div>
                                        <div class="adm-field">
                                            <label>Preis (CHF) *</label>
                                            <input type="number" name="options[{{ $i }}][price_chf]" value="{{ $opt->price_chf }}" min="0" required>
                                        </div>
                                        <div class="adm-field">
                                            <label>Reihenfolge</label>
                                            <input type="number" name="options[{{ $i }}][sort_order]" value="{{ $opt->sort_order }}" min="1">
                                        </div>
                                    </div>

                                    <div class="adm-form-row adm-form-row--2" style="margin-bottom:16px;">
                                        <div class="adm-checkbox-row">
                                            <input type="checkbox" name="options[{{ $i }}][is_recommended]" value="1" {{ $opt->is_recommended ? 'checked' : '' }}>
                                            <label>Empfohlen (Badge anzeigen)</label>
                                        </div>
                                        <div class="adm-checkbox-row">
                                            <input type="checkbox" name="options[{{ $i }}][is_only_option]" value="1" {{ $opt->is_only_option ? 'checked' : '' }}>
                                            <label>Einzige Option (kein Tab)</label>
                                        </div>
                                    </div>

                                    <div style="font-size:12.5px;font-weight:600;color:var(--text);margin-bottom:10px;">Features</div>
                                    <div class="adm-feature-list" id="features_{{ $i }}">
                                        @foreach($opt->features as $fi => $feat)
                                            <div class="adm-feature-row">
                                                <input type="text" name="options[{{ $i }}][features][{{ $fi }}][feature]" value="{{ $feat->feature }}" placeholder="Feature beschreiben...">
                                                <div class="adm-checkbox-row" style="flex-shrink:0;">
                                                    <input type="checkbox" name="options[{{ $i }}][features][{{ $fi }}][is_inherited]" value="1" title="Geerbt" {{ $feat->is_inherited ? 'checked' : '' }}>
                                                    <label style="font-size:11px;white-space:nowrap;">Geerbt</label>
                                                </div>
                                                <button type="button" class="adm-remove-btn" onclick="removeFeature(this)">
                                                    <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="adm-add-feature-btn" onclick="addFeature({{ $i }})">
                                        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                                        Feature hinzufügen
                                    </button>
                                </div>
                            @endforeach
                        @else
                            {{-- Empty state shown when creating new --}}
                            <div id="emptyOptions" style="text-align:center;padding:32px;color:var(--muted);font-size:13.5px;border:1.5px dashed var(--border);border-radius:10px;">
                                Noch keine Optionen. Klicken Sie auf "Option hinzufügen".
                            </div>
                        @endif
                    </div>
                </div>

                <div class="adm-form-footer">
                    <button type="submit" class="adm-btn adm-btn--primary">
                        <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                        {{ isset($package) ? 'Änderungen speichern' : 'Paket erstellen' }}
                    </button>
                    <a href="{{ route('admin.packages.index') }}" class="adm-btn adm-btn--secondary">Abbrechen</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        let optionCount = {{ isset($package) ? $package->options->count() : 0 }};

        function addOption() {
            const empty = document.getElementById('emptyOptions');
            if (empty) empty.remove();

            const i = optionCount++;
            const html = `
                <div class="adm-option-block" data-index="${i}">
                    <div class="adm-option-block__header">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span class="adm-option-type-badge adm-option-type-badge--digital" id="badge_${i}">Digital</span>
                            <span class="adm-option-block__title">Neue Option</span>
                        </div>
                        <button type="button" class="adm-btn adm-btn--danger" style="font-size:12px;padding:5px 10px;" onclick="removeOption(this)">
                            Entfernen
                        </button>
                    </div>
                    <div class="adm-form-row adm-form-row--3" style="margin-bottom:14px;">
                        <div class="adm-field">
                            <label>Typ</label>
                            <select name="options[${i}][type]" onchange="updateBadge(this, ${i})">
                                <option value="digital">Digital</option>
                                <option value="onsite">Vor Ort</option>
                            </select>
                        </div>
                        <div class="adm-field">
                            <label>Preis (CHF) *</label>
                            <input type="number" name="options[${i}][price_chf]" placeholder="999" min="0" required>
                        </div>
                        <div class="adm-field">
                            <label>Reihenfolge</label>
                            <input type="number" name="options[${i}][sort_order]" value="${i + 1}" min="1">
                        </div>
                    </div>
                    <div class="adm-form-row adm-form-row--2" style="margin-bottom:16px;">
                        <div class="adm-checkbox-row">
                            <input type="checkbox" name="options[${i}][is_recommended]" value="1">
                            <label>Empfohlen</label>
                        </div>
                        <div class="adm-checkbox-row">
                            <input type="checkbox" name="options[${i}][is_only_option]" value="1">
                            <label>Einzige Option</label>
                        </div>
                    </div>
                    <div style="font-size:12.5px;font-weight:600;color:var(--text);margin-bottom:10px;">Features</div>
                    <div class="adm-feature-list" id="features_${i}"></div>
                    <button type="button" class="adm-add-feature-btn" onclick="addFeature(${i})">
                        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Feature hinzufügen
                    </button>
                </div>`;
            document.getElementById('optionsContainer').insertAdjacentHTML('beforeend', html);
        }

        function removeOption(btn) {
            if (!confirm('Option wirklich entfernen?')) return;
            btn.closest('.adm-option-block').remove();
        }

        function updateBadge(select, idx) {
            const badge = document.getElementById('badge_' + idx);
            if (!badge) return;
            const isDigital = select.value === 'digital';
            badge.textContent = isDigital ? 'Digital' : 'Vor Ort';
            badge.className = 'adm-option-type-badge adm-option-type-badge--' + select.value;
        }

        function addFeature(optIdx) {
            const list = document.getElementById('features_' + optIdx);
            const fi = list.children.length;
            const html = `
                <div class="adm-feature-row">
                    <input type="text" name="options[${optIdx}][features][${fi}][feature]" placeholder="Feature beschreiben...">
                    <div class="adm-checkbox-row" style="flex-shrink:0;">
                        <input type="checkbox" name="options[${optIdx}][features][${fi}][is_inherited]" value="1" title="Geerbt">
                        <label style="font-size:11px;white-space:nowrap;">Geerbt</label>
                    </div>
                    <button type="button" class="adm-remove-btn" onclick="removeFeature(this)">
                        <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                </div>`;
            list.insertAdjacentHTML('beforeend', html);
        }

        function removeFeature(btn) {
            btn.closest('.adm-feature-row').remove();
        }
    </script>
</body>
</html>