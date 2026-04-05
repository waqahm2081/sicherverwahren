<!DOCTYPE html>
<html lang="zxx">

<head>

    <title>Bitcoin Verwahrung: Leistungen & Preise | Privat & Unternehmen | Schweiz</title>
    <meta name="description" content="Unsere Bitcoin Sicherheits Pakete für Privatpersonen und KMU: Hardware Wallet Einrichtung, Multisig Setups, Backups, Dokumentation und Schulungen in der Schweiz.">

    @include('includes.styles')

    <style>
        /* ═══════════════════════════════════════════════════════════════
           PRICING PAGE — purple theme
        ═══════════════════════════════════════════════════════════════ */
        :root {
            --primary:        #6f54a4;
            --primary-light:  rgba(111,84,164,.12);
            --primary-border: rgba(111,84,164,.30);
            --secondary:      #c086c0;
            --savings-green:  #22a06b;
            --savings-bg:     rgba(34,160,107,.08);
            --radius-card:    14px;
            --radius-btn:     9px;
            --transition:     0.22s ease;
        }

        /* ─── CARD hover ─── */
        .pricing-item {
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        .pricing-item:hover {
            border-color: var(--primary-border) !important;
            box-shadow: 0 8px 36px rgba(111,84,164,.10) !important;
        }

        /* ─── OPTION TOGGLE TABS ─── */
        .pkg-tabs {
            display: flex;
            gap: 0;
            border-radius: var(--radius-btn);
            border: 1.5px solid rgba(111,84,164,.22);
            overflow: hidden;
            margin-bottom: 18px;
        }
        .pkg-tab-btn {
            flex: 1;
            padding: 9px 10px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--primary);
            opacity: .55;
            transition: background var(--transition), opacity var(--transition);
            position: relative;
        }
        .pkg-tab-btn:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0; top: 20%; height: 60%;
            width: 1px;
            background: rgba(111,84,164,.22);
        }
        .pkg-tab-btn.active {
            background: var(--primary);
            color: #fff;
            opacity: 1;
        }
        .pkg-tab-btn:not(.active):hover {
            background: var(--primary-light);
            opacity: 1;
        }

        /* ─── FEATURE PANELS ─── */
        .pkg-features-panel { display: none; }
        .pkg-features-panel.active { display: block; }

        /* ─── SAVINGS LABEL ─── */
        .pkg-savings {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            font-size: .74rem;
            font-weight: 600;
            color: var(--savings-green);
            background: var(--savings-bg);
            border-radius: 7px;
            padding: 6px 10px;
        }
        .pkg-savings svg { width: 13px; height: 13px; flex-shrink: 0; }

        .pkg-onsite-only {
            margin-top: 12px;
            font-size: .72rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 5px;
            opacity: .8;
        }
        .pkg-onsite-only svg { width: 12px; height: 12px; }

        /* ─── CTA BUTTON on card ─── */
        .pkg-cta-row {
            margin-top: 20px;
        }
        .pkg-cta-btn {
            display: block;
            width: 100%;
            padding: 12px 18px;
            border-radius: var(--radius-btn);
            background: var(--primary);
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }
        .pkg-cta-btn:hover {
            background: #5c4490;
            transform: translateY(-1px);
            color: #fff;
        }

        /* ─── PRICE shown below tabs ─── */
        .pkg-active-price {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 16px;
        }
        .pkg-active-price sup {
            font-size: .6rem;
            font-weight: 600;
            vertical-align: super;
            margin-right: 1px;
            opacity: .8;
        }

        /* ─── MOBILE ─── */
        @media (max-width: 400px) {
            .pkg-tabs { flex-direction: column; }
        }


        /* ═══════════════════════════════════════════════════════════════
           MODAL
        ═══════════════════════════════════════════════════════════════ */
        .pkg-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(30,18,50,.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .pkg-modal-overlay.active { display: flex; }

        .pkg-modal {
            background: #fff;
            border: 1.5px solid var(--primary-border);
            border-radius: 18px;
            width: 100%;
            max-width: 540px;
            max-height: 92vh;
            overflow-y: auto;
            position: relative;
            animation: modalIn .26s cubic-bezier(.34,1.4,.64,1);
            box-shadow: 0 24px 80px rgba(111,84,164,.20);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }
        .pkg-modal::-webkit-scrollbar { width: 4px; }
        .pkg-modal::-webkit-scrollbar-thumb { background: rgba(111,84,164,.25); border-radius: 4px; }

        .pkg-modal__close {
            position: absolute;
            top: 14px; right: 14px;
            width: 30px; height: 30px;
            border-radius: 50%;
            border: 1.5px solid rgba(111,84,164,.2);
            background: rgba(111,84,164,.06);
            color: var(--primary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background var(--transition);
            z-index: 2;
        }
        .pkg-modal__close:hover { background: rgba(111,84,164,.14); }
        .pkg-modal__close svg { width: 13px; height: 13px; }

        /* Header */
        .pkg-modal__header {
            background: linear-gradient(135deg, var(--primary) 0%, #9b78c8 100%);
            padding: 28px 30px 22px;
            color: #fff;
        }
        .pkg-modal__type-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .63rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 50px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.30);
            color: #fff;
            margin-bottom: 10px;
        }
        .pkg-modal__pkg-name {
            font-size: 1.45rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 2px;
            line-height: 1.2;
            padding-right: 36px;
        }
        .pkg-modal__option-name {
            font-size: .85rem;
            color: rgba(255,255,255,.75);
            margin: 0 0 12px;
        }
        .pkg-modal__price-row {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        .pkg-modal__price {
            font-size: 2.2rem;
            font-weight: 900;
            color: #fff;
            line-height: 1;
        }
        .pkg-modal__price-currency {
            font-size: 1rem;
            color: rgba(255,255,255,.75);
            font-weight: 600;
        }

        /* Body */
        .pkg-modal__body { padding: 22px 30px 28px; }

        /* ─── REGISTRATION FORM ─── */
        .pkg-form__title {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 16px;
        }
        .pkg-form__group {
            margin-bottom: 14px;
        }
        .pkg-form__label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        .pkg-form__input {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #e2e2e2;
            border-radius: var(--radius-btn);
            font-size: .875rem;
            color: #333;
            background: #fafafa;
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none;
            box-sizing: border-box;
        }
        .pkg-form__input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(111,84,164,.10);
        }
        .pkg-form__input.error {
            border-color: #e53935;
        }
        .pkg-form__error {
            font-size: .7rem;
            color: #e53935;
            margin-top: 4px;
            display: none;
        }
        .pkg-form__error.visible { display: block; }

        .pkg-form__row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 480px) { .pkg-form__row { grid-template-columns: 1fr; } }

        .pkg-form__submit {
            display: block;
            width: 100%;
            padding: 13px 20px;
            border-radius: var(--radius-btn);
            background: var(--primary);
            color: #fff;
            font-size: .9rem;
            font-weight: 700;
            text-align: center;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            transition: background var(--transition), transform var(--transition);
        }
        .pkg-form__submit:hover:not(:disabled) {
            background: #5c4490;
            transform: translateY(-1px);
        }
        .pkg-form__submit:disabled { opacity: .65; cursor: not-allowed; }

        .pkg-form__cancel {
            display: block;
            width: 100%;
            padding: 11px 20px;
            border-radius: var(--radius-btn);
            background: transparent;
            color: #999;
            font-size: .85rem;
            font-weight: 600;
            text-align: center;
            border: 1.5px solid #e8e8e8;
            cursor: pointer;
            margin-top: 9px;
            transition: border-color var(--transition), color var(--transition);
        }
        .pkg-form__cancel:hover { border-color: #ccc; color: #555; }

        /* Success state */
        .pkg-form__success {
            display: none;
            text-align: center;
            padding: 20px 10px 10px;
        }
        .pkg-form__success.visible { display: block; }
        .pkg-form__success-icon {
            width: 52px; height: 52px;
            background: rgba(34,160,107,.12);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .pkg-form__success-icon svg { width: 24px; height: 24px; color: var(--savings-green); }
        .pkg-form__success h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 6px;
        }
        .pkg-form__success p {
            font-size: .85rem;
            color: #777;
            margin-bottom: 18px;
        }

        /* Mobile */
        @media (max-width: 575px) {
            .pkg-modal { border-radius: 14px; }
            .pkg-modal__header,
            .pkg-modal__body { padding-left: 20px; padding-right: 20px; }
            .pkg-modal__price { font-size: 1.8rem; }
        }
    </style>
</head>

<body>

    @include('includes.header')

    <div class="page-header parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Leistungen & Preise</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="our-pricing">
        <div class="container">

            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Service-Pakete & Preise</h3>
                        <h2 class="wow fadeInUp" style="text-transform: initial;" data-wow-delay="0.2s" data-cursor="-opaque">
                            Bitcoin Verwahrung – Leistungen & Preise für Privatkunden & Unternehmen
                        </h2>
                        <p>Wir bieten maßgeschneiderte Lösungen für Privatpersonen und Unternehmen. Alle Pakete beinhalten eine persönliche Betreuung, die Einrichtung vor Ort oder in unseren Räumlichkeiten in Thun sowie eine umfassende Dokumentation.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                @foreach($packages as $pkg)
                    @php
                        $digital  = $pkg->options->firstWhere('type', 'digital');
                        $onsite   = $pkg->options->firstWhere('type', 'onsite');
                        $savings  = ($digital && $onsite) ? ($onsite->price_chf - $digital->price_chf) : null;
                        $isEnterp = $pkg->options->count() === 1 && ! $digital;
                        $firstOpt = $digital ?? $onsite ?? $pkg->options->first();
                    @endphp

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <div class="pricing-item">

                            {{-- ── Header ── --}}
                            <div class="pricing-header">
                                <h3>{{ $pkg->name }}</h3>
                                <h2>
                                    <sup>CHF</sup>{{ $firstOpt->formattedPrice() }}
                                </h2>
                                <p style="text-transform: initial !important;">{{ $pkg->portfolio_label }}</p>
                                <div class="icon-box">
                                    <img src="/images/icon-pricing-{{ $loop->iteration <= 2 ? $loop->iteration : 3 }}.svg" alt="">
                                </div>
                            </div>

                            {{-- ── Body ── --}}
                            <div class="pricing-body">

                                {{-- Tab switcher (hidden if only one option) --}}
                                @if($digital && $onsite)
                                    <div class="pkg-tabs" role="tablist">
                                        <button
                                            class="pkg-tab-btn active"
                                            role="tab"
                                            aria-selected="true"
                                            data-target="panel-digital-{{ $pkg->id }}"
                                            onclick="switchTab(this, 'panel-digital-{{ $pkg->id }}', '{{ $pkg->id }}')"
                                        >⚡ Digital</button>
                                        <button
                                            class="pkg-tab-btn"
                                            role="tab"
                                            aria-selected="false"
                                            data-target="panel-onsite-{{ $pkg->id }}"
                                            onclick="switchTab(this, 'panel-onsite-{{ $pkg->id }}', '{{ $pkg->id }}')"
                                        >📍 On-Site</button>
                                    </div>
                                @endif

                                {{-- Active price display --}}
                                <div class="pkg-active-price" id="price-display-{{ $pkg->id }}">
                                    <sup>CHF</sup>{{ $firstOpt->formattedPrice() }}
                                </div>

                                {{-- Digital features panel --}}
                                @if($digital)
                                    <div
                                        class="pkg-features-panel pricing-list {{ $digital ? 'active' : '' }}"
                                        id="panel-digital-{{ $pkg->id }}"
                                        role="tabpanel"
                                        data-price="{{ $digital->formattedPrice() }}"
                                        data-option-id="{{ $digital->id }}"
                                        data-option-type="digital"
                                    >
                                        <ul>
                                            @foreach($digital->features as $feature)
                                                <li>{{ $feature->feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- On-Site features panel --}}
                                @if($onsite)
                                    <div
                                        class="pkg-features-panel pricing-list {{ !$digital ? 'active' : '' }}"
                                        id="panel-onsite-{{ $pkg->id }}"
                                        role="tabpanel"
                                        data-price="{{ $onsite->formattedPrice() }}"
                                        data-option-id="{{ $onsite->id }}"
                                        data-option-type="onsite"
                                    >
                                        <ul>
                                            @foreach($onsite->features as $feature)
                                                <li>{{ $feature->feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Savings note --}}
                                @if($savings)
                                    <div class="pkg-savings">
                                        <svg viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.5 1v11M3 8l3.5 4 3.5-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Spare <strong style="margin: 0 3px;">CHF {{ number_format($savings, 0, '.', "'") }}</strong> mit Digital
                                    </div>
                                @endif

                                @if($isEnterp)
                                    <div class="pkg-onsite-only">
                                        <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.2"/>
                                            <path d="M6 5v3M6 3.5v.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                        </svg>
                                        Ausschliesslich als Vor-Ort-Service
                                    </div>
                                @endif

                                {{-- CTA --}}
                                <div class="pkg-cta-row">
                                    <button
                                        class="pkg-cta-btn"
                                        onclick="openPkgModal('{{ $pkg->id }}')"
                                    >Jetzt anfragen</button>
                                </div>

                            </div>{{-- /pricing-body --}}
                        </div>{{-- /pricing-item --}}
                    </div>{{-- /col --}}
                @endforeach

            </div>{{-- /row --}}
        </div>{{-- /container --}}
    </div>{{-- /our-pricing --}}


    {{-- ══════════════════════════════════════════════════════════════
         JSON DATA ISLAND
    ══════════════════════════════════════════════════════════════ --}}
    <script id="pricing-data" type="application/json">
        {!! json_encode($packages->map(function ($pkg) {
            return [
                'id'              => $pkg->id,
                'name'            => $pkg->name,
                'portfolio_label' => $pkg->portfolio_label,
                'savings'         => $pkg->savings(),
                'options'         => $pkg->options->map(function ($opt) {
                    return [
                        'id'             => $opt->id,
                        'type'           => $opt->type,
                        'label'          => $opt->label,
                        'price_chf'      => $opt->price_chf,
                        'price_fmt'      => $opt->formattedPrice(),
                        'is_recommended' => $opt->is_recommended,
                        'is_only_option' => $opt->is_only_option,
                        'features'       => $opt->features->map(fn($f) => [
                            'text'         => $f->feature,
                            'is_inherited' => $f->is_inherited,
                        ])->values(),
                    ];
                })->values(),
            ];
        })->values(), JSON_HEX_TAG | JSON_HEX_AMP) !!}
    </script>


    {{-- ══════════════════════════════════════════════════════════════
         MODAL
    ══════════════════════════════════════════════════════════════ --}}
    <div class="pkg-modal-overlay" id="pkgModalOverlay" role="dialog" aria-modal="true" aria-labelledby="pkgModalTitle">
        <div class="pkg-modal" id="pkgModal">
            <button class="pkg-modal__close" onclick="closePkgModal()" aria-label="Schliessen">
                <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
            <div id="pkgModalContent"></div>
        </div>
    </div>


    @include('includes.footer')
    @include('includes.scripts')

    <script>
    (function () {
        'use strict';

        /* ── Data ── */
        const pricingData = JSON.parse(document.getElementById('pricing-data').textContent);

        /* Track which option is active per package: pkgId → optionType */
        const activeOption = {};
        pricingData.forEach(pkg => {
            const first = pkg.options.find(o => o.type === 'digital') ?? pkg.options[0];
            activeOption[pkg.id] = first ? first.type : null;
        });

        /* ── Tab switcher ── */
        window.switchTab = function (btn, panelId, pkgId) {
            const wrapper = btn.closest('.pricing-item');

            /* Deactivate all tabs */
            wrapper.querySelectorAll('.pkg-tab-btn').forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            /* Deactivate all panels */
            wrapper.querySelectorAll('.pkg-features-panel').forEach(p => p.classList.remove('active'));

            /* Activate clicked */
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.add('active');
                /* Update price display */
                const priceDisplay = document.getElementById('price-display-' + pkgId);
                if (priceDisplay) {
                    priceDisplay.innerHTML = '<sup>CHF</sup>' + panel.dataset.price;
                }
                activeOption[pkgId] = panel.dataset.optionType;
            }
        };

        /* ── Modal helpers ── */
        function esc(str) {
            return String(str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        /* ── Open modal ── */
        window.openPkgModal = function (pkgId) {
            const pkg    = pricingData.find(p => String(p.id) === String(pkgId));
            if (!pkg) return;

            const type   = activeOption[pkgId];
            const opt    = pkg.options.find(o => o.type === type) ?? pkg.options[0];
            if (!opt) return;

            const typeLbl = opt.type === 'digital' ? '⚡ Digital Package' : '📍 On-Site Service';

            document.getElementById('pkgModalContent').innerHTML = `
            <div class="pkg-modal__header">
                <span class="pkg-modal__type-badge">${typeLbl}</span>
                <h2 class="pkg-modal__pkg-name" id="pkgModalTitle">${esc(pkg.name)}</h2>
                <p class="pkg-modal__option-name">${esc(opt.label)}</p>
                <div class="pkg-modal__price-row">
                    <span class="pkg-modal__price-currency">CHF</span>
                    <span class="pkg-modal__price">${esc(opt.price_fmt)}</span>
                </div>
            </div>
            <div class="pkg-modal__body">
                <p class="pkg-form__title">Konto erstellen & anfragen</p>

                <div id="pkgFormWrap">
                    <div class="pkg-form__row">
                        <div class="pkg-form__group">
                            <label class="pkg-form__label" for="pf_name">Vollständiger Name *</label>
                            <input class="pkg-form__input" id="pf_name" type="text" placeholder="Max Mustermann" autocomplete="name">
                            <div class="pkg-form__error" id="err_name"></div>
                        </div>
                        <div class="pkg-form__group">
                            <label class="pkg-form__label" for="pf_phone">Telefonnummer *</label>
                            <input class="pkg-form__input" id="pf_phone" type="tel" placeholder="+41 79 000 00 00" autocomplete="tel">
                            <div class="pkg-form__error" id="err_phone"></div>
                        </div>
                    </div>

                    <div class="pkg-form__group">
                        <label class="pkg-form__label" for="pf_email">E-Mail-Adresse *</label>
                        <input class="pkg-form__input" id="pf_email" type="email" placeholder="max@example.com" autocomplete="email">
                        <div class="pkg-form__error" id="err_email"></div>
                    </div>

                    <div class="pkg-form__row">
                        <div class="pkg-form__group">
                            <label class="pkg-form__label" for="pf_password">Passwort *</label>
                            <input class="pkg-form__input" id="pf_password" type="password" placeholder="Mind. 8 Zeichen" autocomplete="new-password">
                            <div class="pkg-form__error" id="err_password"></div>
                        </div>
                        <div class="pkg-form__group">
                            <label class="pkg-form__label" for="pf_password_confirm">Passwort bestätigen *</label>
                            <input class="pkg-form__input" id="pf_password_confirm" type="password" placeholder="Wiederholen" autocomplete="new-password">
                            <div class="pkg-form__error" id="err_password_confirm"></div>
                        </div>
                    </div>

                    <div class="pkg-form__error" id="err_general" style="font-size:.78rem; margin-top:4px;"></div>

                    <button class="pkg-form__submit" id="pf_submit" onclick="submitPkgForm('${esc(pkg.name)}', '${esc(opt.type)}')">
                        Jetzt registrieren & anfragen
                    </button>
                    <button class="pkg-form__cancel" onclick="closePkgModal()">Abbrechen</button>
                </div>

                <div class="pkg-form__success" id="pkgFormSuccess">
                    <div class="pkg-form__success-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <h3>Erfolgreich registriert!</h3>
                    <p>Ihr Konto wurde erstellt. Wir melden uns in Kürze bei Ihnen.</p>
                    <button class="pkg-form__cancel" onclick="closePkgModal()">Schliessen</button>
                </div>
            </div>`;

            document.getElementById('pkgModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';

            /* Auto-focus first input */
            setTimeout(() => {
                const first = document.getElementById('pf_name');
                if (first) first.focus();
            }, 80);
        };

        /* ── Close modal ── */
        window.closePkgModal = function () {
            document.getElementById('pkgModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        };

        /* ── Overlay click ── */
        document.getElementById('pkgModalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closePkgModal();
        });

        /* ── Escape key ── */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePkgModal();
        });

        /* ── Form helpers ── */
        function setError(id, msg) {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = msg;
            el.classList.toggle('visible', !!msg);
            const input = document.getElementById(id.replace('err_', 'pf_'));
            if (input) input.classList.toggle('error', !!msg);
        }
        function clearErrors() {
            ['name','phone','email','password','password_confirm','general'].forEach(k => setError('err_' + k, ''));
        }

        /* ── Submit ── */
        window.submitPkgForm = async function (pkgName, optType) {
            clearErrors();

            const name     = (document.getElementById('pf_name')?.value || '').trim();
            const phone    = (document.getElementById('pf_phone')?.value || '').trim();
            const email    = (document.getElementById('pf_email')?.value || '').trim();
            const password = (document.getElementById('pf_password')?.value || '');
            const confirm  = (document.getElementById('pf_password_confirm')?.value || '');

            let hasError = false;

            if (!name)  { setError('err_name', 'Bitte geben Sie Ihren Namen ein.'); hasError = true; }
            if (!phone) { setError('err_phone', 'Bitte geben Sie Ihre Telefonnummer ein.'); hasError = true; }
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                setError('err_email', 'Bitte geben Sie eine gültige E-Mail-Adresse ein.'); hasError = true;
            }
            if (password.length < 8) { setError('err_password', 'Mindestens 8 Zeichen erforderlich.'); hasError = true; }
            if (password !== confirm) { setError('err_password_confirm', 'Passwörter stimmen nicht überein.'); hasError = true; }

            if (hasError) return;

            const btn = document.getElementById('pf_submit');
            if (btn) { btn.disabled = true; btn.textContent = 'Wird gesendet…'; }

            try {
                const res = await fetch('{{ route("pricing.register") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name,
                        phone,
                        email,
                        password,
                        password_confirmation: confirm,
                        selected_package:      pkgName,
                        selected_option_type:  optType,
                    }),
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    document.getElementById('pkgFormWrap').style.display = 'none';
                    document.getElementById('pkgFormSuccess').classList.add('visible');
                } else {
                    /* Laravel validation errors */
                    if (data.errors) {
                        const map = {
                            name:                  'err_name',
                            email:                 'err_email',
                            phone:                 'err_phone',
                            password:              'err_password',
                            password_confirmation: 'err_password_confirm',
                        };
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            if (map[field]) setError(map[field], msgs[0]);
                        });
                    } else {
                        setError('err_general', data.message || 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.');
                    }
                    if (btn) { btn.disabled = false; btn.textContent = 'Jetzt registrieren & anfragen'; }
                }
            } catch (err) {
                setError('err_general', 'Verbindungsfehler. Bitte versuchen Sie es erneut.');
                if (btn) { btn.disabled = false; btn.textContent = 'Jetzt registrieren & anfragen'; }
            }
        };

    })();
    </script>

</body>
</html>