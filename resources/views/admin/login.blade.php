<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Bitcoin Verwahren</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:   #6f54a4;
            --secondary: #c086c0;
            --primary-dark: #5a4389;
            --bg:        #f4f2f9;
            --surface:   #ffffff;
            --border:    #e4dff0;
            --text:      #1a1625;
            --muted:     #7a728f;
            --error:     #d94f4f;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: grid;
            place-items: center;
            color: var(--text);
        }

        /* Subtle grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.5;
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .brand {
            text-align: center;
            margin-bottom: 36px;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 4px 16px rgba(111, 84, 164, 0.25);
        }

        .brand-icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }

        .brand h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            font-weight: 400;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .brand p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 400;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 36px;
            box-shadow: 0 2px 24px rgba(111, 84, 164, 0.07), 0 1px 4px rgba(0,0,0,0.04);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .card-subtitle {
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 28px;
        }

        .error-alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 13.5px;
            color: var(--error);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .error-alert svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            fill: var(--error);
        }

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 6px;
        }

        .field input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: #fdfcff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(111, 84, 164, 0.1);
        }

        .field input.is-invalid {
            border-color: var(--error);
            box-shadow: 0 0 0 3px rgba(217, 79, 79, 0.08);
        }

        .field-error {
            font-size: 12px;
            color: var(--error);
            margin-top: 5px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13.5px;
            color: var(--muted);
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            letter-spacing: 0.2px;
            transition: opacity 0.15s, transform 0.1s;
            box-shadow: 0 2px 10px rgba(111, 84, 164, 0.3);
        }

        .btn-primary:hover  { opacity: 0.92; }
        .btn-primary:active { transform: scale(0.99); }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }

        .back-link {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .back-link a:hover { text-decoration: underline; }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="brand">
            <img src="/images/logo.jpg" style="width: 60px; border-radius: 8px;" />
        </div>

        <div class="card">
            <div class="card-title">Anmelden</div>
            <div class="card-subtitle">Bitte melden Sie sich mit Ihren Admin-Zugangsdaten an.</div>

            @if ($errors->any())
                <div class="error-alert">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">E-Mail-Adresse</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Passwort</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Angemeldet bleiben</label>
                </div>

                <button type="submit" class="btn-primary">Anmelden</button>
            </form>

            <div class="divider"></div>

            <div class="back-link">
                <a href="{{ url('/') }}">← Zurück zur Website</a>
            </div>
        </div>

        <div class="footer-note">
            Nur autorisiertes Personal hat Zugriff auf diesen Bereich.
        </div>
    </div>
</body>
</html>