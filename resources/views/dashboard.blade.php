<!DOCTYPE html>
<html lang="de">

<head>
    <title>Sicher Bitcoin Verwahren</title>

    @include('includes.styles')

    <style>
        /* ═══════════════════════════════════════════════════════════════
           USER DASHBOARD — scoped under .ud- prefix to avoid conflicts
        ═══════════════════════════════════════════════════════════════ */
        :root {
            --ud-primary:        #6f54a4;
            --ud-primary-light:  rgba(111,84,164,.10);
            --ud-primary-border: rgba(111,84,164,.22);
            --ud-secondary:      #c086c0;
            --ud-gradient:       linear-gradient(135deg, #6f54a4 0%, #9b78c8 60%, #c086c0 100%);
            --ud-success:        #22a06b;
            --ud-success-bg:     rgba(34,160,107,.09);
            --ud-danger:         #e53935;
            --ud-surface:        #ffffff;
            --ud-surface-2:      #f8f6fc;
            --ud-border:         #ede8f7;
            --ud-text:           #2d2540;
            --ud-text-muted:     #8b7fa8;
            --ud-radius:         16px;
            --ud-radius-sm:      10px;
            --ud-shadow:         0 4px 24px rgba(111,84,164,.10);
            --ud-shadow-lg:      0 12px 48px rgba(111,84,164,.16);
            --ud-transition:     0.22s cubic-bezier(.4,0,.2,1);
        }

        /* ─── LAYOUT ─── */
        .ud-page {
            min-height: 100vh;
            background: var(--ud-surface-2);
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-hero {
            background: var(--ud-gradient);
            padding: 48px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .ud-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -80px;
            width: 340px; height: 340px;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
        }

        .ud-hero::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -60px;
            width: 260px; height: 260px;
            background: rgba(255,255,255,.04);
            border-radius: 50%;
        }

        .ud-hero__inner {
            position: relative;
            z-index: 1;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .ud-greeting {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .ud-avatar {
            width: 58px; height: 58px;
            border-radius: 50%;
            background: rgba(255,255,255,.22);
            border: 2.5px solid rgba(255,255,255,.45);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .ud-greeting__text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 3px;
            line-height: 1.2;
        }

        .ud-greeting__text p {
            font-size: .82rem;
            color: rgba(255,255,255,.72);
            margin: 0;
        }

        .ud-pkg-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.30);
            color: #fff;
            font-size: .70rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 5px 13px;
            border-radius: 50px;
            margin-top: 12px;
        }

        /* ─── MAIN CONTENT CARD ─── */
        .ud-main {
            max-width: 1300px;
            margin: -44px auto 60px;
            padding: 0 24px;
            position: relative;
            z-index: 2;
        }

        .ud-card {
            background: var(--ud-surface);
            border-radius: var(--ud-radius);
            box-shadow: var(--ud-shadow-lg);
            overflow: hidden;
            border: 1px solid var(--ud-border);
        }

        /* ─── TAB NAV ─── */
        .ud-tabs {
            display: flex;
            border-bottom: 1.5px solid var(--ud-border);
            padding: 0 8px;
            background: var(--ud-surface);
            overflow-x: auto;
            scrollbar-width: none;
        }

        .ud-tabs::-webkit-scrollbar { display: none; }

        .ud-tab-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 18px 22px;
            border: none;
            background: transparent;
            font-size: .84rem;
            font-weight: 700;
            color: var(--ud-text-muted);
            cursor: pointer;
            position: relative;
            white-space: nowrap;
            transition: color var(--ud-transition);
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-tab-btn::after {
            content: '';
            position: absolute;
            bottom: -1.5px; left: 0; right: 0;
            height: 2.5px;
            background: var(--ud-primary);
            border-radius: 3px 3px 0 0;
            transform: scaleX(0);
            transition: transform var(--ud-transition);
        }

        .ud-tab-btn.active {
            color: var(--ud-primary);
        }

        .ud-tab-btn.active::after {
            transform: scaleX(1);
        }

        .ud-tab-btn .ud-tab-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--ud-primary-light);
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem;
            transition: background var(--ud-transition);
        }

        .ud-tab-btn.active .ud-tab-icon {
            background: var(--ud-primary);
        }

        .ud-tab-btn.active .ud-tab-icon svg {
            color: #fff;
        }

        .ud-tab-icon svg {
            width: 15px; height: 15px;
            color: var(--ud-primary);
        }

        /* ─── TAB PANELS ─── */
        .ud-panel { display: none; padding: 32px; }
        .ud-panel.active { display: block; }

        /* ─── SECTION HEADER ─── */
        .ud-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 28px;
        }

        .ud-section-header h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--ud-text);
            margin: 0;
        }

        .ud-section-header p {
            font-size: .82rem;
            color: var(--ud-text-muted);
            margin: 4px 0 0;
        }

        /* ════════════════════════════════════════════
           CALENDAR TAB (ON-SITE)
        ════════════════════════════════════════════ */

        .ud-cal-wrap {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
        }

        @media (max-width: 900px) {
            .ud-cal-wrap { grid-template-columns: 1fr; }
        }

        /* Calendar */
        .ud-calendar {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            padding: 24px;
        }

        .ud-cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .ud-cal-header h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ud-text);
            margin: 0;
        }

        .ud-cal-nav {
            display: flex; gap: 6px;
        }

        .ud-cal-nav-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--ud-primary-border);
            background: transparent;
            color: var(--ud-primary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background var(--ud-transition), color var(--ud-transition);
        }

        .ud-cal-nav-btn:hover {
            background: var(--ud-primary);
            color: #fff;
        }

        .ud-cal-nav-btn svg { width: 14px; height: 14px; }

        .ud-cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .ud-cal-weekday {
            text-align: center;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--ud-text-muted);
            padding: 8px 0;
        }

        .ud-cal-day {
            aspect-ratio: 1;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .82rem;
            font-weight: 600;
            color: var(--ud-text);
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all var(--ud-transition);
            position: relative;
        }

        .ud-cal-day:hover:not(.ud-cal-day--empty):not(.ud-cal-day--past) {
            background: var(--ud-primary-light);
            border-color: var(--ud-primary-border);
            color: var(--ud-primary);
        }

        .ud-cal-day--today {
            background: var(--ud-primary-light);
            color: var(--ud-primary);
            font-weight: 800;
        }

        .ud-cal-day--selected {
            background: var(--ud-primary) !important;
            color: #fff !important;
            border-color: var(--ud-primary) !important;
        }

        .ud-cal-day--has-slot::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--ud-secondary);
        }

        .ud-cal-day--past {
            opacity: .35;
            cursor: not-allowed;
        }

        .ud-cal-day--empty {
            cursor: default;
        }

        /* Time slots */
        .ud-slots {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1.5px solid var(--ud-border);
        }

        .ud-slots h4 {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--ud-text-muted);
            margin: 0 0 12px;
        }

        .ud-slots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .ud-slot-btn {
            padding: 9px 6px;
            border-radius: var(--ud-radius-sm);
            border: 1.5px solid var(--ud-primary-border);
            background: transparent;
            color: var(--ud-primary);
            font-size: .75rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: all var(--ud-transition);
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-slot-btn:hover, .ud-slot-btn.active {
            background: var(--ud-primary);
            color: #fff;
            border-color: var(--ud-primary);
        }

        .ud-slot-btn.booked {
            opacity: .4;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* Booking sidebar */
        .ud-booking-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .ud-booking-summary {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            padding: 22px;
        }

        .ud-booking-summary h3 {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--ud-text-muted);
            margin: 0 0 16px;
        }

        .ud-booking-field {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
        }

        .ud-booking-field:last-child { margin-bottom: 0; }

        .ud-booking-field-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--ud-primary-light);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .ud-booking-field-icon svg {
            width: 14px; height: 14px;
            color: var(--ud-primary);
        }

        .ud-booking-field-content label {
            display: block;
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ud-text-muted);
            margin-bottom: 1px;
        }

        .ud-booking-field-content span {
            font-size: .88rem;
            font-weight: 700;
            color: var(--ud-text);
        }

        .ud-book-btn {
            display: block;
            width: 100%;
            padding: 14px 20px;
            border-radius: var(--ud-radius-sm);
            background: var(--ud-primary);
            color: #fff;
            font-size: .9rem;
            font-weight: 700;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background var(--ud-transition), transform var(--ud-transition);
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-book-btn:hover:not(:disabled) {
            background: #5c4490;
            transform: translateY(-1px);
        }

        .ud-book-btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        /* Upcoming appointments */
        .ud-appointments {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            padding: 22px;
        }

        .ud-appointments h3 {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--ud-text-muted);
            margin: 0 0 16px;
        }

        .ud-appt-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: var(--ud-radius-sm);
            background: var(--ud-surface);
            border: 1.5px solid var(--ud-border);
            margin-bottom: 10px;
        }

        .ud-appt-item:last-child { margin-bottom: 0; }

        .ud-appt-date-block {
            text-align: center;
            min-width: 44px;
            background: var(--ud-primary-light);
            border-radius: 8px;
            padding: 6px 8px;
        }

        .ud-appt-date-block .ud-appt-day {
            display: block;
            font-size: 1.2rem;
            font-weight: 900;
            color: var(--ud-primary);
            line-height: 1;
        }

        .ud-appt-date-block .ud-appt-mon {
            display: block;
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ud-secondary);
            letter-spacing: .05em;
        }

        .ud-appt-info { flex: 1; }

        .ud-appt-info strong {
            display: block;
            font-size: .84rem;
            font-weight: 700;
            color: var(--ud-text);
        }

        .ud-appt-info span {
            font-size: .74rem;
            color: var(--ud-text-muted);
        }

        .ud-appt-status {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 4px 9px;
            border-radius: 50px;
            background: var(--ud-success-bg);
            color: var(--ud-success);
        }

        .ud-appt-empty {
            text-align: center;
            padding: 20px;
            color: var(--ud-text-muted);
            font-size: .84rem;
        }

        /* ════════════════════════════════════════════
           VIDEO TAB (DIGITAL)
        ════════════════════════════════════════════ */

        .ud-locked-overlay {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(245,242,252,.92);
            backdrop-filter: blur(6px);
            z-index: 10;
            align-items: center;
            justify-content: center;
            border-radius: var(--ud-radius);
        }

        .ud-locked-overlay.visible { display: flex; }

        .ud-locked-box {
            text-align: center;
            padding: 40px;
            max-width: 380px;
        }

        .ud-locked-icon {
            width: 64px; height: 64px;
            background: rgba(111,84,164,.12);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }

        .ud-locked-icon svg { width: 28px; height: 28px; color: var(--ud-primary); }

        .ud-locked-box h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--ud-text);
            margin-bottom: 8px;
        }

        .ud-locked-box p {
            font-size: .85rem;
            color: var(--ud-text-muted);
            margin-bottom: 20px;
        }

        .ud-renew-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 22px;
            border-radius: var(--ud-radius-sm);
            background: var(--ud-primary);
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background var(--ud-transition);
        }

        .ud-renew-btn:hover { background: #5c4490; color: #fff; }

        /* Subscription banner */
        .ud-sub-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: var(--ud-primary-light);
            border: 1.5px solid var(--ud-primary-border);
            border-radius: var(--ud-radius-sm);
            padding: 14px 18px;
            margin-bottom: 24px;
        }

        .ud-sub-banner-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ud-sub-banner-left svg {
            width: 18px; height: 18px;
            color: var(--ud-primary);
            flex-shrink: 0;
        }

        .ud-sub-banner-left span {
            font-size: .82rem;
            font-weight: 600;
            color: var(--ud-text);
        }

        .ud-sub-banner-left strong {
            color: var(--ud-primary);
        }

        .ud-days-pill {
            font-size: .7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            background: var(--ud-primary);
            color: #fff;
        }

        /* Video grid */
        .ud-video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .ud-video-card {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            overflow: hidden;
            cursor: pointer;
            transition: box-shadow var(--ud-transition), transform var(--ud-transition), border-color var(--ud-transition);
        }

        .ud-video-card:hover {
            box-shadow: var(--ud-shadow-lg);
            transform: translateY(-3px);
            border-color: var(--ud-primary-border);
        }

        .ud-video-thumb {
            position: relative;
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, #3d2b6b, #7b4fa0);
            overflow: hidden;
        }

        .ud-video-thumb-img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform var(--ud-transition);
        }

        .ud-video-card:hover .ud-video-thumb-img {
            transform: scale(1.04);
        }

        .ud-video-play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(30,18,55,.30);
            display: flex; align-items: center; justify-content: center;
            opacity: 0;
            transition: opacity var(--ud-transition);
        }

        .ud-video-card:hover .ud-video-play-overlay { opacity: 1; }

        .ud-video-play-btn {
            width: 52px; height: 52px;
            background: rgba(255,255,255,.92);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }

        .ud-video-play-btn svg {
            width: 20px; height: 20px;
            color: var(--ud-primary);
            margin-left: 3px;
        }

        .ud-video-duration {
            position: absolute;
            bottom: 8px; right: 8px;
            font-size: .65rem;
            font-weight: 700;
            background: rgba(0,0,0,.65);
            color: #fff;
            padding: 3px 7px;
            border-radius: 5px;
        }

        .ud-video-thumb-placeholder {
            width: 100%; height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ud-video-thumb-placeholder svg {
            width: 48px; height: 48px;
            color: rgba(255,255,255,.3);
        }

        .ud-video-info {
            padding: 16px;
        }

        .ud-video-info h4 {
            font-size: .9rem;
            font-weight: 700;
            color: var(--ud-text);
            margin: 0 0 5px;
            line-height: 1.3;
        }

        .ud-video-info p {
            font-size: .76rem;
            color: var(--ud-text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .ud-video-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }

        .ud-video-tag {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            background: var(--ud-primary-light);
            color: var(--ud-primary);
            padding: 3px 9px;
            border-radius: 50px;
        }

        .ud-video-lesson {
            font-size: .72rem;
            color: var(--ud-text-muted);
        }

        /* Video Modal */
        .ud-video-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(15,8,30,.88);
            backdrop-filter: blur(12px);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .ud-video-modal-overlay.active { display: flex; }

        .ud-video-modal {
            width: 100%;
            max-width: 880px;
            border-radius: var(--ud-radius);
            overflow: hidden;
            position: relative;
            box-shadow: 0 32px 100px rgba(0,0,0,.5);
        }

        .ud-video-modal-close {
            position: absolute;
            top: -44px; right: 0;
            width: 34px; height: 34px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background var(--ud-transition);
            z-index: 2;
        }

        .ud-video-modal-close:hover { background: rgba(255,255,255,.28); }
        .ud-video-modal-close svg { width: 14px; height: 14px; }

        .ud-video-modal-header {
            background: linear-gradient(135deg, #2d1a55, #6f54a4);
            padding: 20px 24px;
        }

        .ud-video-modal-header h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
        }

        .ud-video-modal-header p {
            font-size: .78rem;
            color: rgba(255,255,255,.65);
            margin: 0;
        }

        .ud-video-modal-player {
            background: #000;
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ud-video-modal-player iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* ════════════════════════════════════════════
           PROFILE TAB
        ════════════════════════════════════════════ */

        .ud-profile-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 28px;
        }

        @media (max-width: 760px) {
            .ud-profile-grid { grid-template-columns: 1fr; }
        }

        .ud-profile-sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .ud-profile-card {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            padding: 28px 20px;
            text-align: center;
        }

        .ud-profile-avatar {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--ud-gradient);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            font-weight: 900;
            color: #fff;
            margin: 0 auto 14px;
            border: 3px solid rgba(111,84,164,.2);
        }

        .ud-profile-card h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ud-text);
            margin: 0 0 4px;
        }

        .ud-profile-card p {
            font-size: .78rem;
            color: var(--ud-text-muted);
            margin: 0;
        }

        .ud-profile-stat {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius-sm);
            padding: 12px 16px;
        }

        .ud-profile-stat-icon {
            width: 36px; height: 36px;
            background: var(--ud-primary-light);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .ud-profile-stat-icon svg { width: 16px; height: 16px; color: var(--ud-primary); }

        .ud-profile-stat-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ud-text-muted);
            display: block;
            margin-bottom: 1px;
        }

        .ud-profile-stat-value {
            font-size: .88rem;
            font-weight: 700;
            color: var(--ud-text);
        }

        /* Form */
        .ud-form-section {
            background: var(--ud-surface-2);
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            padding: 28px;
        }

        .ud-form-section h3 {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--ud-text-muted);
            margin: 0 0 22px;
            padding-bottom: 14px;
            border-bottom: 1.5px solid var(--ud-border);
        }

        .ud-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        @media (max-width: 600px) { .ud-form-row { grid-template-columns: 1fr; } }

        .ud-form-group { margin-bottom: 16px; }

        .ud-form-group:last-child { margin-bottom: 0; }

        .ud-form-label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }

        .ud-form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e2e2;
            border-radius: var(--ud-radius-sm);
            font-size: .875rem;
            color: #333;
            background: var(--ud-surface);
            transition: border-color var(--ud-transition), box-shadow var(--ud-transition);
            outline: none;
            box-sizing: border-box;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-form-input:focus {
            border-color: var(--ud-primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(111,84,164,.09);
        }

        .ud-form-input[readonly] {
            background: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }

        .ud-save-btn {
            padding: 12px 28px;
            border-radius: var(--ud-radius-sm);
            background: var(--ud-primary);
            color: #fff;
            font-size: .88rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            margin-top: 8px;
            transition: background var(--ud-transition), transform var(--ud-transition);
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .ud-save-btn:hover { background: #5c4490; transform: translateY(-1px); }

        /* ─── Alerts ─── */
        .ud-alert {
            display: none;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--ud-radius-sm);
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .ud-alert.visible { display: flex; }
        .ud-alert.success { background: var(--ud-success-bg); color: var(--ud-success); border: 1.5px solid rgba(34,160,107,.2); }
        .ud-alert.error   { background: rgba(229,57,53,.07);  color: var(--ud-danger);  border: 1.5px solid rgba(229,57,53,.2); }

        /* ─── LOGOUT link ─── */
        .ud-logout-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .78rem;
            font-weight: 700;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            margin-top: 16px;
            padding: 7px 14px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,.25);
            transition: background var(--ud-transition), color var(--ud-transition);
        }

        .ud-logout-link:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .ud-logout-link svg { width: 13px; height: 13px; }

        /* ─── Confirmation toast ─── */
        .ud-toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: #fff;
            border: 1.5px solid var(--ud-border);
            border-radius: var(--ud-radius);
            box-shadow: var(--ud-shadow-lg);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 99999;
            max-width: 340px;
            transform: translateY(80px);
            opacity: 0;
            transition: all .3s cubic-bezier(.34,1.4,.64,1);
            pointer-events: none;
        }

        .ud-toast.visible {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        .ud-toast-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--ud-success-bg);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .ud-toast-icon svg { width: 16px; height: 16px; color: var(--ud-success); }

        .ud-toast-text strong { display: block; font-size: .88rem; color: var(--ud-text); }
        .ud-toast-text span   { font-size: .76rem; color: var(--ud-text-muted); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 640px) {
            .ud-panel { padding: 20px 16px; }
            .ud-tabs  { padding: 0 4px; }
            .ud-tab-btn { padding: 14px 14px; font-size: .78rem; }
            .ud-slots-grid { grid-template-columns: repeat(2,1fr); }
            .ud-video-grid { grid-template-columns: 1fr; }
        }
    </style>
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
                    $subDays  = auth()->user()->created_at->diffInDays(now());
                    $isLocked = $subDays > 30;
                    $daysLeft = max(0, 30 - $subDays);
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
                            <p>Ihr 30-tägiger Zugang ist abgelaufen. Erneuern Sie Ihr Paket, um wieder Zugriff auf alle Kurse zu erhalten.</p>
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
                            <p>Ihre Bitcoin-Sicherheitskurse — auf Ihrem eigenen Tempo lernen.</p>
                        </div>
                    </div>

                    @if(!$isLocked)
                    <div class="ud-sub-banner">
                        <div class="ud-sub-banner-left">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Ihr Zugang läuft ab in <strong>{{ $daysLeft }} {{ $daysLeft === 1 ? 'Tag' : 'Tagen' }}</strong> — Paket am {{ auth()->user()->created_at->addDays(30)->format('d.m.Y') }}</span>
                        </div>
                        <span class="ud-days-pill">{{ $daysLeft }}d verbleibend</span>
                    </div>
                    @endif

                    <div class="ud-video-grid">

                        {{-- Video 1 --}}
                        <div class="ud-video-card" onclick="udOpenVideo('Bitcoin Grundlagen erklärt', 'Die Basis von Bitcoin: Was ist eine Blockchain, wie funktionieren Wallets und warum ist Dezentralisierung wichtig.', 'https://www.youtube.com/embed/bBC-nXj3Ng4')">
                            <div class="ud-video-thumb" style="background: linear-gradient(135deg, #2d1a55 0%, #6f54a4 100%);">
                                <div class="ud-video-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/></svg>
                                </div>
                                <div class="ud-video-play-overlay">
                                    <div class="ud-video-play-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    </div>
                                </div>
                                <span class="ud-video-duration">18:42</span>
                            </div>
                            <div class="ud-video-info">
                                <h4>Bitcoin Grundlagen erklärt</h4>
                                <p>Was ist eine Blockchain, wie funktionieren Wallets und warum ist Dezentralisierung wichtig.</p>
                                <div class="ud-video-meta">
                                    <span class="ud-video-tag">Einführung</span>
                                    <span class="ud-video-lesson">Lektion 1</span>
                                </div>
                            </div>
                        </div>

                        {{-- Video 2 --}}
                        <div class="ud-video-card" onclick="udOpenVideo('Private Keys sicher verwahren', 'Schritt-für-Schritt: Hardware Wallets einrichten, Seed Phrases sichern und Cold Storage verstehen.', 'https://www.youtube.com/embed/Xdkkux6OxfM')">
                            <div class="ud-video-thumb" style="background: linear-gradient(135deg, #4a1a7a 0%, #c086c0 100%);">
                                <div class="ud-video-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none"/></svg>
                                </div>
                                <div class="ud-video-play-overlay">
                                    <div class="ud-video-play-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    </div>
                                </div>
                                <span class="ud-video-duration">24:15</span>
                            </div>
                            <div class="ud-video-info">
                                <h4>Private Keys sicher verwahren</h4>
                                <p>Hardware Wallets einrichten, Seed Phrases sichern und Cold Storage richtig umsetzen.</p>
                                <div class="ud-video-meta">
                                    <span class="ud-video-tag">Sicherheit</span>
                                    <span class="ud-video-lesson">Lektion 2</span>
                                </div>
                            </div>
                        </div>

                        {{-- Video 3 --}}
                        <div class="ud-video-card" onclick="udOpenVideo('Multisig & fortgeschrittene Sicherheit', 'Multi-Signatur-Setups, Passphrasen und die Kombination verschiedener Sicherheitsebenen für maximalen Schutz.', 'https://www.youtube.com/embed/XAMgI-IbF4s')">
                            <div class="ud-video-thumb" style="background: linear-gradient(135deg, #1a3a6b 0%, #6f54a4 100%);">
                                <div class="ud-video-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div class="ud-video-play-overlay">
                                    <div class="ud-video-play-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    </div>
                                </div>
                                <span class="ud-video-duration">31:07</span>
                            </div>
                            <div class="ud-video-info">
                                <h4>Multisig & fortgeschrittene Sicherheit</h4>
                                <p>Multi-Signatur-Setups, Passphrasen und kombinierte Sicherheitsebenen für maximalen Schutz.</p>
                                <div class="ud-video-meta">
                                    <span class="ud-video-tag">Fortgeschritten</span>
                                    <span class="ud-video-lesson">Lektion 3</span>
                                </div>
                            </div>
                        </div>

                    </div>
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
        window.udOpenVideo = function (title, desc, embedUrl) {
            document.getElementById('udVideoTitle').textContent  = title;
            document.getElementById('udVideoDesc').textContent   = desc;
            document.getElementById('udVideoPlayer').innerHTML   =
                `<iframe src="${embedUrl}?autoplay=1&rel=0" allowfullscreen allow="autoplay"></iframe>`;
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
    </script>

</body>
</html>