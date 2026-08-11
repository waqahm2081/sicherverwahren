<!DOCTYPE html>
<html lang="{{ $user->preferred_language === 'en' ? 'en' : 'de' }}">

<head>
    <title>
        {{ $user->preferred_language === 'en' ? 'Complete Payment' : 'Zahlung abschliessen' }}
        – Sicher Bitcoin Verwahren
    </title>

    @include('includes.styles')

    @if(! $alreadyPaid)
        <script src="https://js.stripe.com/v3/"></script>
    @endif

    <style>
        :root {
            --pp-primary:        #6f54a4;
            --pp-primary-light:  rgba(111,84,164,.10);
            --pp-primary-border: rgba(111,84,164,.25);
            --pp-secondary:      #c086c0;
            --pp-radius:         14px;
        }

        .pp-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f6fc 0%, #ede8f7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
            font-family: "DM Sans", Arial, sans-serif;
        }

        .pp-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 20px 70px rgba(111,84,164,.16);
            border: 1.5px solid rgba(111,84,164,.15);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }

        .pp-header {
            background: linear-gradient(135deg, #6f54a4 0%, #9b78c8 60%, #c086c0 100%);
            padding: 32px 36px 24px;
            text-align: center;
        }

        .pp-header img {
            max-width: 64px;
            border-radius: 10px;
            margin-bottom: 14px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .pp-header h1 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
        }

        .pp-header p {
            margin: 6px 0 0;
            font-size: .9rem;
            color: rgba(255,255,255,.82);
        }

        .pp-body {
            padding: 32px 36px 36px;
        }

        .pp-summary {
            background: #f9f7ff;
            border: 1px solid #e4ddf5;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 24px;
            font-size: .9rem;
            color: #444;
        }

        .pp-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #ede8f7;
        }

        .pp-summary-row:last-child { border-bottom: none; }

        .pp-summary-row .label {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #999;
        }

        .pp-summary-row .value {
            font-weight: 600;
            color: #2d2d2d;
        }

        .pp-card-wrap {
            border: 1px solid #d1c4e9;
            border-radius: 8px;
            padding: 12px 14px;
            background: #faf9ff;
            margin-bottom: 6px;
            transition: border-color .2s;
        }

        .pp-card-wrap.StripeElement--focus {
            border-color: #6f54a4;
            box-shadow: 0 0 0 3px rgba(111,84,164,.12);
        }

        .pp-card-wrap.StripeElement--invalid {
            border-color: #e53e3e;
        }

        .pp-stripe-error {
            color: #e53e3e;
            font-size: .78rem;
            margin-bottom: 12px;
            min-height: 18px;
        }

        .pp-general-error {
            color: #e53e3e;
            font-size: .82rem;
            margin-bottom: 12px;
            min-height: 18px;
        }

        .pp-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6f54a4, #c086c0);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s;
            margin-top: 8px;
        }

        .pp-btn:disabled { opacity: .6; cursor: not-allowed; }

        .pp-success {
            text-align: center;
            padding: 16px 0 8px;
        }

        .pp-success-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .pp-success-icon svg {
            width: 28px;
            height: 28px;
            stroke: #2e7d32;
        }

        .pp-success h2 {
            font-size: 1.2rem;
            font-weight: 800;
            color: #2d2d2d;
            margin: 0 0 10px;
        }

        .pp-success p {
            font-size: .9rem;
            color: #666;
            line-height: 1.6;
            margin: 0 0 20px;
        }

        .pp-login-btn {
            display: inline-block;
            padding: 12px 28px;
            background: #6f54a4;
            color: #fff;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: .95rem;
        }

        .pp-already {
            text-align: center;
            padding: 8px 0;
        }

        .pp-already h2 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #2d2d2d;
            margin: 0 0 10px;
        }

        .pp-already p {
            font-size: .9rem;
            color: #666;
            line-height: 1.6;
            margin: 0 0 20px;
        }
    </style>
</head>

