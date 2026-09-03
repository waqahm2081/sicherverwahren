<!DOCTYPE html>
<html lang="de" class="blog-page">
<head>
    <title>Blog – Bitcoin Sicherheit & Self-Custody | Sicher Bitcoin Verwahren</title>
    <meta name="description" content="Aktuelle Artikel zu Bitcoin Self-Custody, Hardware Wallets, Sicherheitsstrategien und Multisig für Privatpersonen und Unternehmen in der Schweiz.">
    @include('includes.styles')

    {{-- Canonical & OG --}}
    <link rel="canonical" href="{{ url('/blog') }}">
    <meta property="og:title"       content="Blog – Sicher Bitcoin Verwahren">
    <meta property="og:description" content="Aktuelle Artikel zu Bitcoin Self-Custody, Hardware Wallets und Sicherheitsstrategien.">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="{{ url('/blog') }}">
    <meta name="twitter:card"       content="summary_large_image">
    <meta name="twitter:title"      content="Blog – Sicher Bitcoin Verwahren">
    <meta name="twitter:description" content="Aktuelle Artikel zu Bitcoin Self-Custody, Hardware Wallets und Sicherheitsstrategien.">

    <style>
        /* ── Blog Index ── */
        .blog-hero { background: linear-gradient(135deg, #1a1625 0%, #2d1f4e 100%); padding: 80px 0 60px; margin-top: 0; }
        .blog-hero h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 48px; font-weight: 800; color: #fff; margin-bottom: 16px; }
        .blog-hero p { font-size: 18px; color: rgba(255,255,255,.7); max-width: 540px; }

        .blog-section { padding: 60px 0 80px; }

        .blog-cat-filter { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
        .blog-cat-btn { padding: 8px 18px; border-radius: 100px; font-size: 13.5px; font-weight: 600; border: 1.5px solid #e4ddf0; background: #fff; color: #3d3456; text-decoration: none; transition: all .2s; }
        .blog-cat-btn:hover, .blog-cat-btn.active { background: #6f54a4; border-color: #6f54a4; color: #fff; }

        .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        @media(max-width:992px){ .blog-grid { grid-template-columns: repeat(2,1fr); } }
        @media(max-width:640px){ .blog-grid { grid-template-columns: 1fr; } }

        .blog-card { background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #ede9f5; box-shadow: 0 2px 12px rgba(111,84,164,.06); transition: transform .25s, box-shadow .25s; display: flex; flex-direction: column; }
        .blog-card:hover { transform: translateY(-4px); box-shadow: 0 10px 32px rgba(111,84,164,.14); }
        .blog-card__img { aspect-ratio: 16/9; overflow: hidden; background: #f4f2f9; }
        .blog-card__img img { width: 100%; height: 100%; transition: transform .4s; }
        .blog-card:hover .blog-card__img img { transform: scale(1.05); }
        .blog-card__img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
        .blog-card__img-placeholder svg { width: 48px; height: 48px; fill: #c8bde0; }
        .blog-card__body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .blog-card__cat { display: inline-block; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #6f54a4; background: rgba(111,84,164,.08); padding: 3px 10px; border-radius: 20px; margin-bottom: 12px; text-decoration: none; }
        .blog-card__title { font-size: 17px; font-weight: 700; color: #1a1625; line-height: 1.35; margin-bottom: 10px; text-decoration: none; display: block; }
        .blog-card__title:hover { color: #6f54a4; }
        .blog-card__excerpt { font-size: 14px; color: #7a728f; line-height: 1.6; flex: 1; margin-bottom: 16px; }
        .blog-card__meta { display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; color: #a89fc0; border-top: 1px solid #f0ecf8; padding-top: 14px; }
        .blog-card__meta span { display: flex; align-items: center; gap: 5px; }
        .blog-card__meta svg { width: 14px; height: 14px; fill: #c8bde0; }
        .blog-card__read-more { font-size: 13px; font-weight: 700; color: #6f54a4; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .blog-card__read-more svg { width: 14px; height: 14px; fill: #6f54a4; transition: transform .2s; }
        .blog-card__read-more:hover svg { transform: translateX(3px); }

        .blog-pagination { margin-top: 48px; display: flex; justify-content: center; }

        /* Lead banner */
        .lead-banner { background: linear-gradient(135deg, #6f54a4 0%, #c086c0 100%); border-radius: 20px; padding: 40px 40px; display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-top: 60px; }
        .lead-banner__text h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .lead-banner__text p { color: rgba(255,255,255,.85); font-size: 15px; }
        .lead-banner__btn { white-space: nowrap; background: #fff; color: #6f54a4; padding: 14px 28px; border-radius: 100px; font-weight: 700; font-size: 14px; text-decoration: none; border: none; cursor: pointer; transition: transform .2s, box-shadow .2s; flex-shrink: 0; }
        .lead-banner__btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.15); }
        @media(max-width:640px){ .lead-banner{ flex-direction:column; padding:28px; } }

        html.blog-page, body.blog-page { overflow-x: hidden; }
        body.blog-page .cb-cursor { display: none !important; }
        @media (max-width: 768px) {
            body.blog-page .gt_float_switcher { top: 72px !important; right: 8px !important; }
        }
    </style>
</head>
<body class="blog-page">
    @include('includes.header')

    {{-- Hero --}}
    <div class="blog-hero">
        <div class="container">
            <nav style="margin-bottom:20px;" aria-label="Breadcrumb">
                <ol style="list-style:none;padding:0;margin:0;display:flex;gap:8px;align-items:center;font-size:13.5px;color:rgba(255,255,255,.55);">
                    <li><a href="/" style="color:rgba(255,255,255,.55);text-decoration:none;">Home</a></li>
                    <li style="opacity:.5;">/</li>
                    <li style="color:rgba(255,255,255,.85);">Blog</li>
                </ol>
            </nav>
            <h1>Bitcoin Sicherheits-Blog</h1>
            <p>Aktuelle Artikel zu Self-Custody, Hardware Wallets, Multisig & mehr.</p>
        </div>
    </div>

    {{-- Breadcrumb Schema --}}
    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"{{ url('/') }}"},{"@type":"ListItem","position":2,"name":"Blog","item":"{{ url('/blog') }}"}]}
    </script>

    <section class="blog-section">
        <div class="container">

            {{-- Category filters --}}
            @if($categories->isNotEmpty())
            <div class="blog-cat-filter">
                <a href="{{ route('blog.index') }}" class="blog-cat-btn {{ !$activeCategory ? 'active' : '' }}">Alle</a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                       class="blog-cat-btn {{ $activeCategory?->id === $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                        <span style="opacity:.65;font-weight:500;">({{ $cat->published_blogs_count }})</span>
                    </a>
                @endforeach
            </div>
            @endif

            @if($blogs->isEmpty())
                <div style="text-align:center;padding:80px 0;color:#7a728f;">
                    <svg style="width:60px;height:60px;fill:#e4ddf0;margin:0 auto 16px;display:block;" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    <p style="font-size:16px;">Noch keine Beiträge in dieser Kategorie.</p>
                </div>
            @else
            <div class="blog-grid">
                @foreach($blogs as $blog)
                <article class="blog-card">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card__img">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" loading="lazy">
                        @else
                            <div class="blog-card__img-placeholder">
                                <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            </div>
                        @endif
                    </a>
                    <div class="blog-card__body">
                        @if($blog->category)
                            <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}" class="blog-card__cat">{{ $blog->category->name }}</a>
                        @endif
                        <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card__title">{{ $blog->title }}</a>
                        @if($blog->excerpt)
                            <p class="blog-card__excerpt">{{ Str::limit($blog->excerpt, 120) }}</p>
                        @endif
                        <div class="blog-card__meta">
                            <span>
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                                {{ $blog->reading_time }} Min. Lesezeit
                            </span>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card__read-more">
                                Lesen
                                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            @if($blogs->hasPages())
                <div class="blog-pagination">{{ $blogs->links() }}</div>
            @endif
            @endif

            {{-- Lead generation banner --}}
            <div class="lead-banner wow fadeInUp">
                <div class="lead-banner__text">
                    <h3>Bitcoin Sicherheits-Selbsttest 2026</h3>
                    <p>Finden Sie in weniger als fünf Minuten heraus, wie sicher Ihr Bitcoin-Setup wirklich ist.</p>
                </div>
                <button class="lead-banner__btn" onclick="openLeadModal('checklist')">
                    Jetzt kostenlosen Selbsttest herunterladen
                </button>
            </div>

        </div>
    </section>

    @include('includes.footer')
    @include('includes.lead-modal')
    @include('includes.scripts')
</body>
</html>
