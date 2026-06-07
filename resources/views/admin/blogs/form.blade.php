<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($blog) ? 'Beitrag bearbeiten' : 'Neuer Beitrag' }} — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .blog-form-grid { display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start; }
        .img-preview-wrap { position:relative;width:100%;aspect-ratio:16/9;border-radius:10px;overflow:hidden;background:var(--bg);border:2px dashed var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color .2s; }
        .img-preview-wrap:hover { border-color:var(--primary); }
        .img-preview-wrap img { position:absolute;inset:0;width:100%;height:100%;object-fit:cover; }
        .img-preview-placeholder { display:flex;flex-direction:column;align-items:center;gap:8px;color:var(--muted);font-size:13px; }
        .img-preview-placeholder svg { width:36px;height:36px;fill:var(--muted-light); }
        .adm-sidebar-card { background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:16px; }
        .adm-sidebar-card__title { font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);margin-bottom:16px; }
        .tags-input-wrap { display:flex;flex-wrap:wrap;gap:6px;padding:8px 10px;border:1.5px solid var(--border);border-radius:8px;min-height:42px;cursor:text;transition:border-color .15s; }
        .tags-input-wrap:focus-within { border-color:var(--primary);box-shadow:0 0 0 3px rgba(111,84,164,.1); }
        .tag-chip { display:inline-flex;align-items:center;gap:4px;background:rgba(111,84,164,.1);color:var(--primary);font-size:12px;font-weight:600;padding:2px 8px;border-radius:20px; }
        .tag-chip button { background:none;border:none;color:var(--primary);cursor:pointer;padding:0;line-height:1;font-size:14px; }
        .tags-real-input { border:none;outline:none;font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--text);flex:1;min-width:80px;padding:2px 4px;background:transparent; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => isset($blog) ? 'Beitrag bearbeiten' : 'Neuer Beitrag'])
        <div class="adm-content">

            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>{{ isset($blog) ? 'Beitrag bearbeiten' : 'Neuen Beitrag erstellen' }}</h1>
                    <p>{{ isset($blog) ? 'Änderungen an „'.$blog->title.'" vornehmen.' : 'Einen neuen Blogbeitrag anlegen.' }}</p>
                </div>
                <a href="{{ route('admin.blogs.index') }}" class="adm-btn adm-btn--secondary">
                    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Zurück
                </a>
            </div>

            @if($errors->any())
                <div class="adm-alert adm-alert--error" style="margin-bottom:20px;">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Bitte korrigieren Sie die markierten Felder.
                </div>
            @endif

            <form method="POST"
                  action="{{ isset($blog) ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
                  enctype="multipart/form-data" id="blogForm">
                @csrf
                @if(isset($blog)) @method('PUT') @endif

                <div class="blog-form-grid">

                    {{-- ── LEFT COLUMN ── --}}
                    <div>
                        {{-- Title --}}
                        <div class="adm-form-card" style="margin-bottom:16px;">
                            <div class="adm-form-card__title">Beitragsinformationen</div>
                            <div class="adm-field {{ $errors->has('title') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                                <label for="title">Titel *</label>
                                <input type="text" id="title" name="title"
                                       value="{{ old('title', $blog->title ?? '') }}"
                                       placeholder="Beitragstitel eingeben…" required
                                       oninput="autoSlug(this.value)">
                                @error('title') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                            <div class="adm-field {{ $errors->has('slug') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                                <label for="slug">URL-Slug <span style="color:var(--muted);font-weight:400;">(wird automatisch generiert)</span></label>
                                <div style="display:flex;align-items:center;gap:0;">
                                    <span style="padding:9px 12px;background:var(--bg);border:1.5px solid var(--border);border-right:none;border-radius:8px 0 0 8px;font-size:13px;color:var(--muted);">/blog/</span>
                                    <input type="text" id="slug" name="slug"
                                           value="{{ old('slug', $blog->slug ?? '') }}"
                                           placeholder="url-slug"
                                           style="border-radius:0 8px 8px 0;flex:1;">
                                </div>
                                @error('slug') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                            <div class="adm-field {{ $errors->has('excerpt') ? 'adm-field--error' : '' }}">
                                <label for="excerpt">Kurzbeschreibung <span style="color:var(--muted);font-weight:400;">(max. 500 Zeichen)</span></label>
                                <textarea id="excerpt" name="excerpt" rows="2"
                                          placeholder="Kurze Zusammenfassung des Beitrags…"
                                          maxlength="500">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
                                @error('excerpt') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="adm-form-card" style="margin-bottom:16px;">
                            <div class="adm-form-card__title">Inhalt *</div>
                            <div class="adm-field {{ $errors->has('content') ? 'adm-field--error' : '' }}">
                                <textarea id="content" name="content">{{ old('content', $blog->content ?? '') }}</textarea>
                                @error('content') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- SEO --}}
                        <div class="adm-form-card">
                            <div class="adm-form-card__title">SEO</div>
                            <div class="adm-field {{ $errors->has('meta_title') ? 'adm-field--error' : '' }}" style="margin-bottom:16px;">
                                <label for="meta_title">SEO-Titel</label>
                                <input type="text" id="meta_title" name="meta_title"
                                       value="{{ old('meta_title', $blog->meta_title ?? '') }}"
                                       placeholder="SEO-optimierter Titel (max. 60 Zeichen)" maxlength="255">
                                @error('meta_title') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                            <div class="adm-field {{ $errors->has('meta_description') ? 'adm-field--error' : '' }}">
                                <label for="meta_description">Meta-Beschreibung</label>
                                <textarea id="meta_description" name="meta_description" rows="2"
                                          placeholder="Meta-Beschreibung für Suchmaschinen (max. 160 Zeichen)"
                                          maxlength="500">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                                @error('meta_description') <div class="adm-field__error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── RIGHT COLUMN ── --}}
                    <div>
                        {{-- Publish --}}
                        <div class="adm-sidebar-card">
                            <div class="adm-sidebar-card__title">Veröffentlichung</div>
                            <div class="adm-field" style="margin-bottom:16px;">
                                <label for="status">Status *</label>
                                <select id="status" name="status" required>
                                    <option value="draft"     @selected(old('status', $blog->status ?? 'draft') === 'draft')>Entwurf</option>
                                    <option value="published" @selected(old('status', $blog->status ?? '') === 'published')>Veröffentlicht</option>
                                </select>
                            </div>
                            <div class="adm-field" style="margin-bottom:16px;">
                                <label for="author">Autor</label>
                                <input type="text" id="author" name="author"
                                       value="{{ old('author', $blog->author ?? 'Sicher Bitcoin Verwahren') }}"
                                       placeholder="Autorname">
                            </div>
                            <div class="adm-field">
                                <label for="blog_category_id">Kategorie</label>
                                <select id="blog_category_id" name="blog_category_id">
                                    <option value="">— Keine —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            @selected(old('blog_category_id', $blog->blog_category_id ?? '') == $cat->id)>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Featured Image --}}
                        <div class="adm-sidebar-card">
                            <div class="adm-sidebar-card__title">Beitragsbild</div>
                            <div class="img-preview-wrap" id="imgPreviewWrap" onclick="document.getElementById('featured_image').click()">
                                @if(isset($blog) && $blog->featured_image)
                                    <img id="imgPreview" src="{{ asset('storage/' . $blog->featured_image) }}" alt="">
                                @else
                                    <div class="img-preview-placeholder" id="imgPlaceholder">
                                        <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                        <span>Bild auswählen</span>
                                        <span style="font-size:11.5px;color:var(--muted-light);">JPG, PNG, WebP · max. 4 MB</span>
                                    </div>
                                    <img id="imgPreview" src="" alt="" style="display:none;">
                                @endif
                            </div>
                            <input type="file" id="featured_image" name="featured_image"
                                   accept="image/*" style="display:none;" onchange="previewImage(this)">
                        </div>

                        {{-- Tags --}}
                        <div class="adm-sidebar-card">
                            <div class="adm-sidebar-card__title">Tags</div>
                            <div class="tags-input-wrap" id="tagsWrap" onclick="document.getElementById('tagInput').focus()">
                                @php $existingTags = old('tags', isset($blog) ? ($blog->tags_list ?? '') : ''); @endphp
                            </div>
                            <input type="hidden" name="tags" id="tagsHidden" value="{{ $existingTags }}">
                            <div style="margin-top:8px;">
                                <input type="text" id="tagInput" placeholder="Tag eingeben + Enter"
                                       class="tags-real-input"
                                       style="width:100%;padding:8px 10px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                            </div>
                            <p style="font-size:11.5px;color:var(--muted-light);margin-top:8px;">Komma oder Enter zum Trennen</p>
                        </div>

                        {{-- Save buttons --}}
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <button type="submit" class="adm-btn adm-btn--primary" style="width:100%;justify-content:center;">
                                <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                                {{ isset($blog) ? 'Änderungen speichern' : 'Beitrag erstellen' }}
                            </button>
                            <a href="{{ route('admin.blogs.index') }}" class="adm-btn adm-btn--secondary" style="width:100%;justify-content:center;">
                                Abbrechen
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/4fmukhyqux038xawpcj4y4ppeod2esv9ep4ord5vkfva04ba/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: '#content',
        height: 520,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        content_style: 'body { font-family: DM Sans, Arial, sans-serif; font-size: 15px; color: #1a1625; line-height: 1.7; }',
        images_upload_handler: (blobInfo) => new Promise((resolve) => {
            // Simple base64 inline – swap for server upload if needed
            resolve('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        }),
    });

    // Slug auto-generation
    function slugify(str) {
        return str.toLowerCase().trim()
            .replace(/[äöüÄÖÜ]/g, c => ({'ä':'ae','ö':'oe','ü':'ue','Ä':'ae','Ö':'oe','Ü':'ue'}[c]))
            .replace(/ß/g,'ss')
            .replace(/[^a-z0-9\s-]/g,'')
            .replace(/\s+/g,'-')
            .replace(/-+/g,'-');
    }
    const slugField = document.getElementById('slug');
    let slugManuallyEdited = slugField.value !== '';
    function autoSlug(val) {
        if (!slugManuallyEdited) slugField.value = slugify(val);
    }
    slugField.addEventListener('input', () => { slugManuallyEdited = true; });

    // Image preview
    function previewImage(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.style.display = 'block';
            const ph = document.getElementById('imgPlaceholder');
            if (ph) ph.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }

    // Tags UI
    (function() {
        const wrap   = document.getElementById('tagsWrap');
        const hidden = document.getElementById('tagsHidden');
        const input  = document.getElementById('tagInput');
        let tags = hidden.value ? hidden.value.split(',').map(t=>t.trim()).filter(Boolean) : [];

        function render() {
            wrap.querySelectorAll('.tag-chip').forEach(c => c.remove());
            tags.forEach((tag, i) => {
                const chip = document.createElement('span');
                chip.className = 'tag-chip';
                chip.innerHTML = tag + '<button type="button" onclick="removeTag('+i+')">×</button>';
                wrap.insertBefore(chip, null);
            });
            hidden.value = tags.join(', ');
        }

        window.removeTag = function(i) { tags.splice(i, 1); render(); };

        function addTag(val) {
            val = val.trim();
            if (val && !tags.includes(val)) { tags.push(val); render(); }
            input.value = '';
        }

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ',') { e.preventDefault(); addTag(input.value); }
            if (e.key === 'Backspace' && input.value === '' && tags.length) { tags.pop(); render(); }
        });
        input.addEventListener('blur', () => { if (input.value.trim()) addTag(input.value); });

        render();
    })();
    </script>
</body>
</html>
