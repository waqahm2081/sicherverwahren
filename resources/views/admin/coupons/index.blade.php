<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rabattcodes — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
</head>
<body>
<div class="adm-layout">
    @include('admin.partials.sidebar')
    <div class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Rabattcodes'])

        <div class="adm-content">
            @if(session('success'))
                <div style="background:#edfaf4;border:1px solid #b7ebd0;color:#1d7a53;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13.5px;font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="adm-detail-card" style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border-light);background:var(--surface-2);font-weight:600;font-size:14px;">
                    SECURE5 · PRO7 · SBV_KULANZ
                </div>
                <div style="padding:20px;display:flex;flex-direction:column;gap:18px;">
                    @foreach($coupons as $coupon)
                        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}"
                              style="border:1px solid var(--border);border-radius:10px;padding:16px;display:grid;grid-template-columns:1fr 120px 100px auto;gap:12px;align-items:end;">
                            @csrf
                            @method('PUT')
                            <div>
                                <div style="font-size:15px;font-weight:700;color:var(--text);">{{ $coupon->code }}</div>
                                <div style="font-size:12px;color:var(--muted);margin-top:4px;">
                                    {{ $coupon->allowed_package ? 'Nur: '.$coupon->allowed_package : 'Alle Pakete' }}
                                    @if($coupon->requires_grant) · nur mit E-Mail-Grant @endif
                                </div>
                                <input type="text" name="notes" value="{{ $coupon->notes }}" placeholder="Notiz"
                                       style="margin-top:8px;width:100%;padding:8px 10px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;">
                            </div>
                            <div>
                                <label style="font-size:11px;color:var(--muted);display:block;margin-bottom:4px;">Rabatt %</label>
                                <input type="number" name="discount_percent" min="1" max="100" value="{{ $coupon->discount_percent }}" required
                                       style="width:100%;padding:8px 10px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;">
                            </div>
                            <div>
                                <label style="font-size:11px;color:var(--muted);display:block;margin-bottom:4px;">Aktiv</label>
                                <label style="display:flex;align-items:center;gap:8px;font-size:13px;">
                                    <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                                    Ja
                                </label>
                            </div>
                            <button type="submit" class="adm-btn adm-btn--secondary">Speichern</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