<body>

    @include('includes.header')

    <div class="pp-page">
        <div class="pp-card">

            <div class="pp-header">
                <img src="/images/logo.jpg" alt="Sicher Bitcoin Verwahren">
                <h1>
                    @if($user->preferred_language === 'en')
                        Complete Your Payment
                    @else
                        Zahlung abschliessen
                    @endif
                </h1>
                <p>
                    @if($user->preferred_language === 'en')
                        On-Site Service – {{ $user->selected_package }}
                    @else
                        Vor-Ort-Service – {{ $user->selected_package }}
                    @endif
                </p>
            </div>

            <div class="pp-body">

                @if($alreadyPaid)

                    {{-- Already paid state --}}
                    <div class="pp-already">
                        <div class="pp-success-icon" style="background:#e8f5e9;margin:0 auto 16px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <h2>
                            @if($user->preferred_language === 'en')
                                Payment already completed
                            @else
                                Zahlung bereits abgeschlossen
                            @endif
                        </h2>
                        <p>
                            @if($user->preferred_language === 'en')
                                Your account is active. You can log in to your dashboard now.
                            @else
                                Ihr Konto ist bereits aktiv. Sie können sich jetzt in Ihr Dashboard einloggen.
                            @endif
                        </p>
                        <a href="{{ url('/login') }}" class="pp-login-btn">
                            @if($user->preferred_language === 'en') Log In @else Einloggen @endif
                        </a>
                    </div>

                @else

                    {{-- Payment form --}}
                    <div id="pp-form-wrap">

                        {{-- Order summary --}}
                        <div class="pp-summary">
                            <div class="pp-summary-row">
                                <span class="label">
                                    @if($user->preferred_language === 'en') Name @else Name @endif
                                </span>
                                <span class="value">{{ $user->name }}</span>
                            </div>
                            <div class="pp-summary-row">
                                <span class="label">
                                    @if($user->preferred_language === 'en') Package @else Paket @endif
                                </span>
                                <span class="value">{{ $user->selected_package }}</span>
                            </div>
                            @if($option || !empty($amountChf))
                            <div class="pp-summary-row">
                                <span class="label">
                                    @if($user->preferred_language === 'en') Amount @else Betrag @endif
                                </span>
                                <span class="value" style="color:#6f54a4;font-size:1rem;">
                                    CHF {{ number_format((float) ($amountChf ?? $option?->price_chf ?? 0), 0, '.', "'") }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <label style="font-size:.82rem;font-weight:700;color:#555;display:block;margin-bottom:6px;">
                            @if($user->preferred_language === 'en') Card Details * @else Kartendetails * @endif
                        </label>
                        <div class="pp-card-wrap" id="pp-card-element"></div>
                        <div class="pp-stripe-error" id="pp-stripe-error"></div>
                        <div class="pp-general-error" id="pp-general-error"></div>

                        <button class="pp-btn" id="pp-pay-btn" onclick="handlePayment()">
                            @if($user->preferred_language === 'en')
                                Pay Now &amp; Activate Access
                            @else
                                Jetzt sicher bezahlen
                            @endif
                        </button>

                        <p style="font-size:.72rem;color:#aaa;text-align:center;margin-top:12px;">
                            @if($user->preferred_language === 'en')
                                🔒 Secure payment via Stripe
                            @else
                                🔒 Sichere Zahlung via Stripe
                            @endif
                        </p>
                    </div>

                    {{-- Success state (shown after payment) --}}
                    <div class="pp-success" id="pp-success" style="display:none;">
                        <div class="pp-success-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <h2>
                            @if($user->preferred_language === 'en')
                                Payment successful!
                            @else
                                Zahlung erfolgreich!
                            @endif
                        </h2>
                        <p>
                            @if($user->preferred_language === 'en')
                                Your account is now active. You can log in to your dashboard.
                            @else
                                Ihr Konto ist jetzt aktiv. Sie können sich in Ihr Dashboard einloggen.
                            @endif
                        </p>
                        <a href="{{ url('/login') }}" class="pp-login-btn">
                            @if($user->preferred_language === 'en') Go to Login @else Zum Login @endif
                        </a>
                    </div>

                @endif

            </div>
        </div>
    </div>

    @include('includes.footer')
    @include('includes.scripts')

    @if(! $alreadyPaid)
    <script>
    (function () {
        'use strict';

        const stripe     = Stripe('{{ $stripeKey }}');
        const elements   = stripe.elements();
        const cardElement = elements.create('card', {
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

        cardElement.mount('#pp-card-element');

        cardElement.on('change', function (event) {
            const el = document.getElementById('pp-stripe-error');
            if (el) el.textContent = event.error ? event.error.message : '';
        });

        window.handlePayment = async function () {
            const btn       = document.getElementById('pp-pay-btn');
            const stripeErr = document.getElementById('pp-stripe-error');
            const genErr    = document.getElementById('pp-general-error');

            stripeErr.textContent = '';
            genErr.textContent    = '';
            btn.disabled          = true;
            btn.textContent       = '{{ $user->preferred_language === "en" ? "Processing…" : "Wird verarbeitet…" }}';

            try {
                // Step 1: Create PaymentIntent on server
                const intentRes = await fetch('{{ route("onsite.pay.intent", $user->payment_token ?? "_") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const intentData = await intentRes.json();

                if (! intentRes.ok || ! intentData.client_secret) {
                    genErr.textContent = intentData.message || '{{ $user->preferred_language === "en" ? "Failed to initialise payment." : "Fehler beim Initialisieren der Zahlung." }}';
                    btn.disabled  = false;
                    btn.textContent = '{{ $user->preferred_language === "en" ? "Pay Now & Activate Access" : "Jetzt sicher bezahlen" }}';
                    return;
                }

                // Step 2: Confirm card with Stripe.js
                const { paymentIntent, error } = await stripe.confirmCardPayment(
                    intentData.client_secret,
                    { payment_method: { card: cardElement, billing_details: { name: '{{ addslashes($user->name) }}' } } }
                );

                if (error) {
                    stripeErr.textContent = error.message;
                    btn.disabled  = false;
                    btn.textContent = '{{ $user->preferred_language === "en" ? "Pay Now & Activate Access" : "Jetzt sicher bezahlen" }}';
                    return;
                }

                if (paymentIntent.status !== 'succeeded') {
                    genErr.textContent = '{{ $user->preferred_language === "en" ? "Payment not completed. Please try again." : "Zahlung nicht abgeschlossen. Bitte erneut versuchen." }}';
                    btn.disabled  = false;
                    btn.textContent = '{{ $user->preferred_language === "en" ? "Pay Now & Activate Access" : "Jetzt sicher bezahlen" }}';
                    return;
                }

                // Step 3: Verify server-side and unlock account
                btn.textContent = '{{ $user->preferred_language === "en" ? "Activating account…" : "Konto wird aktiviert…" }}';

                const completeRes = await fetch('{{ route("onsite.pay.complete", $user->payment_token ?? "_") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ payment_intent_id: paymentIntent.id }),
                });

                const completeData = await completeRes.json();

                if (completeRes.ok && completeData.success) {
                    document.getElementById('pp-form-wrap').style.display = 'none';
                    document.getElementById('pp-success').style.display   = 'block';
                } else {
                    genErr.textContent = completeData.message || '{{ $user->preferred_language === "en" ? "An error occurred. Please contact support." : "Ein Fehler ist aufgetreten. Bitte kontaktieren Sie den Support." }}';
                    btn.disabled  = false;
                    btn.textContent = '{{ $user->preferred_language === "en" ? "Pay Now & Activate Access" : "Jetzt sicher bezahlen" }}';
                }

            } catch (err) {
                genErr.textContent = '{{ $user->preferred_language === "en" ? "Connection error. Please try again." : "Verbindungsfehler. Bitte erneut versuchen." }}';
                btn.disabled  = false;
                btn.textContent = '{{ $user->preferred_language === "en" ? "Pay Now & Activate Access" : "Jetzt sicher bezahlen" }}';
            }
        };
    })();
    </script>
    @endif

</body>
</html>