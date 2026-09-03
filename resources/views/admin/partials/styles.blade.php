<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --primary:        #6f54a4;
        --primary-light:  #8b6fc2;
        --primary-dark:   #5a4389;
        --secondary:      #c086c0;
        --bg:             #f4f2f9;
        --surface:        #ffffff;
        --surface-2:      #faf8fd;
        --border:         #e4dff0;
        --border-light:   #ede9f5;
        --text:           #1a1625;
        --text-2:         #3d3456;
        --muted:          #7a728f;
        --muted-light:    #a89fc0;
        --success:        #2e9e6b;
        --success-bg:     #edfaf4;
        --error:          #d94f4f;
        --error-bg:       #fef2f2;
        --sidebar-width:  256px;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
        display: flex;
    }

    /* ── Sidebar ── */
    .adm-sidebar {
        width: var(--sidebar-width);
        min-height: 100vh;
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        position: fixed;
        left: 0; top: 0; bottom: 0;
        z-index: 100;
    }
    .adm-sidebar__brand {
        display: flex; align-items: center; gap: 12px;
        padding: 22px 20px;
        border-bottom: 1px solid var(--border-light);
    }
    .adm-sidebar__logo {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(111,84,164,.25);
    }
    .adm-sidebar__logo svg { width: 20px; height: 20px; fill: white; }
    .adm-sidebar__brand-name {
        display: block; font-size: 13.5px; font-weight: 600;
        color: var(--text); letter-spacing: -.2px; line-height: 1.2;
    }
    .adm-sidebar__brand-sub {
        display: block; font-size: 11px; color: var(--muted);
        text-transform: uppercase; letter-spacing: .6px; font-weight: 500;
    }
    .adm-sidebar__nav { padding: 16px 12px; flex: 1; overflow-y: auto; }
    .adm-sidebar__section-label {
        font-size: 10.5px; font-weight: 600; text-transform: uppercase;
        letter-spacing: .8px; color: var(--muted-light);
        padding: 0 8px; margin-bottom: 8px;
    }
    .adm-sidebar__link {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 10px; border-radius: 8px;
        font-size: 13.5px; font-weight: 500; color: var(--muted);
        text-decoration: none; margin-bottom: 2px;
        transition: background .15s, color .15s;
        position: relative;
    }
    .adm-sidebar__link svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
    .adm-sidebar__link:hover { background: var(--bg); color: var(--primary); }
    .adm-sidebar__link--active {
        background: linear-gradient(135deg,rgba(111,84,164,.1),rgba(192,134,192,.08));
        color: var(--primary); font-weight: 600;
    }
    .adm-sidebar__link--active::before {
        content: ''; position: absolute; left: 0; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 20px;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
        border-radius: 0 3px 3px 0;
    }
    .adm-sidebar__link--soon { opacity: .55; pointer-events: none; }
    .adm-sidebar__badge {
        margin-left: auto; font-size: 10px; font-weight: 600;
        background: var(--border); color: var(--muted);
        padding: 2px 7px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: .4px;
    }
    .adm-sidebar__footer {
        padding: 14px 16px;
        border-top: 1px solid var(--border-light);
        display: flex; align-items: center; gap: 10px;
    }
    .adm-sidebar__user { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
    .adm-sidebar__avatar {
        width: 34px; height: 34px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;
    }
    .adm-sidebar__user-name {
        display: block; font-size: 13px; font-weight: 600; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .adm-sidebar__user-role { display: block; font-size: 11px; color: var(--muted); }
    .adm-sidebar__logout {
        width: 32px; height: 32px; background: transparent;
        border: 1px solid var(--border); border-radius: 8px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--muted); flex-shrink: 0;
        transition: background .15s, color .15s, border-color .15s;
    }
    .adm-sidebar__logout svg { width: 16px; height: 16px; fill: currentColor; }
    .adm-sidebar__logout:hover { background: #fef2f2; border-color: #fecaca; color: #d94f4f; }

    /* ── Main ── */
    .adm-layout { display: flex; flex: 1; width: 100%; min-height: 100vh; }
    .adm-main { margin-left: var(--sidebar-width); flex: 1; width: 100%; min-width: 0; min-height: 100vh; display: flex; flex-direction: column; }

    /* ── Topbar ── */
    .adm-topbar {
        background: var(--surface); border-bottom: 1px solid var(--border);
        padding: 0 28px; height: 60px;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 50;
    }
    .adm-topbar__breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13.5px; color: var(--muted); }
    .adm-topbar__breadcrumb span { color: var(--text); font-weight: 600; }
    .adm-topbar__breadcrumb svg { width: 14px; height: 14px; fill: var(--muted-light); }
    .adm-topbar__date {
        font-size: 12.5px; color: var(--muted);
        background: var(--bg); padding: 5px 12px;
        border-radius: 20px; border: 1px solid var(--border);
    }

    /* ── Content ── */
    .adm-content { padding: 28px; flex: 1; }
    .adm-page-header { margin-bottom: 24px; }
    .adm-page-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: 26px; font-weight: 400; color: var(--text); letter-spacing: -.4px;
    }
    .adm-page-header p { font-size: 13.5px; color: var(--muted); margin-top: 4px; }

    /* ── Alerts ── */
    .adm-alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 8px;
        font-size: 13.5px; margin-bottom: 20px;
    }
    .adm-alert svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
    .adm-alert--success { background: var(--success-bg); color: var(--success); border: 1px solid #b7efd8; }
    .adm-alert--error   { background: var(--error-bg);   color: var(--error);   border: 1px solid #fecaca; }

    /* ── Buttons ── */
    .adm-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: 8px;
        font-size: 13.5px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; text-decoration: none; border: none;
        transition: opacity .15s, transform .1s;
    }
    .adm-btn svg { width: 16px; height: 16px; fill: currentColor; }
    .adm-btn--primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(111,84,164,.25);
    }
    .adm-btn--primary:hover { opacity: .9; }
    .adm-btn--secondary {
        background: var(--surface); color: var(--text);
        border: 1px solid var(--border);
    }
    .adm-btn--secondary:hover { background: var(--bg); }
    .adm-btn--danger { background: #fef2f2; color: var(--error); border: 1px solid #fecaca; }
    .adm-btn--danger:hover { background: #fee2e2; }

    /* ── Table ── */
    .adm-section-block { margin-bottom: 32px; }
    .adm-section-heading {
        display: flex; align-items: center; gap: 10px;
        font-size: 15px; font-weight: 600; color: var(--text);
        margin-bottom: 12px;
    }
    .adm-table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 12px; overflow: hidden;
    }
    .adm-table { width: 100%; border-collapse: collapse; }
    .adm-table thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    .adm-table th {
        text-align: left; padding: 11px 16px;
        font-size: 11.5px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px; color: var(--muted);
    }
    .adm-table td {
        padding: 13px 16px; font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border-light); vertical-align: middle;
    }
    .adm-table tr:last-child td { border-bottom: none; }
    .adm-table tbody tr:hover td { background: var(--surface-2); }

    /* ── Category badge ── */
    .adm-category-badge {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .5px; padding: 3px 8px; border-radius: 20px;
    }
    .adm-category-badge--private  { background: rgba(111,84,164,.12); color: var(--primary); }
    .adm-category-badge--business { background: rgba(192,134,192,.15); color: #9b59b6; }

    /* ── Price tag ── */
    .adm-price-tag {
        display: inline-block; font-size: 12px; font-weight: 600;
        padding: 3px 9px; border-radius: 20px;
    }
    .adm-price-tag--digital { background: rgba(74,144,217,.1); color: #2d74be; }
    .adm-price-tag--onsite  { background: rgba(46,158,107,.1); color: #1d7a53; }

    /* ── Status toggle ── */
    .adm-status-toggle {
        display: inline-flex; align-items: center;
        font-size: 11.5px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
        border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: opacity .15s;
    }
    .adm-status-toggle:hover { opacity: .8; }
    .adm-status-toggle--active   { background: var(--success-bg); color: var(--success); }
    .adm-status-toggle--inactive { background: var(--error-bg);   color: var(--error); }

    /* ── Action buttons ── */
    .adm-actions { display: flex; align-items: center; gap: 6px; justify-content: flex-end; }
    .adm-action-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border); background: transparent;
        cursor: pointer; text-decoration: none;
        transition: background .15s, border-color .15s, color .15s;
    }
    .adm-action-btn svg { width: 14px; height: 14px; fill: currentColor; }
    .adm-action-btn--edit  { color: var(--primary); }
    .adm-action-btn--edit:hover  { background: rgba(111,84,164,.08); border-color: var(--primary); }
    .adm-action-btn--delete { color: var(--error); }
    .adm-action-btn--delete:hover { background: var(--error-bg); border-color: #fecaca; }

    /* ── Form card ── */
    .adm-form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 12px; padding: 28px;
        margin-bottom: 20px;
    }
    .adm-form-card__title {
        font-size: 15px; font-weight: 600; color: var(--text);
        margin-bottom: 20px; padding-bottom: 14px;
        border-bottom: 1px solid var(--border-light);
    }
    .adm-form-row { display: grid; gap: 16px; margin-bottom: 16px; }
    .adm-form-row--2 { grid-template-columns: 1fr 1fr; }
    .adm-form-row--3 { grid-template-columns: 1fr 1fr 1fr; }
    .adm-field label {
        display: block; font-size: 12.5px; font-weight: 500;
        color: var(--text); margin-bottom: 6px;
    }
    .adm-field input[type="text"],
    .adm-field input[type="number"],
    .adm-field select,
    .adm-field textarea {
        width: 100%; padding: 9px 12px;
        border: 1.5px solid var(--border); border-radius: 8px;
        font-size: 13.5px; font-family: 'DM Sans', sans-serif;
        color: var(--text); background: #fdfcff; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .adm-field input:focus,
    .adm-field select:focus,
    .adm-field textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(111,84,164,.1);
    }
    .adm-field--error input,
    .adm-field--error select { border-color: var(--error); }
    .adm-field__error { font-size: 12px; color: var(--error); margin-top: 4px; }

    .adm-checkbox-row { display: flex; align-items: center; gap: 8px; }
    .adm-checkbox-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--primary); cursor: pointer; }
    .adm-checkbox-row label { font-size: 13px; color: var(--text-2); cursor: pointer; }

    /* ── Option block in form ── */
    .adm-option-block {
        border: 1.5px solid var(--border); border-radius: 10px;
        padding: 20px; margin-bottom: 16px; position: relative;
    }
    .adm-option-block__header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px;
    }
    .adm-option-block__title { font-size: 13.5px; font-weight: 600; color: var(--text); }
    .adm-option-type-badge {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        padding: 2px 8px; border-radius: 20px; letter-spacing: .4px;
    }
    .adm-option-type-badge--digital { background: rgba(74,144,217,.1); color: #2d74be; }
    .adm-option-type-badge--onsite  { background: rgba(46,158,107,.1); color: #1d7a53; }

    /* ── Feature rows ── */
    .adm-feature-list { display: flex; flex-direction: column; gap: 8px; }
    .adm-feature-row {
        display: flex; align-items: center; gap: 8px;
    }
    .adm-feature-row input[type="text"] {
        flex: 1; padding: 7px 10px;
        border: 1.5px solid var(--border); border-radius: 7px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        color: var(--text); background: var(--surface-2); outline: none;
        transition: border-color .15s;
    }
    .adm-feature-row input[type="text"]:focus { border-color: var(--primary); }
    .adm-feature-row .adm-remove-btn {
        width: 28px; height: 28px; border: 1px solid var(--border);
        border-radius: 6px; background: transparent; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted); flex-shrink: 0;
        transition: background .15s, color .15s;
    }
    .adm-feature-row .adm-remove-btn:hover { background: var(--error-bg); color: var(--error); border-color: #fecaca; }
    .adm-feature-row .adm-remove-btn svg { width: 13px; height: 13px; fill: currentColor; }

    .adm-add-feature-btn {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 8px; font-size: 12.5px; font-weight: 500;
        color: var(--primary); background: none; border: none;
        cursor: pointer; padding: 0; font-family: 'DM Sans', sans-serif;
        transition: opacity .15s;
    }
    .adm-add-feature-btn:hover { opacity: .7; }
    .adm-add-feature-btn svg { width: 14px; height: 14px; fill: currentColor; }

    .adm-form-footer {
        display: flex; align-items: center; gap: 12px;
        padding-top: 20px; border-top: 1px solid var(--border-light);
    }
</style>