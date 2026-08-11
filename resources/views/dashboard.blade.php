<!DOCTYPE html>
<html lang="de">

<head>
    <title>Sicher Bitcoin Verwahren</title>

    @include('includes.styles')
    <link rel="stylesheet" href="css/dashboard.css">

    
</head>

<body>

    @include('includes.header')

    <div class="ud-page">

        {{-- ─── HERO BAR ─── --}}
        <div class="ud-hero">
            <div class="ud-hero__inner">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                    <div>
                        <div class="ud-greeting">
                            <div class="ud-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="ud-greeting__text">
                                <h1>Willkommen, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
                                <p>Ihr persönliches Dashboard — {{ now()->format('d. F Y') }}</p>
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <span class="ud-pkg-badge">
                                @if(auth()->user()->selected_option_type === 'digital')
                                    ⚡ Digital Package
                                @else
                                    📍 On-Site Service
                                @endif
                                &nbsp;·&nbsp; {{ auth()->user()->selected_package }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="ud-logout-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Abmelden
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── MAIN ─── --}}
        <div class="ud-main">
            <div class="ud-card">

                {{-- ── Tab Nav ── --}}
                <div class="ud-tabs" role="tablist">

                    @if(auth()->user()->selected_option_type === 'onsite')
                        {{-- ON-SITE tabs --}}
                        <button class="ud-tab-btn active" onclick="udSwitchTab(this, 'ud-panel-calendar')" role="tab">
                            <span class="ud-tab-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                                    <line x1="3"  y1="10" x2="21" y2="10"/>
                                </svg>
                            </span>
                            Termin buchen
                        </button>
                    @else
                        {{-- DIGITAL tabs --}}
                        <button class="ud-tab-btn active" onclick="udSwitchTab(this, 'ud-panel-videos')" role="tab">
                            <span class="ud-tab-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="23 7 16 12 23 17 23 7"/>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                                </svg>
                            </span>
                            Kurs-Videos
                        </button>
                    @endif

                    <button class="ud-tab-btn" onclick="udSwitchTab(this, 'ud-panel-profile')" role="tab">
                        <span class="ud-tab-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        Profil bearbeiten
                    </button>
                </div>


                {{-- ══════════════════════════════════════════════
                     PANEL: CALENDAR (on-site users)
                ══════════════════════════════════════════════ --}}
                @if(auth()->user()->selected_option_type === 'onsite')
                <div class="ud-panel active" id="ud-panel-calendar" role="tabpanel">
                    <div class="ud-section-header">
                        <div>
                            <h2>Termin vereinbaren</h2>
                            <p>Wählen Sie Ihren Wunschtermin für den On-Site-Besuch in Thun.</p>
                        </div>
                    </div>

                    <div class="ud-cal-wrap">

                        {{-- Calendar --}}
                        <div>
                            <div class="ud-calendar">
                                <div class="ud-cal-header">
                                    <h3 id="ud-cal-title">April 2026</h3>
                                    <div class="ud-cal-nav">
                                        <button class="ud-cal-nav-btn" onclick="udCalNav(-1)" title="Vorheriger Monat">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="15 18 9 12 15 6"/>
                                            </svg>
                                        </button>
                                        <button class="ud-cal-nav-btn" onclick="udCalNav(1)" title="Nächster Monat">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="9 18 15 12 9 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="ud-cal-grid" id="ud-cal-grid">
                                    {{-- JS-generated --}}
                                </div>
                                <div class="ud-slots" id="ud-slots-wrap" style="display:none;">
                                    <h4>Verfügbare Zeiten</h4>
                                    <div class="ud-slots-grid" id="ud-slots-grid"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Sidebar --}}
                        <div class="ud-booking-sidebar">
                            <div class="ud-booking-summary">
                                <h3>Buchungsübersicht</h3>
                                <div class="ud-booking-field">
                                    <div class="ud-booking-field-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8"  y1="2" x2="8"  y2="6"/>
                                            <line x1="3"  y1="10" x2="21" y2="10"/>
                                        </svg>
                                    </div>
                                    <div class="ud-booking-field-content">
                                        <label>Datum</label>
                                        <span id="ud-sel-date">Noch kein Datum gewählt</span>
                                    </div>
                                </div>
                                <div class="ud-booking-field">
                                    <div class="ud-booking-field-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                    </div>
                                    <div class="ud-booking-field-content">
                                        <label>Uhrzeit</label>
                                        <span id="ud-sel-time">Noch keine Zeit gewählt</span>
                                    </div>
                                </div>
                                <div class="ud-booking-field">
                                    <div class="ud-booking-field-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                    </div>
                                    <div class="ud-booking-field-content">
                                        <label>Ort</label>
                                        <span>Allmendingen-Allee 9, 3608 Thun</span>
                                    </div>
                                </div>
                                <div class="ud-booking-field">
                                    <div class="ud-booking-field-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <div class="ud-booking-field-content">
                                        <label>Paket</label>
                                        <span>{{ auth()->user()->selected_package }}</span>
                                    </div>
                                </div>
                                <button class="ud-book-btn" id="ud-book-confirm-btn" disabled onclick="udConfirmBooking()">
                                    Termin bestätigen
                                </button>
                            </div>

                            <div class="ud-appointments" id="ud-appointments-box">
                                <h3>Gebuchte Termine</h3>
                                <div id="ud-appt-list">
                                    <div class="ud-appt-empty">
                                        <svg style="width:28px;height:28px;opacity:.3;margin-bottom:6px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        <p style="margin:0;">Noch keine Termine gebucht</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                {{-- ══════════════════════════════════════════════
                    PANEL: VIDEOS (digital users)
                ══════════════════════════════════════════════ --}}
                @if(auth()->user()->selected_option_type === 'digital')
                @php
                    $accessEnds = auth()->user()->access_ends_at;
                    $isLocked   = ! $accessEnds || $accessEnds->isPast();
                    $daysLeft   = $accessEnds ? max(0, (int) now()->startOfDay()->diffInDays($accessEnds->copy()->startOfDay(), false)) : 0;
                    if ($accessEnds && $accessEnds->isPast()) { $daysLeft = 0; }
                @endphp
                <div class="ud-panel active" id="ud-panel-videos" role="tabpanel" style="position:relative;">

                    @if($isLocked)
                    <div class="ud-locked-overlay visible">
                        <div class="ud-locked-box">
                            <div class="ud-locked-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </div>
                            <h3>Zugang abgelaufen</h3>
                            <p>Ihr 60-tägiger Zugang ist abgelaufen. Erneuern Sie Ihr Paket, um wieder Zugriff auf alle Kurse zu erhalten.</p>
                            <a href="/pricing" class="ud-renew-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;">
                                    <polyline points="23 4 23 10 17 10"/>
                                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                                </svg>
                                Paket erneuern
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="ud-section-header">
                        <div>
                            <h2>Kurs-Videos</h2>
                            <p>Ihre Bitcoin-Sicherheitskurse — lernen Sie in Ihrem eigenen Tempo.</p>
                        </div>
                    </div>

                    @if(!$isLocked && $accessEnds)
                    <div class="ud-sub-banner">
                        <div class="ud-sub-banner-left">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Ihr Zugang läuft ab in <strong>{{ $daysLeft }} {{ $daysLeft === 1 ? 'Tag' : 'Tagen' }}</strong> — Paket am {{ $accessEnds->format('d.m.Y') }}</span>
                        </div>
                        <span class="ud-days-pill">{{ $daysLeft }}d verbleibend</span>
                    </div>
                    @endif

                    @if($videos->isEmpty())
                        <div style="text-align:center;padding:48px 24px;color:#aaa;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                style="width:48px;height:48px;opacity:.3;margin-bottom:12px;display:block;margin-inline:auto;">
                                <polygon points="23 7 16 12 23 17 23 7"/>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                            </svg>
                            <p>Für Ihr Paket sind noch keine Videos verfügbar.</p>
                        </div>
                    @else
                    <div class="ud-video-grid">
                        @foreach($videos as $index => $video)
                        <div class="ud-video-card"
                            onclick="udOpenVideo(
                                {{ json_encode($video->title) }},
                                {{ json_encode($video->description ?? '') }},
                                {{ json_encode($video->video_url) }}
                            )">
                            <div class="ud-video-thumb"
                                style="background: linear-gradient(135deg,
                                    {{ ['#2d1a55','#4a1a7a','#1a3a6b','#2a1a4a','#1a4a3a'][$index % 5] }} 0%,
                                    {{ ['#6f54a4','#c086c0','#6f54a4','#8a54a4','#54a47a'][$index % 5] }} 100%);">
                                <div class="ud-video-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/>
                                    </svg>
                                </div>
                                <div class="ud-video-play-overlay">
                                    <div class="ud-video-play-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="5 3 19 12 5 21 5 3"/>
                                        </svg>
                                    </div>
                                </div>
                                @if($video->duration)
                                    <span class="ud-video-duration">{{ $video->duration }}</span>
                                @endif
                            </div>
                            <div class="ud-video-info">
                                <h4>{{ $video->title }}</h4>
                                @if($video->description)
                                    <p>{{ $video->description }}</p>
                                @endif
                                <div class="ud-video-meta">
                                    @if($video->tag)
                                        <span class="ud-video-tag">{{ $video->tag }}</span>
                                    @endif
                                    <span class="ud-video-lesson">Lektion {{ $index + 1 }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif



                {{-- ══════════════════════════════════════════════
                     PANEL: PROFILE
                ══════════════════════════════════════════════ --}}
                <div class="ud-panel" id="ud-panel-profile" role="tabpanel">
                    <div class="ud-section-header">
                        <div>
                            <h2>Profil bearbeiten</h2>
                            <p>Ihre persönlichen Angaben aktualisieren.</p>
                        </div>
                    </div>

                    <div class="ud-alert" id="ud-profile-alert"></div>

                    <div class="ud-profile-grid">
                        <div class="ud-profile-sidebar">
                            <div class="ud-profile-card">
                                <div class="ud-profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <h3>{{ auth()->user()->name }}</h3>
                                <p>{{ auth()->user()->email }}</p>
                            </div>

                            <div class="ud-profile-stat">
                                <div class="ud-profile-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                                        <line x1="3"  y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="ud-profile-stat-label">Mitglied seit</span>
                                    <span class="ud-profile-stat-value">{{ auth()->user()->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>

                            <div class="ud-profile-stat">
                                <div class="ud-profile-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 12 20 22 4 22 4 12"/>
                                        <rect x="2" y="7" width="20" height="5"/>
                                        <line x1="12" y1="22" x2="12" y2="7"/>
                                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="ud-profile-stat-label">Paket</span>
                                    <span class="ud-profile-stat-value" style="font-size:.78rem;">{{ auth()->user()->selected_package }}</span>
                                </div>
                            </div>

                            <div class="ud-profile-stat">
                                <div class="ud-profile-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="ud-profile-stat-label">Service-Typ</span>
                                    <span class="ud-profile-stat-value">
                                        {{ auth()->user()->selected_option_type === 'digital' ? '⚡ Digital' : '📍 On-Site' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="ud-form-section">
                                <h3>Persönliche Angaben</h3>
                                <form id="ud-profile-form" onsubmit="udSaveProfile(event)">
                                    @csrf
                                    <div class="ud-form-row">
                                        <div class="ud-form-group">
                                            <label class="ud-form-label" for="ud_name">Vollständiger Name *</label>
                                            <input class="ud-form-input" id="ud_name" name="name" type="text"
                                                   value="{{ auth()->user()->name }}" required>
                                        </div>
                                        <div class="ud-form-group">
                                            <label class="ud-form-label" for="ud_phone">Telefonnummer *</label>
                                            <input class="ud-form-input" id="ud_phone" name="phone" type="tel"
                                                   value="{{ auth()->user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="ud-form-group">
                                        <label class="ud-form-label" for="ud_email">E-Mail-Adresse</label>
                                        <input class="ud-form-input" id="ud_email" type="email"
                                               value="{{ auth()->user()->email }}" readonly>
                                    </div>

                                    <div class="ud-form-section" style="margin-top:24px;padding:24px;">
                                        <h3 style="margin-bottom:16px;">Passwort ändern</h3>
                                        <div class="ud-form-row">
                                            <div class="ud-form-group">
                                                <label class="ud-form-label" for="ud_password">Neues Passwort</label>
                                                <input class="ud-form-input" id="ud_password" name="password"
                                                       type="password" placeholder="Leer lassen = unverändet">
                                            </div>
                                            <div class="ud-form-group">
                                                <label class="ud-form-label" for="ud_password_confirm">Passwort bestätigen</label>
                                                <input class="ud-form-input" id="ud_password_confirm"
                                                       name="password_confirmation" type="password" placeholder="Wiederholen">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="ud-save-btn">Änderungen speichern</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /ud-card --}}
        </div>{{-- /ud-main --}}
    </div>{{-- /ud-page --}}


    {{-- ─── VIDEO MODAL ─── --}}
    <div class="ud-video-modal-overlay" id="udVideoModalOverlay">
        <div class="ud-video-modal">
            <button class="ud-video-modal-close" onclick="udCloseVideo()">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M1 1l12 12M13 1L1 13"/>
                </svg>
            </button>
            <div class="ud-video-modal-header">
                <h3 id="udVideoTitle">—</h3>
                <p id="udVideoDesc">—</p>
            </div>
            <div class="ud-video-modal-player" id="udVideoPlayer"></div>
        </div>
    </div>

    {{-- ─── TOAST ─── --}}
    <div class="ud-toast" id="udToast">
        <div class="ud-toast-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="ud-toast-text">
            <strong id="udToastTitle">Termin gebucht!</strong>
            <span id="udToastMsg">Ihr Termin wurde erfolgreich reserviert.</span>
        </div>
    </div>


    @include('includes.footer')
    @include('includes.scripts')

    <script>
    (function () {
        'use strict';

        /* ── Tab switcher ── */
        window.udSwitchTab = function (btn, panelId) {
            document.querySelectorAll('.ud-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.ud-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            const panel = document.getElementById(panelId);
            if (panel) panel.classList.add('active');
        };

        /* ════════════════════════════════
           CALENDAR LOGIC (on-site only)
        ════════════════════════════════ */
        const isOnsite = {{ auth()->user()->selected_option_type === 'onsite' ? 'true' : 'false' }};

        if (isOnsite) {
            /* Simulated already-booked slots */
            const bookedSlots = {
                '2026-04-10': ['09:00', '11:00'],
                '2026-04-15': ['14:00', '15:00'],
                '2026-04-22': ['10:00'],
            };

            /* User bookings stored locally (simulated, replace with real API) */
            let userBookings = JSON.parse(localStorage.getItem('ud_bookings') || '[]');

            let calYear  = 2026;
            let calMonth = 3; // April (0-indexed)
            let selDate  = null;
            let selTime  = null;

            const MONTHS_DE = ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];
            const DAYS_DE   = ['Mo','Di','Mi','Do','Fr','Sa','So'];
            const TIMES     = ['09:00','10:00','11:00','13:00','14:00','15:00','16:00'];

            function renderCalendar() {
                const titleEl = document.getElementById('ud-cal-title');
                const gridEl  = document.getElementById('ud-cal-grid');
                if (!titleEl || !gridEl) return;

                titleEl.textContent = MONTHS_DE[calMonth] + ' ' + calYear;

                const today    = new Date();
                const firstDay = new Date(calYear, calMonth, 1);
                const lastDay  = new Date(calYear, calMonth + 1, 0);

                /* Monday-first offset */
                let startDow = firstDay.getDay();
                startDow = startDow === 0 ? 6 : startDow - 1;

                let html = DAYS_DE.map(d => `<div class="ud-cal-weekday">${d}</div>`).join('');

                for (let i = 0; i < startDow; i++) {
                    html += `<div class="ud-cal-day ud-cal-day--empty"></div>`;
                }

                for (let d = 1; d <= lastDay.getDate(); d++) {
                    const date    = new Date(calYear, calMonth, d);
                    const dateStr = `${calYear}-${String(calMonth+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                    const isToday = date.toDateString() === today.toDateString();
                    const isPast  = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
                    const isSel   = dateStr === selDate;
                    const hasSlot = !isPast && date.getDay() !== 0 && date.getDay() !== 6;

                    let cls = 'ud-cal-day';
                    if (isToday) cls += ' ud-cal-day--today';
                    if (isPast)  cls += ' ud-cal-day--past';
                    if (isSel)   cls += ' ud-cal-day--selected';
                    if (hasSlot && !isPast) cls += ' ud-cal-day--has-slot';

                    const click = (!isPast && hasSlot) ? `onclick="udSelectDate('${dateStr}', ${d})"` : '';
                    html += `<div class="${cls}" ${click}>${d}</div>`;
                }

                gridEl.innerHTML = html;
            }

            window.udCalNav = function (dir) {
                calMonth += dir;
                if (calMonth > 11) { calMonth = 0;  calYear++; }
                if (calMonth < 0)  { calMonth = 11; calYear--; }
                selDate = null;
                selTime = null;
                updateSummary();
                renderCalendar();
                document.getElementById('ud-slots-wrap').style.display = 'none';
            };

            window.udSelectDate = function (dateStr, dayNum) {
                selDate = dateStr;
                selTime = null;
                updateSummary();
                renderCalendar();

                /* Render time slots */
                const slotsWrap = document.getElementById('ud-slots-wrap');
                const slotsGrid = document.getElementById('ud-slots-grid');
                const booked    = bookedSlots[dateStr] || [];

                slotsGrid.innerHTML = TIMES.map(t => {
                    const isBooked = booked.includes(t);
                    return `<button class="ud-slot-btn${isBooked ? ' booked' : ''}"
                                    ${isBooked ? 'disabled' : `onclick="udSelectTime('${t}')"`}>${t}</button>`;
                }).join('');
                slotsWrap.style.display = 'block';
            };

            window.udSelectTime = function (time) {
                selTime = time;
                document.querySelectorAll('.ud-slot-btn:not(.booked)').forEach(b => {
                    b.classList.toggle('active', b.textContent.trim() === time);
                });
                updateSummary();
            };

            function updateSummary() {
                const dateEl = document.getElementById('ud-sel-date');
                const timeEl = document.getElementById('ud-sel-time');
                const btn    = document.getElementById('ud-book-confirm-btn');

                if (dateEl) dateEl.textContent = selDate
                    ? new Date(selDate + 'T12:00:00').toLocaleDateString('de-CH', { weekday:'long', day:'numeric', month:'long', year:'numeric' })
                    : 'Noch kein Datum gewählt';

                if (timeEl) timeEl.textContent = selTime ? selTime + ' Uhr' : 'Noch keine Zeit gewählt';
                if (btn)    btn.disabled = !(selDate && selTime);
            }

            window.udConfirmBooking = function () {
                if (!selDate || !selTime) return;

                const booking = { date: selDate, time: selTime, id: Date.now() };
                userBookings.push(booking);
                localStorage.setItem('ud_bookings', JSON.stringify(userBookings));

                /* Add to booked list so slot shows as taken */
                if (!bookedSlots[selDate]) bookedSlots[selDate] = [];
                bookedSlots[selDate].push(selTime);

                renderAppointments();
                udShowToast('Termin gebucht!', `${new Date(selDate+'T12:00:00').toLocaleDateString('de-CH',{day:'numeric',month:'long'})} um ${selTime} Uhr bestätigt.`);

                selDate = null; selTime = null;
                updateSummary();
                renderCalendar();
                document.getElementById('ud-slots-wrap').style.display = 'none';
            };

            function renderAppointments() {
                const el = document.getElementById('ud-appt-list');
                if (!el) return;
                if (!userBookings.length) {
                    el.innerHTML = `<div class="ud-appt-empty"><p style="margin:0;">Noch keine Termine gebucht</p></div>`;
                    return;
                }
                el.innerHTML = userBookings.slice(-3).reverse().map(b => {
                    const d   = new Date(b.date + 'T12:00:00');
                    const day = d.toLocaleDateString('de-CH', { day:'2-digit' });
                    const mon = d.toLocaleDateString('de-CH', { month:'short' }).toUpperCase();
                    return `
                    <div class="ud-appt-item">
                        <div class="ud-appt-date-block">
                            <span class="ud-appt-day">${day}</span>
                            <span class="ud-appt-mon">${mon}</span>
                        </div>
                        <div class="ud-appt-info">
                            <strong>On-Site Beratung</strong>
                            <span>${b.time} Uhr · Thun</span>
                        </div>
                        <span class="ud-appt-status">Bestätigt</span>
                    </div>`;
                }).join('');
            }

            /* Init */
            renderCalendar();
            renderAppointments();
            updateSummary();
        }

        /* ════════════════════════════════
           VIDEO MODAL
        ════════════════════════════════ */
        window.udOpenVideo = function (title, desc, videoUrl) {
            document.getElementById('udVideoTitle').textContent = title;
            document.getElementById('udVideoDesc').textContent  = desc;

            // Use native <video> for S3 URLs, iframe for YouTube
            const isYoutube = videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be');
            document.getElementById('udVideoPlayer').innerHTML = isYoutube
                ? `<iframe src="${videoUrl}?autoplay=1&rel=0" allowfullscreen allow="autoplay"></iframe>`
                : `<video src="${videoUrl}" controls autoplay style="width:100%;border-radius:8px;"></video>`;

            document.getElementById('udVideoModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        };


        window.udCloseVideo = function () {
            document.getElementById('udVideoModalOverlay').classList.remove('active');
            document.getElementById('udVideoPlayer').innerHTML = '';
            document.body.style.overflow = '';
        };

        document.getElementById('udVideoModalOverlay')?.addEventListener('click', function (e) {
            if (e.target === this) udCloseVideo();
        });

        /* ════════════════════════════════
           PROFILE FORM
        ════════════════════════════════ */
        window.udSaveProfile = async function (e) {
            e.preventDefault();
            const alertEl = document.getElementById('ud-profile-alert');
            alertEl.className = 'ud-alert';
            alertEl.textContent = '';

            const body = {
                name:                  document.getElementById('ud_name')?.value,
                phone:                 document.getElementById('ud_phone')?.value,
                password:              document.getElementById('ud_password')?.value || '',
                password_confirmation: document.getElementById('ud_password_confirm')?.value || '',
                _token:                '{{ csrf_token() }}',
                _method:               'PATCH',
            };

            try {
                const res  = await fetch('{{ route("user.profile.update") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(body),
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    alertEl.className = 'ud-alert success visible';
                    alertEl.textContent = '✓ Profil erfolgreich aktualisiert.';
                    document.getElementById('ud_password').value = '';
                    document.getElementById('ud_password_confirm').value = '';
                } else {
                    const errs = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Fehler.');
                    alertEl.className = 'ud-alert error visible';
                    alertEl.textContent = errs;
                }
            } catch {
                alertEl.className = 'ud-alert error visible';
                alertEl.textContent = 'Verbindungsfehler. Bitte versuchen Sie es erneut.';
            }
        };

        /* ════════════════════════════════
           TOAST
        ════════════════════════════════ */
        window.udShowToast = function (title, msg) {
            const t = document.getElementById('udToast');
            document.getElementById('udToastTitle').textContent = title;
            document.getElementById('udToastMsg').textContent   = msg;
            t.classList.add('visible');
            setTimeout(() => t.classList.remove('visible'), 4000);
        };

        /* ESC key */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                udCloseVideo();
            }
        });

    })();



    (function () {
        document.querySelectorAll('.ud-video-card').forEach(card => {
            const thumb      = card.querySelector('.ud-video-thumb');
            const placeholder = card.querySelector('.ud-video-thumb-placeholder');
            if (!thumb || !placeholder) return;

            // Get the video URL from the onclick attribute
            const onclick  = card.getAttribute('onclick') || '';
            const urlMatch = onclick.match(/udOpenVideo\([^,]+,[^,]+,\s*"([^"]+)"/);
            if (!urlMatch) return;

            const videoUrl = urlMatch[1];
            const isYoutube = videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be');

            if (isYoutube) {
                // Extract YouTube video ID and use YouTube's thumbnail API
                const ytMatch = videoUrl.match(/embed\/([^?]+)/);
                if (!ytMatch) return;
                const ytId = ytMatch[1];
                thumb.style.backgroundImage   = `url(https://img.youtube.com/vi/${ytId}/mqdefault.jpg)`;
                thumb.style.backgroundSize    = 'cover';
                thumb.style.backgroundPosition = 'center';
                placeholder.style.display     = 'none';
            } else {
                // S3 video — seek to 1 second and capture frame
                const video       = document.createElement('video');
                video.src         = videoUrl;
                video.crossOrigin = 'anonymous';
                video.muted       = true;
                video.preload     = 'metadata';
                video.style.display = 'none';
                document.body.appendChild(video);

                video.addEventListener('loadedmetadata', function () {
                    video.currentTime = 1; // seek to 1 second
                });

                video.addEventListener('seeked', function () {
                    try {
                        const canvas  = document.createElement('canvas');
                        canvas.width  = video.videoWidth  || 480;
                        canvas.height = video.videoHeight || 270;
                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                        const dataUrl = canvas.toDataURL('image/jpeg');
                        thumb.style.backgroundImage     = `url(${dataUrl})`;
                        thumb.style.backgroundSize      = 'cover';
                        thumb.style.backgroundPosition  = 'center';
                        placeholder.style.display       = 'none';
                    } catch (e) {
                        // CORS blocked — gradient fallback
                    }
                    video.remove();
                });
            }

        });
    })();

    </script>

</body>
</html>