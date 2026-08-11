<!DOCTYPE html>
<html lang="de">
<head>
    <title>Passwort vergessen – Sicher Bitcoin Verwahren</title>
    @include('includes.styles')
    <style>
        :root { --lp-primary:#6f54a4; --lp-radius:14px; }
        .lp-page{min-height:100vh;background:linear-gradient(135deg,#f8f6fc 0%,#ede8f7 100%);display:flex;align-items:center;justify-content:center;padding:40px 16px;font-family:"Plus Jakarta Sans",sans-serif;}
        .lp-card{background:#fff;border-radius:22px;box-shadow:0 20px 70px rgba(111,84,164,.16);border:1.5px solid rgba(111,84,164,.15);width:100%;max-width:460px;overflow:hidden;}
        .lp-header{background:linear-gradient(135deg,#6f54a4 0%,#9b78c8 60%,#c086c0 100%);padding:36px 36px 28px;text-align:center;}
        .lp-header h1{font-size:1.45rem;font-weight:900;color:#fff;margin:0 0 6px;}
        .lp-header p{font-size:.84rem;color:rgba(255,255,255,.72);margin:0;}
        .lp-body{padding:32px 36px 36px;}
        .lp-label{display:block;font-size:.75rem;font-weight:600;color:#555;margin-bottom:6px;}
        .lp-input{width:100%;padding:12px 14px;border:1.5px solid #e2e2e2;border-radius:var(--lp-radius);font-size:.875rem;color:#333;background:#fafafa;outline:none;box-sizing:border-box;font-family:inherit;}
        .lp-input:focus{border-color:var(--lp-primary);background:#fff;box-shadow:0 0 0 3px rgba(111,84,164,.10);}
        .lp-submit{display:block;width:100%;padding:13px 20px;border-radius:var(--lp-radius);background:var(--lp-primary);color:#fff;font-size:.9rem;font-weight:700;border:none;cursor:pointer;margin-top:8px;}
        .lp-footer{text-align:center;margin-top:20px;font-size:.82rem;color:#999;}
        .lp-footer a{color:var(--lp-primary);font-weight:600;text-decoration:none;}
        .lp-alert{border-radius:var(--lp-radius);padding:11px 14px;font-size:.82rem;font-weight:600;margin-bottom:18px;}
        .lp-alert--error{background:rgba(229,57,53,.07);border:1.5px solid rgba(229,57,53,.2);color:#e53935;}
        .lp-alert--ok{background:rgba(34,160,107,.07);border:1.5px solid rgba(34,160,107,.2);color:#22a06b;}
        .lp-error{font-size:.72rem;color:#e53935;margin-top:5px;display:block;}
        .lp-logo img{max-width:72px;border-radius:12px;margin-bottom:16px;}
    </style>
</head>
<body>
@include('includes.header')
<div class="lp-page">
    <div class="lp-card">
        <div class="lp-header">
            <div class="lp-logo"><img src="/images/logo.jpg" alt="Logo"></div>
            <h1>Passwort vergessen</h1>
            <p>Wir senden Ihnen einen Link zum Zurücksetzen.</p>
        </div>
        <div class="lp-body">
            @if ($errors->any())
                <div class="lp-alert lp-alert--error">{{ $errors->first() }}</div>
            @endif
            @if (session('status'))
                <div class="lp-alert lp-alert--ok">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div style="margin-bottom:16px;">
                    <label class="lp-label" for="email">E-Mail-Adresse *</label>
                    <input class="lp-input" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')<span class="lp-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="lp-submit">Passwort zurücksetzen</button>
            </form>
            <div class="lp-footer"><a href="{{ route('login') }}">Zurück zur Anmeldung</a></div>
        </div>
    </div>
</div>
@include('includes.footer')
@include('includes.scripts')
</body>
</html>
