<script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/bootstrap.min.js" defer></script>
    <script src="/js/jquery.slicknav.js" defer></script>
    <script src="/js/swiper-bundle.min.js" defer></script>
    <script src="/js/jquery.waypoints.min.js" defer></script>
    <script src="/js/jquery.counterup.min.js" defer></script>
    <script src="/js/wow.min.js" defer></script>
    <script src="/js/function.js" defer></script>

    {{-- Heavy / non-critical libs — load after idle so they don't block LCP --}}
    <script>
    (function () {
        function loadDeferred() {
            var files = [
                '/js/validator.min.js',
                '/js/jquery.magnific-popup.min.js',
                '/js/parallaxie.js',
                '/js/gsap.min.js',
                '/js/ScrollTrigger.min.js',
                '/js/SplitText.js',
                '/js/SmoothScroll.js',
                '/js/jquery.mb.YTPlayer.min.js'
            ];
            // Magic cursor only on fine pointers (desktop)
            if (window.matchMedia('(pointer:fine)').matches) {
                files.push('/js/magiccursor.js');
            }
            files.forEach(function (src) {
                var s = document.createElement('script');
                s.src = src;
                s.async = true;
                document.body.appendChild(s);
            });
        }
        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadDeferred, { timeout: 2500 });
        } else {
            window.addEventListener('load', function () { setTimeout(loadDeferred, 800); });
        }
    })();
    </script>

    <div class="gtranslate_wrapper" aria-label="Sprachauswahl"></div>
    <script>window.gtranslateSettings = {"default_language":"de","languages":["de","en"],"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","switcher_vertical_position":"top"}</script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
