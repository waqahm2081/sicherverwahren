<!DOCTYPE html>
<html lang="de">
<head>
    <title>{{ $blog->meta_title ?: $blog->title }} | Sicher Bitcoin Verwahren</title>
    <meta name="description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->excerpt ?: $blog->content), 160) }}">
    @include('includes.styles')

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url('/blog/' . $blog->slug) }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="{{ $blog->meta_title ?: $blog->title }}">
    <meta property="og:description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->excerpt ?: $blog->content), 160) }}">
    <meta property="og:url"         content="{{ url('/blog/' . $blog->slug) }}">
    @if($blog->featured_image)
    <meta property="og:image"       content="{{ asset('storage/' . $blog->featured_image) }}">
    @endif
    <meta property="article:published_time" content="{{ $blog->published_at?->toIso8601String() }}">
    <meta property="article:author" content="{{ $blog->author }}">

    {{-- Twitter Cards --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $blog->meta_title ?: $blog->title }}">
    <meta name="twitter:description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->excerpt ?: $blog->content), 160) }}">
    @if($blog->featured_image)
    <meta name="twitter:image"       content="{{ asset('storage/' . $blog->featured_image) }}">
    @endif

    {{-- Article Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ addslashes($blog->title) }}",
        "description": "{{ addslashes(Str::limit(strip_tags($blog->excerpt ?: $blog->content), 160)) }}",
        "author": {"@type":"Person","name":"{{ $blog->author }}"},
        "publisher": {
            "@type": "Organization",
            "name": "Sicher Bitcoin Verwahren",
            "logo": {"@type":"ImageObject","url":"https://sicher-bitcoin-verwahren.ch/images/logo.jpg"}
        },
        "datePublished": "{{ $blog->published_at?->toIso8601String() }}",
        "dateModified":  "{{ $blog->updated_at->toIso8601String() }}",
        "mainEntityOfPage": {"@type":"WebPage","@id":"{{ url('/blog/'.$blog->slug) }}"}
        @if($blog->featured_image)
        ,"image": "{{ asset('storage/'.$blog->featured_image) }}"
        @endif
    }
    </script>

    {{-- Breadcrumb Schema --}}
    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[
        {"@type":"ListItem","position":1,"name":"Home","item":"{{ url('/') }}"},
        {"@type":"ListItem","position":2,"name":"Blog","item":"{{ url('/blog') }}"},
        {"@type":"ListItem","position":3,"name":"{{ addslashes($blog->title) }}","item":"{{ url('/blog/'.$blog->slug) }}"}
    ]}
    </script>

    <style>
        /* ── Article Layout ── */
        .article-hero { background: linear-gradient(135deg, #1a1625 0%, #2d1f4e 100%); padding: 60px 0 0; }
        .article-breadcrumb { font-size: 13px; color: rgba(255,255,255,.5); margin-bottom: 24px; display: flex; gap: 8px; flex-wrap: wrap; }
        .article-breadcrumb a { color: rgba(255,255,255,.55); text-decoration: none; }
        .article-breadcrumb a:hover { color: #fff; }
        .article-cat-badge { display: inline-block; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; background: rgba(192,134,192,.25); color: #e0b8e0; padding: 4px 12px; border-radius: 20px; margin-bottom: 16px; text-decoration: none; }
        .article-hero__title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 42px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 20px; max-width: 760px; }
        @media(max-width:768px){ .article-hero__title{font-size:28px;} }
        .article-meta { display: flex; flex-wrap: wrap; gap: 20px; color: rgba(255,255,255,.6); font-size: 13.5px; padding-bottom: 40px; }
        .article-meta span { display: flex; align-items: center; gap: 6px; }
        .article-meta svg { width: 15px; height: 15px; fill: rgba(255,255,255,.4); }
        .article-hero__img { width: 100%; max-height: 420px; object-fit: cover; display: block; border-radius: 0; }

        .article-layout { display: grid; grid-template-columns: 1fr 300px; gap: 48px; padding: 60px 0 80px; align-items: start; }
        @media(max-width:1024px){ .article-layout{grid-template-columns:1fr;} }

        .article-content { font-size: 16px; color: #2d2040; line-height: 1.8; }
        .article-content h1,.article-content h2,.article-content h3,.article-content h4 {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #1a1625; margin: 32px 0 14px;
        }
        .article-content h2 { font-size: 26px; }
        .article-content h3 { font-size: 21px; }
        .article-content p  { margin-bottom: 18px; }
        .article-content ul, .article-content ol { padding-left: 24px; margin-bottom: 18px; }
        .article-content li { margin-bottom: 8px; }
        .article-content a  { color: #6f54a4; text-decoration: underline; }
        .article-content blockquote { border-left: 4px solid #6f54a4; padding: 12px 20px; background: #f9f7ff; border-radius: 0 8px 8px 0; margin: 24px 0; color: #3d3456; font-style: italic; }
        .article-content img { max-width: 100%; border-radius: 12px; margin: 16px 0; }
        .article-content pre { background: #1a1625; color: #e0d8f0; padding: 20px; border-radius: 10px; overflow-x: auto; font-size: 14px; margin-bottom: 18px; }
        .article-content table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .article-content th,.article-content td { padding: 10px 14px; border: 1px solid #e4ddf0; font-size: 14.5px; }
        .article-content th { background: #f4f2f9; font-weight: 700; }

        .article-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 36px; padding-top: 28px; border-top: 1px solid #ede9f5; }
        .article-tag { font-size: 12px; font-weight: 600; background: rgba(111,84,164,.08); color: #6f54a4; padding: 4px 12px; border-radius: 20px; text-decoration: none; }

        /* Sidebar */
        .article-sidebar-card { background: #fff; border: 1px solid #ede9f5; border-radius: 16px; padding: 24px; margin-bottom: 20px; }
        .article-sidebar-card h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: #1a1625; margin-bottom: 16px; }

        /* Lead CTA inside article */
        .article-lead-cta { background: linear-gradient(135deg, #6f54a4, #c086c0); border-radius: 16px; padding: 28px 24px; color: #fff; margin: 40px 0; text-align: center; }
        .article-lead-cta h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; margin-bottom: 8px; }
        .article-lead-cta p { font-size: 14px; color: rgba(255,255,255,.85); margin-bottom: 18px; }
        .article-lead-cta-btn { background: #fff; color: #6f54a4; border: none; padding: 12px 24px; border-radius: 100px; font-weight: 700; font-size: 13.5px; cursor: pointer; transition: transform .2s, box-shadow .2s; text-decoration: none; display: inline-block; }
        .article-lead-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.15); }

        /* Related */
        .related-section { padding: 0 0 80px; }
        .related-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
        @media(max-width:768px){ .related-grid{grid-template-columns:1fr;} }

        .related-card { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #ede9f5; text-decoration: none; transition: transform .2s, box-shadow .2s; display: block; }
        .related-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(111,84,164,.12); }
        .related-card__img { aspect-ratio: 16/9; overflow: hidden; background: #f4f2f9; }
        .related-card__img img { width: 100%; height: 100%; object-fit: cover; }
        .related-card__body { padding: 18px; }
        .related-card__title { font-size: 15px; font-weight: 700; color: #1a1625; line-height: 1.35; margin-bottom: 6px; }
        .related-card__date { font-size: 12px; color: #a89fc0; }
    </style>
</head>
<body>
    @include('includes.header')

    {{-- Hero --}}
    <div class="article-hero">
        <div class="container">
            <nav class="article-breadcrumb" aria-label="Breadcrumb">
                <a href="/">Home</a><span>/</span>
                <a href="{{ route('blog.index') }}">Blog</a><span>/</span>
                @if($blog->category)
                    <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}">{{ $blog->category->name }}</a><span>/</span>
                @endif
                <span style="color:rgba(255,255,255,.8);">{{ Str::limit($blog->title, 40) }}</span>
            </nav>

            @if($blog->category)
                <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}" class="article-cat-badge">{{ $blog->category->name }}</a>
            @endif

            <h1 class="article-hero__title">{{ $blog->title }}</h1>

            <div class="article-meta">
                <span>
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 5h2v6H11V7zm0 8h2v2h-2v-2z"/></svg>
                    {{ $blog->author }}
                </span>
                @if($blog->published_at)
                <span>
                    <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                    {{ $blog->published_at->format('d. F Y') }}
                </span>
                @endif
                <span>
                    <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                    {{ $blog->reading_time }} Min. Lesezeit
                </span>
            </div>
        </div>

        @if($blog->featured_image)
            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="article-hero__img">
        @endif
    </div>

    {{-- Article Body --}}
    <section>
        <div class="container">
            <div class="article-layout">

                {{-- Content --}}
                <div>
                    <div class="article-content">
                        {!! $blog->content !!}
                    </div>

                    {{-- Tags --}}
                    @if($blog->tags && count($blog->tags))
                    <div class="article-tags">
                        @foreach($blog->tags as $tag)
                            <span class="article-tag">#{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif

                    {{-- Lead CTA 1: Checklist --}}
                    <div class="article-lead-cta" style="margin-top:48px;">
                        <h3>Kostenlose Bitcoin-Sicherheits-Checkliste</h3>
                        <p>Laden Sie jetzt unsere kostenlose Checkliste herunter und starten Sie sicher mit Bitcoin Self-Custody.</p>
                        <button class="article-lead-cta-btn" onclick="openLeadModal('checklist')">
                            Jetzt kostenlos herunterladen
                        </button>
                    </div>

                    {{-- Lead CTA 2: Training --}}
                    <div class="article-lead-cta" style="background:linear-gradient(135deg, #2d1f4e, #6f54a4);">
                        <h3>Bitcoin Self-Custody Digital Lernen</h3>
                        <p>Erlernen Sie Bitcoin Self-Custody Schritt für Schritt über unsere digitale Trainingsplattform.</p>
                        <button class="article-lead-cta-btn" onclick="openLeadModal('training')">
                            Zur Trainingsplattform
                        </button>
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside>
                    <div class="article-sidebar-card" style="position:sticky;top:100px;">
                        <h4>Über den Autor</h4>
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#6f54a4,#c086c0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px;flex-shrink:0;">
                                {{ strtoupper(substr($blog->author, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700;color:#1a1625;font-size:14px;">{{ $blog->author }}</div>
                                <div style="font-size:12px;color:#a89fc0;">Bitcoin-Sicherheitsexperte</div>
                            </div>
                        </div>
                        <p style="font-size:13px;color:#7a728f;line-height:1.6;">Bitcoin-Sicherheitsexperte aus Thun, Schweiz. Spezialist für Self-Custody, Hardware Wallets und Multisig-Lösungen.</p>

                        <div style="border-top:1px solid #ede9f5;margin:20px 0;"></div>

                        <h4>Gratis Checkliste sichern</h4>
                        <p style="font-size:13px;color:#7a728f;margin-bottom:14px;">Die 5 essentiellen Schritte für sichere Bitcoin-Verwahrung.</p>
                        <button onclick="openLeadModal('checklist')" style="width:100%;background:linear-gradient(135deg,#6f54a4,#c086c0);color:#fff;border:none;padding:12px;border-radius:10px;font-weight:700;font-size:13.5px;cursor:pointer;transition:opacity .2s;" onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                            Jetzt herunterladen
                        </button>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    {{-- Related Articles --}}
    @if($related->isNotEmpty())
    <section class="related-section">
        <div class="container">
            <div style="margin-bottom:32px;">
                <h2 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;font-weight:800;color:#1a1625;margin-bottom:8px;">Ähnliche Beiträge</h2>
            </div>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="related-card">
                    <div class="related-card__img">
                        @if($rel->featured_image)
                            <img src="{{ asset('storage/'.$rel->featured_image) }}" alt="{{ $rel->title }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                <svg style="width:40px;height:40px;fill:#c8bde0;" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="related-card__body">
                        @if($rel->category)
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6f54a4;margin-bottom:6px;">{{ $rel->category->name }}</div>
                        @endif
                        <div class="related-card__title">{{ $rel->title }}</div>
                        <div class="related-card__date">{{ $rel->published_at?->format('d.m.Y') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('includes.footer')
    @include('includes.lead-modal')
    @include('includes.scripts')
</body>
</html>
