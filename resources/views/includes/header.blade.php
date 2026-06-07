<div class="topbar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="topbar-contact-info">
                    <ul>
                        <li><a href="mailto:info@sicher-bitcoin-verwahren.ch">info@sicher-bitcoin-verwahren.ch</a></li>
                        <li><a href="#">Allmendingen-Allee 9, 3608 Thun</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<header class="main-header">
    <div class="header-sticky">
        <nav class="navbar navbar-expand-lg">
            <div class="container">

                <!-- Logo -->
                <a class="navbar-brand" href="/">
                    <img src="/images/logo.jpg" style="width: 80px;" alt="Logo">
                </a>

                <!-- Main Menu -->
                <div class="collapse navbar-collapse main-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="/about-us" style="text-transform: lowercase;">über uns</a></li>
                            <li class="nav-item"><a class="nav-link" href="/pricing">Leistungen & Preise</a></li>
                            <li class="nav-item"><a class="nav-link" href="/workshops">Workshops</a></li>
                            <li class="nav-item"><a class="nav-link" href="/faqs">FAQs</a></li>
                            <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                            <li class="nav-item"><a class="nav-link" href="/contact-us" style="text-transform: inherit;">Kontaktieren Sie uns</a></li>
                        </ul>
                    </div>

                    <!-- Header Btn: Login or Dashboard -->
                    <div class="header-btn" style="display:flex;align-items:center;gap:10px;">

                        @auth
                            {{-- User is logged in → show Dashboard button --}}
                            <a href="{{ route('user.dashboard') }}" class="btn-default" style="display:inline-flex;align-items:center;gap:8px;padding-right:46px;">
                                <svg style="width:16px;height:16px;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                                Dashboard
                            </a>

                            {{-- Logout button --}}
                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" style="
                                    background: transparent;
                                    border: 1.5px solid rgba(111,84,164,.35);
                                    border-radius: 100px;
                                    color: #6f54a4;
                                    font-size: 14px;
                                    font-weight: 600;
                                    padding: 10px 18px;
                                    cursor: pointer;
                                    font-family: 'Plus Jakarta Sans', sans-serif;
                                    transition: all 0.3s ease;
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 6px;
                                " onmouseover="this.style.background='rgba(111,84,164,.08)'" onmouseout="this.style.background='transparent'">
                                    <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    Abmelden
                                </button>
                            </form>
                        @else
                            {{-- User not logged in → show Login --}}
                            <a href="{{ route('login') }}" class="btn-default">
                                <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                    <polyline points="10 17 15 12 10 7"/>
                                    <line x1="15" y1="12" x2="3" y2="12"/>
                                </svg>
                                Anmelden
                            </a>
                        @endauth

                    </div>
                </div>

                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>

<style>
    .slicknav_menu .header-auth-mobile {
        padding: 10px 20px 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .slicknav_menu .header-auth-mobile a,
    .slicknav_menu .header-auth-mobile button {
        display: block;
        text-align: left;
        padding: 10px 0;
        border: none;
        background: transparent;
        color: rgba(255,255,255,.85);
        font-size: 16px;
        font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        text-decoration: none;
        border-bottom: 1px solid rgba(255,255,255,.15);
    }
</style>
