<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
<div class="adm-layout">
    @include('admin.partials.sidebar')
    <div class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Passwort ändern'])

        <div class="adm-content">
            @if(session('success'))
                <div class="adm-alert adm-alert--success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="adm-alert" style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="adm-page-header">
                <div>
                    <h1>Passwort ändern</h1>
                    <p>Angemeldet als {{ $user->name }} ({{ $user->email }})</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.password') }}"
                  style="max-width:480px;background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:24px;">
                @csrf
                @method('PUT')

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Aktuelles Passwort</label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           style="width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;">
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Neues Passwort</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           style="width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Neues Passwort bestätigen</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           style="width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:8px;">
                </div>

                <button type="submit" class="adm-btn adm-btn--primary">Passwort speichern</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
