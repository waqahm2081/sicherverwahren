<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog-Kategorien — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .cat-grid { display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start; }
        @media(max-width:900px){ .cat-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Blog-Kategorien'])
        <div class="adm-content">

            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Blog-Kategorien</h1>
                    <p>Kategorien erstellen und verwalten.</p>
                </div>
                <a href="{{ route('admin.blogs.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zum Blog
                </a>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="cat-grid">

                {{-- Category List --}}
                <div class="adm-table-card">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Beiträge</th>
                                <th>Status</th>
                                <th style="width:110px;">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--text);">{{ $cat->name }}</div>
                                    @if($cat->description)
                                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">{{ Str::limit($cat->description, 60) }}</div>
                                    @endif
                                </td>
                                <td style="font-size:12.5px;color:var(--muted);">{{ $cat->slug }}</td>
                                <td>
                                    <span style="background:rgba(111,84,164,.08);color:var(--primary);font-size:12px;font-weight:600;padding:3px 9px;border-radius:20px;">
                                        {{ $cat->blogs_count }}
                                    </span>
                                </td>
                                <td>
                                    @if($cat->is_active)
                                        <span style="background:var(--success-bg);color:var(--success);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px;">Aktiv</span>
                                    @else
                                        <span style="background:#f1f0f5;color:var(--muted);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px;">Inaktiv</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <button type="button" class="adm-icon-btn adm-icon-btn--edit" title="Bearbeiten"
                                                onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->slug }}', '{{ addslashes($cat->description ?? '') }}', {{ $cat->is_active ? 'true' : 'false' }})">
                                            <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.blogs.category.destroy', $cat) }}"
                                              data-confirm="true" data-confirm-name="{{ $cat->name }}" data-confirm-type="Kategorie">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="adm-icon-btn adm-icon-btn--delete" title="Löschen">
                                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:40px;color:var(--muted);">
                                    Noch keine Kategorien angelegt.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Create Form --}}
                <div class="adm-form-card">
                    <div class="adm-form-card__title">Neue Kategorie</div>
                    <form method="POST" action="{{ route('admin.blogs.category.store') }}">
                        @csrf
                        <div class="adm-field {{ $errors->has('name') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   placeholder="z.B. Sicherheit" required>
                            @error('name') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                        <div class="adm-field {{ $errors->has('slug') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                            <label for="cat_slug">Slug <span style="color:var(--muted);font-weight:400;">(optional)</span></label>
                            <input type="text" id="cat_slug" name="slug" value="{{ old('slug') }}"
                                   placeholder="wird automatisch generiert">
                            @error('slug') <div class="adm-field__error">{{ $message }}</div> @enderror
                        </div>
                        <div class="adm-field" style="margin-bottom:16px;">
                            <label for="description">Beschreibung</label>
                            <textarea id="description" name="description" rows="2"
                                      placeholder="Kurze Beschreibung…">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="adm-btn adm-btn--primary" style="width:100%;justify-content:center;">
                            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            Kategorie erstellen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    {{-- Edit Modal --}}
    <div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:var(--surface);border-radius:16px;padding:28px;width:100%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,.2);">
            <h3 style="font-family:'DM Serif Display',serif;font-size:20px;margin-bottom:20px;">Kategorie bearbeiten</h3>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="adm-field" style="margin-bottom:14px;">
                    <label>Name *</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="adm-field" style="margin-bottom:14px;">
                    <label>Slug</label>
                    <input type="text" name="slug" id="editSlug">
                </div>
                <div class="adm-field" style="margin-bottom:14px;">
                    <label>Beschreibung</label>
                    <textarea name="description" id="editDesc" rows="2"></textarea>
                </div>
                <div class="adm-field" style="margin-bottom:20px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" name="is_active" id="editActive" value="1" style="width:16px;height:16px;">
                        Aktiv
                    </label>
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="adm-btn adm-btn--primary" style="flex:1;justify-content:center;">Speichern</button>
                    <button type="button" onclick="document.getElementById('editModal').style.display='none'"
                            class="adm-btn adm-btn--secondary" style="flex:1;justify-content:center;">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.partials.delete-modal')
    <script>
    function openEditModal(id, name, slug, desc, isActive) {
        const baseUrl = '{{ url("admin/blogs/categories") }}';
        document.getElementById('editForm').action = baseUrl + '/' + id;
        document.getElementById('editName').value   = name;
        document.getElementById('editSlug').value   = slug;
        document.getElementById('editDesc').value   = desc;
        document.getElementById('editActive').checked = isActive;
        document.getElementById('editModal').style.display = 'flex';
    }
    (function(){
        const backdrop=document.getElementById('deleteModal');
        const modalName=document.getElementById('modalName');
        const modalType=document.getElementById('modalType');
        let pendingForm=null;
        document.querySelectorAll('form[data-confirm]').forEach(form=>{
            form.addEventListener('submit',e=>{
                e.preventDefault();pendingForm=form;
                modalName.textContent=form.dataset.confirmName||'';
                modalType.textContent=form.dataset.confirmType?'die '+form.dataset.confirmType:'';
                backdrop.style.display='flex';
            });
        });
        document.getElementById('modalCancel').addEventListener('click',()=>{backdrop.style.display='none';pendingForm=null;});
        document.getElementById('modalConfirm').addEventListener('click',()=>{if(pendingForm)pendingForm.submit();});
        backdrop.addEventListener('click',e=>{if(e.target===backdrop){backdrop.style.display='none';pendingForm=null;}});
    })();
    </script>
</body>
</html>
