{{-- ── Lead Generation Modal ────────────────────────────────────────────────
     Include this partial in any page that uses openLeadModal().
     Call: openLeadModal('checklist') or openLeadModal('training')
───────────────────────────────────────────────────────────────────────────── --}}

@php
    $turnstileEnabled = filled(config('services.turnstile.site_key')) && filled(config('services.turnstile.secret'));
    $turnstileSiteKey = config('services.turnstile.site_key');
@endphp

@if($turnstileEnabled)
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endif

<div id="leadModal" style="display:none;position:fixed;inset:0;background:rgba(15,10,30,.7);z-index:99999;align-items:center;justify-content:center;padding:20px;" aria-modal="true" role="dialog" aria-labelledby="leadModalTitle">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:480px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.3);position:relative;">

        <button type="button" onclick="closeLeadModal()" aria-label="Schließen"
                style="position:absolute;top:16px;right:16px;background:rgba(111,84,164,.08);border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:1;">
            <svg style="width:16px;height:16px;fill:#6f54a4;" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
        </button>

        <div id="leadModalHeader" style="background:linear-gradient(135deg,#6f54a4,#c086c0);padding:32px 32px 28px;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:8px;">Kostenlos</div>
            <h3 id="leadModalTitle" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#fff;margin-bottom:8px;line-height:1.3;">Bitcoin Sicherheits-Selbsttest 2026</h3>
            <p id="leadModalDesc" style="font-size:14px;color:rgba(255,255,255,.8);line-height:1.5;">Geben Sie Ihre Daten ein und erhalten Sie den Selbsttest sofort per E-Mail.</p>
        </div>

        <div style="padding:28px 32px 32px;" id="leadFormWrap">
            <form id="leadForm" onsubmit="submitLead(event)" novalidate>
                @csrf
                <input type="hidden" name="source" id="leadSource" value="checklist">
                <input type="hidden" name="_form_opened_at" id="leadFormOpenedAt" value="">

                {{-- Honeypots (must stay empty) --}}
                <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                    <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    <label>Company URL <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label>
                </div>

                <div style="margin-bottom:16px;">
                    <label for="leadName" style="display:block;font-size:13px;font-weight:600;color:#3d3456;margin-bottom:6px;">Ihr Name *</label>
                    <input type="text" name="name" id="leadName" required maxlength="120"
                           placeholder="Max Mustermann" autocomplete="name"
                           style="width:100%;padding:11px 14px;border:1.5px solid #e4ddf0;border-radius:10px;font-size:14px;font-family:inherit;color:#1a1625;outline:none;transition:border-color .15s;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#6f54a4'" onblur="this.style.borderColor='#e4ddf0'">
                </div>
                <div style="margin-bottom:16px;">
                    <label for="leadEmail" style="display:block;font-size:13px;font-weight:600;color:#3d3456;margin-bottom:6px;">E-Mail-Adresse *</label>
                    <input type="email" name="email" id="leadEmail" required maxlength="255"
                           placeholder="max@beispiel.ch" autocomplete="email"
                           style="width:100%;padding:11px 14px;border:1.5px solid #e4ddf0;border-radius:10px;font-size:14px;font-family:inherit;color:#1a1625;outline:none;transition:border-color .15s;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#6f54a4'" onblur="this.style.borderColor='#e4ddf0'">
                </div>

                @if($turnstileEnabled)
                <div style="margin-bottom:16px;" class="cf-turnstile"
                     data-sitekey="{{ $turnstileSiteKey }}"
                     data-theme="light"></div>
                @endif

                <div id="leadError" role="alert" style="display:none;background:#fef2f2;color:#d94f4f;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;font-size:13.5px;margin-bottom:16px;"></div>

                <button type="submit" id="leadSubmitBtn"
                        style="width:100%;background:linear-gradient(135deg,#6f54a4,#c086c0);color:#fff;border:none;padding:14px;border-radius:100px;font-weight:700;font-size:15px;cursor:pointer;font-family:inherit;transition:opacity .2s;">
                    Jetzt kostenlosen Selbsttest herunterladen
                </button>

                <p style="font-size:11.5px;color:#a89fc0;text-align:center;margin-top:12px;">
                    Kein Spam. Nur nützliche Bitcoin-Sicherheitstipps.
                    <a href="/datenschutz" style="color:#6f54a4;" target="_blank" rel="noopener">Datenschutz</a>
                </p>
            </form>
        </div>

        <div id="leadSuccess" style="display:none;padding:40px 32px;text-align:center;">
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#6f54a4,#c086c0);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <svg style="width:28px;height:28px;fill:#fff;" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>
            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#1a1625;margin-bottom:10px;">Vielen Dank!</h3>
            <p style="font-size:15px;color:#7a728f;line-height:1.6;">Vielen Dank. Der Bitcoin Sicherheits-Selbsttest 2026 wurde an Ihre E-Mail-Adresse gesendet. Bitte prüfen Sie auch Ihren Spam-Ordner.</p>
            <button type="button" onclick="closeLeadModal()" style="margin-top:24px;background:#f4f2f9;color:#6f54a4;border:none;padding:12px 28px;border-radius:100px;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;">
                Schließen
            </button>
        </div>

    </div>
