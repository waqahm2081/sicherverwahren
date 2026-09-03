<aside class="adm-sidebar">
    <div class="adm-sidebar__brand">
        <div class="adm-sidebar__logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 6h2v1.5c1.1.28 2 1.12 2 2.25 0 .7-.31 1.32-.8 1.75.79.4 1.3 1.18 1.3 2 0 1.43-1.2 2.5-2.5 2.5H11V18H9V7h2zm0 2v2h1.5c.55 0 1-.45 1-1s-.45-1-1-1H11zm0 4v2.25h1.75c.69 0 1.25-.45 1.25-1.12C14 13.45 13.44 13 12.75 13H11z"/>
            </svg>
        </div>
        <div class="adm-sidebar__brand-text">
            <span class="adm-sidebar__brand-name">Bitcoin Verwahren</span>
            <span class="adm-sidebar__brand-sub">Admin Panel</span>
        </div>
    </div>

    <nav class="adm-sidebar__nav">
        <div class="adm-sidebar__section-label">Navigation</div>

        <a href="{{ route('admin.dashboard') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.dashboard') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.users*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            <span>Benutzer verwalten</span>
        </a>

        <a href="{{ route('admin.packages.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.packages*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.35C18 2.53 15.9.5 13.35.5c-1.3 0-2.43.52-3.25 1.33L9 2.96l-1.1-1.13C7.08 1.01 5.95.5 4.65.5 2.1.5 0 2.53 0 4.65c0 .47.08.91.18 1.35H0v14h24V6h-4zm-3.65-4c1.08 0 2.15.92 2.15 2.15 0 .69-.31 1.38-.88 1.88L12 11.5 6.38 6.03c-.57-.5-.88-1.19-.88-1.88C5.5 3.27 6.42 2 7.65 2c.59 0 1.14.24 1.55.66l1.82 1.87.98 1.02.98-1.02 1.82-1.87c.41-.42.96-.66 1.55-.66zM2 18V8h8.55L8 10.75l2.08 2 3.92-4 3.92 4L20 10.75 17.45 8H22v10H2z"/></svg>
            <span>Pakete verwalten</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.orders*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            <span>Bestellungen verwalten</span>
        </a>

        <a href="{{ route('admin.coupons.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.coupons*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg>
            <span>Rabattcodes</span>
        </a>

        <a href="{{ route('admin.blogs.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.blogs*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            <span>Blog verwalten</span>
        </a>

        <a href="{{ route('admin.leads.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.leads*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            <span>Leads</span>
        </a>

        <a href="{{ route('admin.faqs.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.faqs*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"/></svg>
            <span>FAQs verwalten</span>
        </a>

        <a href="{{ route('admin.videos.index') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.videos*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
            <span>Videos</span>
        </a>

        <a href="{{ route('admin.profile.edit') }}"
           class="adm-sidebar__link {{ request()->routeIs('admin.profile*') ? 'adm-sidebar__link--active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
            <span>Passwort ändern</span>
        </a>
    </nav>

    <div class="adm-sidebar__footer">
        <div class="adm-sidebar__user">
            <div class="adm-sidebar__avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="adm-sidebar__user-info">
                <span class="adm-sidebar__user-name">{{ auth()->user()->name }}</span>
                <span class="adm-sidebar__user-role">Administrator</span>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="adm-sidebar__logout" title="Abmelden">
                <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </button>
        </form>
    </div>
</aside>
