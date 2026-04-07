<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer bearbeiten — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .adm-edit-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }
        @media (max-width: 960px) { .adm-edit-grid { grid-template-columns: 1fr; } }

        .adm-detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .adm-detail-card:last-child { margin-bottom: 0; }

        .adm-detail-card__header {
            display: flex; align-items: center; gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
            background: var(--surface-2);
        }
        .adm-detail-card__header-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .adm-detail-card__header-icon svg { width: 16px; height: 16px; fill: white; }
        .adm-detail-card__header-icon--purple { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .adm-detail-card__header-icon--blue   { background: linear-gradient(135deg, #4a90d9, #6aaae8); }
        .adm-detail-card__header-icon--teal   { background: linear-gradient(135deg, #2e9e6b, #3dbb82); }
        .adm-detail-card__header-icon--orange { background: linear-gradient(135deg, #e07b2e, #f0993a); }
        .adm-detail-card__header-icon--red    { background: linear-gradient(135deg, #d94f4f, #e87070); }
        .adm-detail-card__title { font-size: 14px; font-weight: 600; color: var(--text); }

        .adm-detail-card__body { padding: 20px; }

        /* Password toggle */
        .adm-pw-wrap { position: relative; }
        .adm-pw-wrap input { padding-right: 40px; }
        .adm-pw-toggle {
            position: absolute; right: 10px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--muted-light); padding: 4px;
            display: flex; align-items: center; justify-content: center;
            transition: color .15s;
        }
        .adm-pw-toggle:hover { color: var(--primary); }
        .adm-pw-toggle svg { width: 16px; height: 16px; fill: currentColor; }

        /* Password strength bar */
        .adm-pw-strength { margin-top: 8px; }
        .adm-pw-strength__bar {
            height: 4px; background: var(--border);
            border-radius: 99px; overflow: hidden; margin-bottom: 4px;
        }
        .adm-pw-strength__fill {
            height: 100%; border-radius: 99px;
            transition: width .3s, background .3s;
            width: 0%;
        }
        .adm-pw-strength__label { font-size: 11px; color: var(--muted); }

        /* User profile hero */
        .adm-user-hero {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            padding: 24px;
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }
        .adm-user-hero__avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; font-weight: 700;
            margin: 0 auto 12px;
            border: 3px solid rgba(255,255,255,.3);
        }
        .adm-user-hero__name  { font-family: 'DM Serif Display', serif; font-size: 20px; font-weight: 400; margin-bottom: 4px; }
        .adm-user-hero__email { font-size: 12.5px; opacity: .75; word-break: break-all; }
        .adm-user-hero__id    { display: inline-block; margin-top: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; background: rgba(255,255,255,.15); padding: 3px 10px; border-radius: 20px; }

        /* Meta info rows */
        .adm-meta-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid var(--border-light);
            font-size: 13px;
        }
        .adm-meta-row:last-child { border-bottom: none; padding-bottom: 0; }
        .adm-meta-row:first-child { padding-top: 0; }
        .adm-meta-row__label { color: var(--muted); font-size: 12px; }
        .adm-meta-row__value { color: var(--text); font-weight: 500; text-align: right; }

        /* Danger zone */
        .adm-danger-zone {
            border: 1.5px solid #fecaca;
            border-radius: 12px;
            padding: 18px;
            background: #fffbfb;
        }
        .adm-danger-zone__title {
            font-size: 13.5px; font-weight: 600; color: var(--error);
            margin-bottom: 8px;
            display: flex; align-items: center; gap: 7px;
        }
        .adm-danger-zone__title svg { width: 16px; height: 16px; fill: currentColor; }
        .adm-danger-zone__text {
            font-size: 12.5px; color: var(--muted); margin-bottom: 14px; line-height: 1.5;
        }
        .adm-btn--full-danger {
            width: 100%;
            padding: 10px;
            background: var(--error);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: opacity .15s;
        }
        .adm-btn--full-danger:hover { opacity: .88; }

        .adm-tag { display:inline-block;font-size:11px;font-weight:600;padding:2px 7px;border-radius:20px; }
        .adm-tag--digital { background:rgba(74,144,217,.1);color:#2d74be; }
        .adm-tag--onsite  { background:rgba(46,158,107,.1);color:#1d7a53; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Benutzer bearbeiten'])

        <div class="adm-content">
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Benutzer bearbeiten</h1>
                    <p>Daten von <strong>{{ $user->name }}</strong> anpassen.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zurück zur Liste
                </a>
            </div>

            @if($errors->any())
                <div class="adm-alert adm-alert--error" style="margin-bottom:20px;">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span>Bitte korrigieren Sie die markierten Felder.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" id="userForm">
                @csrf @method('PUT')

                <div class="adm-edit-grid">
                    {{-- LEFT: forms --}}
                    <div>
                        {{-- Personal info --}}
                        <div class="adm-detail-card">
                            <div class="adm-detail-card__header">
                                <div class="adm-detail-card__header-icon adm-detail-card__header-icon--purple">
                                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                                <div class="adm-detail-card__title">Persönliche Daten</div>
                            </div>
                            <div class="adm-detail-card__body">
                                <div class="adm-form-row adm-form-row--2">
                                    <div class="adm-field {{ $errors->has('name') ? 'adm-field--error' : '' }}">
                                        <label for="name">Vollständiger Name *</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $user->name) }}"
                                            placeholder="Max Mustermann" required>
                                        @error('name') <div class="adm-field__error">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="adm-field {{ $errors->has('phone') ? 'adm-field--error' : '' }}">
                                        <label for="phone">Telefonnummer</label>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            placeholder="+41 79 000 00 00">
                                        @error('phone') <div class="adm-field__error">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="adm-field {{ $errors->has('email') ? 'adm-field--error' : '' }}">
                                    <label for="email">E-Mail-Adresse *</label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        placeholder="benutzer@example.com" required>
                                    @error('email') <div class="adm-field__error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Package assignment --}}
                        <div class="adm-detail-card">
                            <div class="adm-detail-card__header">
                                <div class="adm-detail-card__header-icon adm-detail-card__header-icon--teal">
                                    <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.35C18 2.53 15.9.5 13.35.5c-1.3 0-2.43.52-3.25 1.33L9 2.96l-1.1-1.13C7.08 1.01 5.95.5 4.65.5 2.1.5 0 2.53 0 4.65c0 .47.08.91.18 1.35H0v14h24V6h-4zm-3.65-4c1.08 0 2.15.92 2.15 2.15 0 .69-.31 1.38-.88 1.88L12 11.5 6.38 6.03c-.57-.5-.88-1.19-.88-1.88C5.5 3.27 6.42 2 7.65 2c.59 0 1.14.24 1.55.66l1.82 1.87.98 1.02.98-1.02 1.82-1.87c.41-.42.96-.66 1.55-.66zM2 18V8h8.55L8 10.75l2.08 2 3.92-4 3.92 4L20 10.75 17.45 8H22v10H2z"/></svg>
                                </div>
                                <div class="adm-detail-card__title">Paketzuweisung</div>
                            </div>
                            <div class="adm-detail-card__body">
                                <div class="adm-form-row adm-form-row--2">
                                    <div class="adm-field">
                                        <label for="selected_package">Gewähltes Paket</label>
                                        <select id="selected_package" name="selected_package" onchange="syncOptions()">
                                            <option value="">— Kein Paket —</option>
                                            @foreach($packages as $pkg)
                                                <option value="{{ $pkg->name }}"
                                                    data-has-digital="{{ $pkg->digitalOption() ? 'true' : 'false' }}"
                                                    data-has-onsite="{{ $pkg->onsiteOption() ? 'true' : 'false' }}"
                                                    data-only-option="{{ $pkg->options->count() === 1 ? $pkg->options->first()->type : '' }}"
                                                    {{ old('selected_package', $user->selected_package) === $pkg->name ? 'selected' : '' }}>
                                                    {{ $pkg->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="adm-field">
                                        <label for="selected_option_type">Lieferart</label>
                                        <select id="selected_option_type" name="selected_option_type">
                                            <option value="">— Keine —</option>
                                            <option value="digital" {{ old('selected_option_type', $user->selected_option_type) === 'digital' ? 'selected' : '' }}>Digital</option>
                                            <option value="onsite"  {{ old('selected_option_type', $user->selected_option_type) === 'onsite'  ? 'selected' : '' }}>Vor Ort</option>
                                        </select>
                                    </div>
                                </div>
                                <p style="font-size:12px;color:var(--muted);margin-top:4px;">
                                    Änderungen hier wirken sich auf den Dashboard-Zugang des Benutzers aus.
                                </p>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="adm-detail-card">
                            <div class="adm-detail-card__header">
                                <div class="adm-detail-card__header-icon adm-detail-card__header-icon--orange">
                                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                </div>
                                <div class="adm-detail-card__title">Passwort ändern</div>
                            </div>
                            <div class="adm-detail-card__body">
                                <p style="font-size:12.5px;color:var(--muted);margin-bottom:16px;">
                                    Leer lassen, um das aktuelle Passwort beizubehalten.
                                </p>
                                <div class="adm-form-row adm-form-row--2">
                                    <div class="adm-field {{ $errors->has('password') ? 'adm-field--error' : '' }}">
                                        <label for="password">Neues Passwort</label>
                                        <div class="adm-pw-wrap">
                                            <input type="password" id="password" name="password"
                                                placeholder="Mindestens 8 Zeichen"
                                                autocomplete="new-password"
                                                oninput="checkStrength(this.value)">
                                            <button type="button" class="adm-pw-toggle" onclick="togglePw('password')">
                                                <svg id="eye_password" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                            </button>
                                        </div>
                                        @error('password') <div class="adm-field__error">{{ $message }}</div> @enderror
                                        <div class="adm-pw-strength" id="pwStrength" style="display:none;">
                                            <div class="adm-pw-strength__bar">
                                                <div class="adm-pw-strength__fill" id="pwStrengthFill"></div>
                                            </div>
                                            <div class="adm-pw-strength__label" id="pwStrengthLabel"></div>
                                        </div>
                                    </div>
                                    <div class="adm-field {{ $errors->has('password') ? 'adm-field--error' : '' }}">
                                        <label for="password_confirmation">Passwort bestätigen</label>
                                        <div class="adm-pw-wrap">
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                placeholder="Passwort wiederholen"
                                                autocomplete="new-password"
                                                oninput="checkConfirm()">
                                            <button type="button" class="adm-pw-toggle" onclick="togglePw('password_confirmation')">
                                                <svg id="eye_password_confirmation" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                            </button>
                                        </div>
                                        <div id="pwMatchMsg" style="font-size:12px;margin-top:5px;display:none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="adm-form-footer">
                            <button type="submit" class="adm-btn adm-btn--primary">
                                <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                                Änderungen speichern
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn--secondary">Abbrechen</a>
                        </div>
                    </div>

                    {{-- RIGHT: meta + danger --}}
                    <div>
                        {{-- Profile card --}}
                        <div class="adm-user-hero">
                            <div class="adm-user-hero__avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <div class="adm-user-hero__name">{{ $user->name }}</div>
                            <div class="adm-user-hero__email">{{ $user->email }}</div>
                            <div class="adm-user-hero__id">ID #{{ $user->id }}</div>
                        </div>

                        {{-- Meta info --}}
                        <div class="adm-detail-card">
                            <div class="adm-detail-card__header">
                                <div class="adm-detail-card__header-icon adm-detail-card__header-icon--blue">
                                    <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                                </div>
                                <div class="adm-detail-card__title">Kontoinformationen</div>
                            </div>
                            <div class="adm-detail-card__body">
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Benutzer-ID</span>
                                    <span class="adm-meta-row__value" style="font-family:monospace;">#{{ $user->id }}</span>
                                </div>
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Registriert</span>
                                    <span class="adm-meta-row__value">{{ $user->created_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Zuletzt aktiv</span>
                                    <span class="adm-meta-row__value">{{ $user->updated_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Aktuelles Paket</span>
                                    <span class="adm-meta-row__value" style="font-size:12px;">
                                        {{ $user->selected_package ?? '—' }}
                                    </span>
                                </div>
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Lieferart</span>
                                    <span class="adm-meta-row__value">
                                        @if($user->selected_option_type === 'digital')
                                            <span class="adm-tag adm-tag--digital">Digital</span>
                                        @elseif($user->selected_option_type === 'onsite')
                                            <span class="adm-tag adm-tag--onsite">Vor Ort</span>
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>
                                @if($user->selected_option_type === 'digital')
                                <div class="adm-meta-row">
                                    <span class="adm-meta-row__label">Videozugang</span>
                                    <span class="adm-meta-row__value" style="font-size:12px;">
                                        @php $expired = $user->created_at->diffInDays(now()) > 30; @endphp
                                        @if($expired)
                                            <span style="color:#d94f4f;font-weight:600;">Abgelaufen</span>
                                        @else
                                            <span style="color:#2e9e6b;font-weight:600;">Aktiv</span>
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Danger zone --}}
                        <div class="adm-danger-zone">
                            <div class="adm-danger-zone__title">
                                <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                                Gefahrenzone
                            </div>
                            <div class="adm-danger-zone__text">
                                Diese Aktion ist unwiderruflich. Der Benutzer und alle zugehörigen Daten werden dauerhaft gelöscht.
                            </div>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                data-confirm="true"
                                data-confirm-type="Benutzer"
                                data-confirm-name="{{ $user->name }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="adm-btn--full-danger">
                                    Benutzer löschen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('admin.partials.delete-modal')

    <script>
        // Password visibility toggle
        function togglePw(fieldId) {
            const input = document.getElementById(fieldId);
            const icon  = document.getElementById('eye_' + fieldId);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            icon.innerHTML = isText
                ? '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>'
                : '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
        }

        // Password strength
        function checkStrength(val) {
            const wrap  = document.getElementById('pwStrength');
            const fill  = document.getElementById('pwStrengthFill');
            const label = document.getElementById('pwStrengthLabel');
            if (!val) { wrap.style.display = 'none'; return; }
            wrap.style.display = 'block';
            let score = 0;
            if (val.length >= 8)  score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [
                { pct: '20%', color: '#d94f4f', text: 'Sehr schwach' },
                { pct: '40%', color: '#e07b2e', text: 'Schwach' },
                { pct: '60%', color: '#e0c02e', text: 'Mittel' },
                { pct: '80%', color: '#4a90d9', text: 'Stark' },
                { pct: '100%',color: '#2e9e6b', text: 'Sehr stark' },
            ];
            const l = levels[Math.min(score, 4)];
            fill.style.width      = l.pct;
            fill.style.background = l.color;
            label.textContent     = l.text;
            label.style.color     = l.color;
            checkConfirm();
        }

        // Password match
        function checkConfirm() {
            const pw   = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            const msg  = document.getElementById('pwMatchMsg');
            if (!conf) { msg.style.display = 'none'; return; }
            msg.style.display = 'block';
            if (pw === conf) {
                msg.textContent   = '✓ Passwörter stimmen überein';
                msg.style.color   = '#2e9e6b';
            } else {
                msg.textContent   = '✗ Passwörter stimmen nicht überein';
                msg.style.color   = '#d94f4f';
            }
        }

        // Sync option type when package changes
        function syncOptions() {
            const sel = document.getElementById('selected_package');
            const opt = sel.options[sel.selectedIndex];
            const typeSelect = document.getElementById('selected_option_type');
            if (!opt.value) return;
            const onlyOption = opt.getAttribute('data-only-option');
            if (onlyOption) {
                typeSelect.value = onlyOption;
            }
        }
    </script>
</body>
</html>