</div>

<script>
function openLeadModal(source) {
    source = source || 'checklist';
    document.getElementById('leadSource').value = source;
    document.getElementById('leadForm').reset();
    document.getElementById('leadSource').value = source;
    document.getElementById('leadFormOpenedAt').value = String(Math.floor(Date.now() / 1000));
    document.getElementById('leadError').style.display = 'none';
    document.getElementById('leadFormWrap').style.display = 'block';
    document.getElementById('leadSuccess').style.display = 'none';

    if (source === 'training') {
        document.getElementById('leadModalTitle').textContent = 'Bitcoin Self-Custody Digital Lernen';
        document.getElementById('leadModalDesc').textContent  = 'Erhalten Sie kostenlos Ihren Selbsttest und erfahren Sie mehr über unsere digitalen Videokurse.';
        document.getElementById('leadSubmitBtn').textContent  = 'Jetzt kostenlosen Selbsttest herunterladen';
        document.getElementById('leadModalHeader').style.background = 'linear-gradient(135deg,#2d1f4e,#6f54a4)';
    } else {
        document.getElementById('leadModalTitle').textContent = 'Bitcoin Sicherheits-Selbsttest 2026';
        document.getElementById('leadModalDesc').textContent  = 'Geben Sie Ihre Daten ein und erhalten Sie den Selbsttest sofort per E-Mail.';
        document.getElementById('leadSubmitBtn').textContent  = 'Jetzt kostenlosen Selbsttest herunterladen';
        document.getElementById('leadModalHeader').style.background = 'linear-gradient(135deg,#6f54a4,#c086c0)';
    }

    if (window.turnstile) {
        try { window.turnstile.reset(); } catch (e) {}
    }

    document.getElementById('leadModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLeadModal() {
    document.getElementById('leadModal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('leadModal').addEventListener('click', function(e) {
    if (e.target === this) closeLeadModal();
});

function isClientEmailValid(email) {
    email = (email || '').trim().toLowerCase();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) return false;
    var domain = email.split('@')[1] || '';
    if (domain.indexOf('.') === -1) return false; // blocks test@test
    return true;
}

async function submitLead(e) {
    e.preventDefault();
    const btn = document.getElementById('leadSubmitBtn');
    const errBox = document.getElementById('leadError');
    errBox.style.display = 'none';

    const email = document.getElementById('leadEmail').value;
    const name  = document.getElementById('leadName').value.trim();

    if (name.length < 2) {
        errBox.textContent = 'Bitte geben Sie Ihren Namen ein.';
        errBox.style.display = 'block';
        return;
    }
    if (!isClientEmailValid(email)) {
        errBox.textContent = 'Bitte geben Sie eine gültige E-Mail-Adresse ein (z. B. name@beispiel.ch).';
        errBox.style.display = 'block';
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Wird gesendet…';

    if (!document.getElementById('leadFormOpenedAt').value) {
        document.getElementById('leadFormOpenedAt').value = String(Math.floor(Date.now() / 1000));
    }

    const formData = new FormData(e.target);

    try {
        const resp = await fetch('{{ route("lead.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name=_token]') ? document.querySelector('[name=_token]').value : '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        });
        const data = await resp.json();

        if (resp.ok && data.success) {
            document.getElementById('leadFormWrap').style.display = 'none';
            document.getElementById('leadSuccess').style.display = 'block';
        } else {
            throw new Error(data.message || (data.errors && Object.values(data.errors).flat()[0]) || 'Server error');
        }
    } catch (err) {
        errBox.textContent = err.message || 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.';
        errBox.style.display = 'block';
        btn.disabled = false;
        btn.textContent = 'Jetzt kostenlosen Selbsttest herunterladen';
        if (window.turnstile) {
            try { window.turnstile.reset(); } catch (e) {}
        }
    }
}
</script>
