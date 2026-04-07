{{-- ─── Delete Confirmation Modal ─────────────────────────────────────────────
     Usage: add these attributes to any delete <form>:
       data-confirm="true"
       data-confirm-name="Paketname"        (shown in modal body)
       data-confirm-type="Paket"            (e.g. "Benutzer", "Paket", "Bestellung")
─────────────────────────────────────────────────────────────────────────── --}}

<div id="deleteModal" class="adm-modal-backdrop" style="display:none;" aria-modal="true" role="dialog">
    <div class="adm-modal">
        <div class="adm-modal__icon-wrap">
            <div class="adm-modal__icon">
                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
            </div>
        </div>
        <div class="adm-modal__title">Löschen bestätigen</div>
        <div class="adm-modal__body">
            Möchten Sie <span class="adm-modal__type" id="modalType"></span>
            <strong id="modalName"></strong> wirklich dauerhaft löschen?
            <br><br>
            <span style="color:var(--error);font-weight:500;">Diese Aktion kann nicht rückgängig gemacht werden.</span>
        </div>
        <div class="adm-modal__actions">
            <button type="button" class="adm-modal__cancel" id="modalCancel">Abbrechen</button>
            <button type="button" class="adm-modal__confirm" id="modalConfirm">
                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                Endgültig löschen
            </button>
        </div>
    </div>
</div>

<style>
    .adm-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(10, 6, 20, 0.55);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: adm-backdrop-in .15s ease;
    }

    @keyframes adm-backdrop-in {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .adm-modal {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 32px 28px 28px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2), 0 4px 16px rgba(0,0,0,.1);
        text-align: center;
        animation: adm-modal-in .2s cubic-bezier(.34,1.56,.64,1);
        position: relative;
    }

    @keyframes adm-modal-in {
        from { transform: scale(.92) translateY(8px); opacity: 0; }
        to   { transform: scale(1)   translateY(0);   opacity: 1; }
    }

    .adm-modal__icon-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 18px;
    }

    .adm-modal__icon {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        display: flex; align-items: center; justify-content: center;
    }

    .adm-modal__icon svg {
        width: 24px; height: 24px;
        fill: var(--error);
    }

    .adm-modal__title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -.3px;
        margin-bottom: 10px;
    }

    .adm-modal__body {
        font-size: 14px;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .adm-modal__type {
        color: var(--text-2);
    }

    .adm-modal__actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .adm-modal__cancel {
        padding: 11px 16px;
        border-radius: 9px;
        border: 1.5px solid var(--border);
        background: var(--surface);
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        cursor: pointer;
        transition: background .15s;
    }
    .adm-modal__cancel:hover { background: var(--bg); }

    .adm-modal__confirm {
        padding: 11px 16px;
        border-radius: 9px;
        border: none;
        background: var(--error);
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: opacity .15s, transform .1s;
        box-shadow: 0 2px 8px rgba(217,79,79,.3);
    }
    .adm-modal__confirm svg { width: 15px; height: 15px; fill: white; }
    .adm-modal__confirm:hover  { opacity: .9; }
    .adm-modal__confirm:active { transform: scale(.98); }
</style>

<script>
(function () {
    let pendingForm = null;

    const modal   = document.getElementById('deleteModal');
    const nameEl  = document.getElementById('modalName');
    const typeEl  = document.getElementById('modalType');
    const confirm = document.getElementById('modalConfirm');
    const cancel  = document.getElementById('modalCancel');

    // Intercept all forms with data-confirm="true"
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.dataset.confirm !== 'true') return;

        e.preventDefault();
        pendingForm = form;

        typeEl.textContent = 'den ' + (form.dataset.confirmType || 'Eintrag');
        nameEl.textContent = form.dataset.confirmName || '';

        modal.style.display = 'flex';
        // Focus the cancel button by default (safer UX)
        document.getElementById('modalCancel').focus();
    });

    // Confirm → submit the stored form
    confirm.addEventListener('click', function () {
        modal.style.display = 'none';
        if (pendingForm) {
            // Temporarily remove our listener so it doesn't loop
            const clone = pendingForm;
            pendingForm = null;
            clone.removeAttribute('data-confirm');
            clone.submit();
        }
    });

    // Cancel → close modal
    function closeModal() {
        modal.style.display = 'none';
        pendingForm = null;
    }

    cancel.addEventListener('click', closeModal);

    // Close on backdrop click
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
    });
})();
</script>