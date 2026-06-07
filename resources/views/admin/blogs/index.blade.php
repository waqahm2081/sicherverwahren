<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog verwalten — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .adm-filter-bar { display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap; }
        .adm-search-wrap { position:relative;flex:1;min-width:220px;max-width:340px; }
        .adm-search-wrap svg { position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;fill:var(--muted-light);pointer-events:none; }
        .adm-search-wrap input { width:100%;padding:8px 12px 8px 34px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s; }
        .adm-search-wrap input:focus { border-color:var(--primary);box-shadow:0 0 0 3px rgba(111,84,164,.1); }
        .adm-filter-select { padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text);background:var(--surface);outline:none;cursor:pointer; }
        .adm-filter-select:focus { border-color:var(--primary); }
        .adm-filter-btn { padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;font-family:'DM Sans',sans-serif;border:1.5px solid var(--border);background:var(--surface);color:var(--text);cursor:pointer;text-decoration:none;transition:background .15s; }
        .adm-filter-btn:hover { background:var(--bg); }
        .badge-published { display:inline-flex;align-items:center;gap:5px;background:var(--success-bg);color:var(--success);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px; }
        .badge-published::before { content:'';width:6px;height:6px;border-radius:50%;background:var(--success); }
        .badge-draft { display:inline-flex;align-items:center;gap:5px;background:#f1f0f5;color:var(--muted);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px; }
        .badge-draft::before { content:'';width:6px;height:6px;border-radius:50%;background:var(--muted-light); }
        .blog-thumb { width:48px;height:48px;border-radius:8px;object-fit:cover;border:1.5px solid var(--border-light); }
        .blog-thumb-placeholder { width:48px;height:48px;border-radius:8px;background:var(--bg);border:1.5px solid var(--border-light);display:flex;align-items:center;justify-content:center; }
        .blog-thumb-placeholder svg { width:20px;height:20px;fill:var(--muted-light); }
        td svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Blog verwalten'])
        <div class="adm-content">

            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Blog verwalten</h1>
                    <p>Blogbeiträge erstellen, bearbeiten und veröffentlichen.</p>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.blogs.categories') }}" class="adm-btn adm-btn--secondary">
                        <svg viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5S15.01 22 17.5 22s4.5-2.01 4.5-4.5S19.99 13 17.5 13zm0 7c-1.38 0-2.5-1.12-2.5-2.5S16.12 15 17.5 15s2.5 1.12 2.5 2.5S18.88 20 17.5 20zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/></svg>
                        Kategorien
                    </a>
                    <a href="{{ route('admin.blogs.create') }}" class="adm-btn adm-btn--primary">
                        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Neuer Beitrag
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.blogs.index') }}">
                <div class="adm-filter-bar">
                    <div class="adm-search-wrap">
                        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <input type="text" name="search" placeholder="Beitrag suchen…" value="{{ request('search') }}">
                    </div>
                    <select name="status" class="adm-filter-select">
                        <option value="">Alle Status</option>
                        <option value="published" @selected(request('status')==='published')>Veröffentlicht</option>
                        <option value="draft"     @selected(request('status')==='draft')>Entwurf</option>
                    </select>
                    <select name="category" class="adm-filter-select">
                        <option value="">Alle Kategorien</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="adm-btn adm-btn--primary" style="padding:8px 18px;">Filtern</button>
                    @if(request()->hasAny(['search','status','category']))
                        <a href="{{ route('admin.blogs.index') }}" class="adm-filter-btn">Zurücksetzen</a>
                    @endif
                </div>
            </form>

            <div class="adm-table-card">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width:64px;">Bild</th>
                            <th>Titel</th>
                            <th>Kategorie</th>
                            <th>Autor</th>
                            <th>Status</th>
                            <th>Datum</th>
                            <th style="width:110px;">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                        <tr>
                            <td>
                                @if($blog->featured_image)
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="" class="blog-thumb">
                                @else
                                    <div class="blog-thumb-placeholder">
                                        <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:600;color:var(--text);line-height:1.3;max-width:260px;">{{ $blog->title }}</div>
                                <div style="font-size:11.5px;color:var(--muted);margin-top:2px;">/blog/{{ $blog->slug }}</div>
                            </td>
                            <td>
                                @if($blog->category)
                                    <span style="background:rgba(111,84,164,.08);color:var(--primary);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px;">{{ $blog->category->name }}</span>
                                @else
                                    <span style="color:var(--muted-light);font-size:13px;">—</span>
                                @endif
                            </td>
                            <td style="font-size:13px;color:var(--muted);">{{ $blog->author }}</td>
                            <td>
                                @if($blog->isPublished())
                                    <span class="badge-published">Veröffentlicht</span>
                                @else
                                    <span class="badge-draft">Entwurf</span>
                                @endif
                            </td>
                            <td style="font-size:13px;color:var(--muted);">
                                {{ $blog->published_at ? $blog->published_at->format('d.m.Y') : '—' }}
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;align-items:center;">
                                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="adm-icon-btn adm-icon-btn--edit" title="Bearbeiten">
                                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}"
                                          data-confirm="true" data-confirm-name="{{ $blog->title }}" data-confirm-type="Beitrag">
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
                            <td colspan="7" style="text-align:center;padding:48px;color:var(--muted);">
                                <svg viewBox="0 0 24 24" style="width:40px;height:40px;fill:var(--border);display:block;margin:0 auto 12px;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                                Keine Blogbeiträge gefunden.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($blogs->hasPages())
                <div style="margin-top:20px;display:flex;justify-content:center;">
                    {{ $blogs->links() }}
                </div>
            @endif

        </div>
    </main>

    @include('admin.partials.delete-modal')
    <script>
    (function(){
        const backdrop=document.getElementById('deleteModal');
        const modalName=document.getElementById('modalName');
        const modalType=document.getElementById('modalType');
        let pendingForm=null;
        document.querySelectorAll('form[data-confirm]').forEach(form=>{
            form.addEventListener('submit',e=>{
                e.preventDefault();pendingForm=form;
                modalName.textContent=form.dataset.confirmName||'';
                modalType.textContent=form.dataset.confirmType?'den '+form.dataset.confirmType:'';
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
