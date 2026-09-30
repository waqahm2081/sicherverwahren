<!-- Google Analytics: deferred so it does not compete with LCP -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  window.addEventListener('load', function () {
    var s = document.createElement('script');
    s.src = 'https://www.googletagmanager.com/gtag/js?id=G-CFVSPGM8J4';
    s.async = true;
    s.onload = function () { gtag('js', new Date()); gtag('config', 'G-CFVSPGM8J4'); };
    document.head.appendChild(s);
  });
</script>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index, follow">

<link rel="icon" href="/images/loader.webp" type="image/webp">
<link rel="icon" href="/images/loader.jpg" type="image/jpeg">
<link rel="shortcut icon" href="/images/loader.jpg" type="image/jpeg">
<link rel="apple-touch-icon" href="/images/loader.jpg">

<!-- Open Graph Tags for Social Media -->
<meta property="og:title" content="Sicher Bitcoin Verwahren – Bitcoin sicher verwahren in der Schweiz">
<meta property="og:description" content="Professionelle Bitcoin Self-Custody Beratung und Einrichtung in Thun. Bitcoin-only Hardware Wallets und Multi-Signature Lösungen.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://sicher-bitcoin-verwahren.ch">
<meta property="og:image" content="https://sicher-bitcoin-verwahren.ch/assets/images/og-image.jpg">

@if(request()->is('/'))
<link rel="canonical" href="https://sicher-bitcoin-verwahren.ch">
{{-- Responsive LCP preload: small image on phones, full on desktop --}}
<link rel="preload" as="image" href="/images/hero-bg-mobile.webp" type="image/webp" media="(max-width: 991px)" fetchpriority="high">
<link rel="preload" as="image" href="/images/hero-bg.webp" type="image/webp" media="(min-width: 992px)" fetchpriority="high">
@endif

<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "LocalBusiness",
"name": "Sicher Bitcoin Verwahren",
"image": "https://sicher-bitcoin-verwahren.ch/images/logo.jpg",
"@id": "https://sicher-bitcoin-verwahren.ch",
"url": "https://sicher-bitcoin-verwahren.ch",
"address": {
    "@type": "PostalAddress",
    "streetAddress": "Allmendingen-Allee 9",
    "addressLocality": "Thun",
    "postalCode": "3608",
    "addressCountry": "CH"
},
"geo": {
    "@type": "GeoCoordinates",
    "latitude": 46.751,
    "longitude": 7.621
},
"openingHours": "Mo-Fr 09:00-17:00",
"sameAs": [
    "https://www.linkedin.com/company/sicher-bitcoin-verwahren"
]
}
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>

{{-- Critical above-the-fold CSS so hero paints before large stylesheets --}}
<style>
*,*::before,*::after{box-sizing:border-box}
body{margin:0;font-family:'Plus Jakarta Sans',system-ui,-apple-system,sans-serif;color:#1a1625;background:#fff}
img,video{max-width:100%;height:auto}
.preloader{position:fixed;inset:0;z-index:1000;display:flex;align-items:center;justify-content:center;background:linear-gradient(90.15deg,#6f54a4 1.15%,#c086c0 98.84%)}
@media (max-width:991px){.preloader{display:none!important}}
.topbar{background:#6f54a4;color:#fff;font-size:13px}
.topbar a{color:#fff;text-decoration:none}
.main-header{position:relative;z-index:100;background:#fff}
.navbar{display:flex;align-items:center;justify-content:space-between;padding:10px 0}
.navbar-brand img{width:80px;height:auto}
.hero{position:relative;min-height:420px;padding:100px 0 80px;background-color:#010535;background-repeat:no-repeat;background-position:center;background-size:cover;color:#fff;
  background-image:url('/images/hero-bg-mobile.jpg');
  background-image:image-set(url('/images/hero-bg-mobile.webp') type('image/webp'),url('/images/hero-bg-mobile.jpg') type('image/jpeg'))}
@media (min-width:992px){.hero{min-height:520px;padding:140px 0;
  background-image:url('/images/hero-bg.jpg');
  background-image:image-set(url('/images/hero-bg.webp') type('image/webp'),url('/images/hero-bg.jpg') type('image/jpeg'))}}
.hero::before{content:'';position:absolute;inset:0;background:linear-gradient(270deg,rgba(1,5,53,.28) 43.57%,rgba(1,5,53,.8) 100%);z-index:1}
.hero .container,.hero-content,.section-title{position:relative;z-index:2}
.hero h1,.hero h3,.hero li,.hero p{color:#fff}
.hero h1{font-size:clamp(1.6rem,5vw,2.8rem);line-height:1.2;margin:0 0 1rem;font-weight:800}
.hero h3{font-size:clamp(.85rem,2.5vw,1.1rem);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .75rem}
.hero ul{padding-left:1.1rem;margin:1rem 0 1.5rem}
.hero li{margin-top:12px}
.btn-default{display:inline-block;padding:12px 22px;border-radius:100px;background:#6f54a4;color:#fff!important;text-decoration:none;font-weight:700}
.btn-highlighted{background:linear-gradient(135deg,#6f54a4,#c086c0)}
.container{width:100%;max-width:1140px;margin:0 auto;padding:0 15px}
.teaservidsection{padding:40px 0}
.teaservidsection video{width:100%;aspect-ratio:16/9;background:#0f0a1e;border-radius:20px;display:block}
@media (max-width:991px){.cb-cursor{display:none!important}}
</style>

@if(request()->is('/'))
{{-- Homepage: load large CSS without blocking first paint --}}
<link rel="stylesheet" href="/css/bootstrap.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/style.css" media="print" onload="this.media='all'">
<noscript>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css">
</noscript>
@else
<link rel="preload" href="/css/bootstrap.min.css" as="style">
<link rel="preload" href="/css/style.css" as="style">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css">
@endif

{{-- Non-critical CSS deferred --}}
<link rel="stylesheet" href="/css/slicknav.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/swiper-bundle.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/all.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/animate.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/magnific-popup.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/css/mousecursor.css" media="print" onload="this.media='all'">
<noscript>
<link rel="stylesheet" href="/css/slicknav.min.css">
<link rel="stylesheet" href="/css/swiper-bundle.min.css">
<link rel="stylesheet" href="/css/all.min.css">
<link rel="stylesheet" href="/css/animate.css">
<link rel="stylesheet" href="/css/magnific-popup.css">
</noscript>
