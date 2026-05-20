<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Bitcoin Verwahrung: Leistungen & Preise | Privat & Unternehmen | DACH</title>
    <meta name="description" content="Unsere Bitcoin Sicherheits Pakete für Privatpersonen und KMU in Deutschland, Österreich und der Schweiz: Hardware Wallet Einrichtung, Multisig Setups, Backups, Dokumentation und Schulungen.">

    @include('includes.styles')
    <link rel="stylesheet" href="/css/pricing.css">

    {{-- Stripe.js — must load from Stripe's CDN --}}
    <script src="https://js.stripe.com/v3/"></script>
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
                        <p>Wir bieten massgeschneiderte Lösungen für Privatpersonen und Unternehmen. Wählen Sie zwischen persönlicher Betreuung mit Einrichtung vor Ort (inkl. Dokumentation) oder der kostengünstigeren eigenständigen Einrichtung über unsere interne Videoplattform.</p>
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

                            <div class="pricing-body">

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
                                        >📍 Vor-Ort-Service</button>
                                    </div>
                                @endif

                                <div class="pkg-active-price" id="price-display-{{ $pkg->id }}">
                                    <sup>CHF</sup>{{ $firstOpt->formattedPrice() }}
                                </div>

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

                                <div class="pkg-cta-row">
                                    <button
                                        class="pkg-cta-btn"
                                        onclick="openPkgModal('{{ $pkg->id }}')"
                                    >Jetzt anfragen</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <section class="teaservidsection">
        <div class="container">
            <video src="https://sicher-bitcoin-videos.s3.ap-southeast-1.amazonaws.com/homepage/teaser.mp4" controls></video>
        </div>
    </section>

    {{-- JSON DATA ISLAND --}}
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

    {{-- MODAL --}}
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

    {{-- Stripe card field styles --}}
    <style>
        .pkg-form__card-wrap {
            border: 1px solid #d1c4e9;
            border-radius: 8px;
            padding: 12px 14px;
            background: #faf9ff;
            margin-bottom: 4px;
            transition: border-color .2s;
        }
        .pkg-form__card-wrap.StripeElement--focus {
            border-color: #6f54a4;
            box-shadow: 0 0 0 3px rgba(111,84,164,.12);
        }
        .pkg-form__card-wrap.StripeElement--invalid {
            border-color: #e53e3e;
        }
        .pkg-form__step-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #6f54a4;
            margin: 18px 0 10px;
        }
        .pkg-form__payment-note {
            font-size: .75rem;
            color: #888;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .pkg-stripe-error {
            color: #e53e3e;
            font-size: .78rem;
            margin-top: 4px;
            min-height: 18px;
        }
    </style>

    @include('includes.footer')
    @include('includes.scripts')

    <script>
    (function () {
        'use strict';

        /* ── Stripe init ── */
        const stripe = Stripe('{{ env("STRIPE_PUBLISHABLEKEY") }}');
        let stripeElements = null; // Stripe Elements instance
        let cardElement    = null; // the CardElement

        /* ── Data ── */
        const pricingData = JSON.parse(document.getElementById('pricing-data').textContent);

        /* Track which option is active per package */
        const activeOption = {};
        pricingData.forEach(pkg => {
            const first = pkg.options.find(o => o.type === 'digital') ?? pkg.options[0];
            activeOption[pkg.id] = first ? first.type : null;
        });

        /* ── Tab switcher ── */
        window.switchTab = function (btn, panelId, pkgId) {
            const wrapper = btn.closest('.pricing-item');
            wrapper.querySelectorAll('.pkg-tab-btn').forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            wrapper.querySelectorAll('.pkg-features-panel').forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.add('active');
                const priceDisplay = document.getElementById('price-display-' + pkgId);
                if (priceDisplay) {
                    priceDisplay.innerHTML = '<sup>CHF</sup>' + panel.dataset.price;
                }
                activeOption[pkgId] = panel.dataset.optionType;
            }
        };

        /* ── Helpers ── */
        function esc(str) {
            return String(str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

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
            const stripeErr = document.getElementById('stripe-error');
            if (stripeErr) stripeErr.textContent = '';
        }

        /* ── Open modal ── */
        window.openPkgModal = function (pkgId) {
            const pkg = pricingData.find(p => String(p.id) === String(pkgId));
            if (!pkg) return;

            const type = activeOption[pkgId];
            const opt  = pkg.options.find(o => o.type === type) ?? pkg.options[0];
            if (!opt) return;

            const typeLbl = opt.type === 'digital' ? '⚡ Digital Package' : '📍 Vor-Ort-Service Service';

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
                <p class="pkg-form__title">Konto erstellen & bezahlen</p>

                <div id="pkgFormWrap">

                    {{-- Step 1: Account details --}}
                    <p class="pkg-form__step-label">① Ihre Angaben</p>

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

                    {{-- After the name/phone row, before email --}}
                    <div class="pkg-form__group">
                        <label class="pkg-form__label" for="pf_language">Bevorzugte Sprache *</label>
                        <select class="pkg-form__input" id="pf_language">
                            <option value="de">🇩🇪 Deutsch</option>
                            <option value="en">🇬🇧 English</option>
                        </select>
                        <div class="pkg-form__error" id="err_language"></div>
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

                    {{-- Step 2: Payment --}}
                    <p class="pkg-form__step-label">② Zahlung</p>
                    <p class="pkg-form__payment-note">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#6f54a4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Sichere Zahlung via Stripe – CHF ${esc(opt.price_fmt)}
                    </p>
                    <label class="pkg-form__label">Kartendetails *</label>
                    <div class="pkg-form__card-wrap" id="stripe-card-element">
                        {{-- Stripe CardElement mounts here --}}
                    </div>
                    <div class="pkg-stripe-error" id="stripe-error"></div>

                    <div class="pkg-form__error" id="err_general" style="font-size:.78rem; margin-top:8px;"></div>

                    <button class="pkg-form__submit" id="pf_submit"
                        onclick="submitPkgForm('${esc(pkg.name)}', '${esc(opt.type)}', '${esc(String(opt.id))}')">
                        Jetzt bezahlen & registrieren
                    </button>
                    <button class="pkg-form__cancel" onclick="closePkgModal()">Abbrechen</button>
                </div>

                <div class="pkg-form__success" id="pkgFormSuccess">
                    <div class="pkg-form__success-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <h3>Zahlung & Registrierung erfolgreich!</h3>
                    <p>Ihr Konto wurde erstellt. Wir melden uns in Kürze bei Ihnen.</p>
                    <button class="pkg-form__cancel" onclick="closePkgModal()">Schliessen</button>
                </div>
            </div>`;

            /* Mount Stripe CardElement */
            stripeElements = stripe.elements();
            cardElement = stripeElements.create('card', {
                style: {
                    base: {
                        fontFamily: 'inherit',
                        fontSize: '15px',
                        color: '#2d2d2d',
                        '::placeholder': { color: '#aaa' },
                    },
                    invalid: { color: '#e53e3e' },
                },
                hidePostalCode: true,
            });
            cardElement.mount('#stripe-card-element');

            cardElement.on('change', function (event) {
                const errEl = document.getElementById('stripe-error');
                if (errEl) errEl.textContent = event.error ? event.error.message : '';
            });

            document.getElementById('pkgModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                const first = document.getElementById('pf_name');
                if (first) first.focus();
            }, 80);
        };

        /* ── Close modal ── */
        window.closePkgModal = function () {
            document.getElementById('pkgModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            if (cardElement) { cardElement.destroy(); cardElement = null; }
            stripeElements = null;
        };

        document.getElementById('pkgModalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closePkgModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePkgModal();
        });

        /* ── Submit ── */
        window.submitPkgForm = async function (pkgName, optType, optionId) {
            clearErrors();

            const name     = (document.getElementById('pf_name')?.value || '').trim();
            const phone    = (document.getElementById('pf_phone')?.value || '').trim();
            const email    = (document.getElementById('pf_email')?.value || '').trim();
            const password = (document.getElementById('pf_password')?.value || '');
            const confirm  = (document.getElementById('pf_password_confirm')?.value || '');
            const language = document.getElementById('pf_language')?.value || 'de';

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
            if (btn) { btn.disabled = true; btn.textContent = 'Zahlung wird verarbeitet…'; }

            try {
                /* ── Step A: Create PaymentIntent on server ── */
                const intentRes = await fetch('{{ route("pricing.paymentIntent") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        selected_package:     pkgName,
                        selected_option_type: optType,
                        option_id:            optionId,
                    }),
                });
                const intentData = await intentRes.json();

                if (!intentRes.ok || !intentData.client_secret) {
                    setError('err_general', intentData.message || 'Fehler beim Erstellen der Zahlung.');
                    if (btn) { btn.disabled = false; btn.textContent = 'Jetzt bezahlen & registrieren'; }
                    return;
                }

                /* ── Step B: Confirm card payment via Stripe.js ── */
                const { paymentIntent, error } = await stripe.confirmCardPayment(
                    intentData.client_secret,
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name, email },
                        },
                    }
                );

                if (error) {
                    const errEl = document.getElementById('stripe-error');
                    if (errEl) errEl.textContent = error.message;
                    if (btn) { btn.disabled = false; btn.textContent = 'Jetzt bezahlen & registrieren'; }
                    return;
                }

                if (paymentIntent.status !== 'succeeded') {
                    setError('err_general', 'Zahlung nicht abgeschlossen. Bitte versuchen Sie es erneut.');
                    if (btn) { btn.disabled = false; btn.textContent = 'Jetzt bezahlen & registrieren'; }
                    return;
                }

                /* ── Step C: Register user after successful payment ── */
                if (btn) btn.textContent = 'Konto wird erstellt…';

                const regRes = await fetch('{{ route("pricing.register") }}', {
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
                        payment_intent_id:     paymentIntent.id,
                        preferred_language: language,
                    }),
                });

                const regData = await regRes.json();

                if (regRes.ok && regData.success) {
                    document.getElementById('pkgFormWrap').style.display = 'none';
                    document.getElementById('pkgFormSuccess').classList.add('visible');
                } else {
                    if (regData.errors) {
                        const map = {
                            name:                  'err_name',
                            email:                 'err_email',
                            phone:                 'err_phone',
                            password:              'err_password',
                            password_confirmation: 'err_password_confirm',
                        };
                        Object.entries(regData.errors).forEach(([field, msgs]) => {
                            if (map[field]) setError(map[field], msgs[0]);
                        });
                    } else {
                        setError('err_general', regData.message || 'Ein Fehler ist aufgetreten.');
                    }
                    if (btn) { btn.disabled = false; btn.textContent = 'Jetzt bezahlen & registrieren'; }
                }

            } catch (err) {
                setError('err_general', 'Verbindungsfehler. Bitte versuchen Sie es erneut.');
                if (btn) { btn.disabled = false; btn.textContent = 'Jetzt bezahlen & registrieren'; }
            }
        };

    })();
    </script>

</body>
</html>