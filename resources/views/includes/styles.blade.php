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

<!-- Canonical URL (page-specific views may override) -->
@if(request()->is('/'))
<link rel="canonical" href="https://sicher-bitcoin-verwahren.ch">
{{-- LCP: hero background must be discoverable in HTML --}}
<link rel="preload" as="image" href="/images/hero-bg.webp" type="image/webp" fetchpriority="high">
@endif

<!-- Structured Data for Local Business -->
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

{{-- Fonts: preconnect + subset weights + display=swap --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>

{{-- Preload critical CSS, then apply (keeps cascade order) --}}
<link rel="preload" href="/css/bootstrap.min.css" as="style">
<link rel="preload" href="/css/style.css" as="style">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css">

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

<style>
  /* CLS / LCP helpers — do not change visual design */
  img, video { max-width: 100%; height: auto; }
  .hero { min-height: 520px; }
  .teaservidsection video {
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #0f0a1e;
    display: block;
  }
  @media (max-width: 991px) {
    .cb-cursor { display: none !important; }
    .hero { min-height: 420px; }
  }
</style>
