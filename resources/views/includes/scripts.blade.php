<script src="/js/jquery-3.7.1.min.js" defer></script>
    <script src="/js/bootstrap.min.js" defer></script>
    <script src="/js/jquery.slicknav.js" defer></script>
    <script src="/js/jquery.waypoints.min.js" defer></script>
    <script src="/js/jquery.counterup.min.js" defer></script>
    <script src="/js/function.js" defer></script>

    {{-- Heavy libs: load after idle to cut mobile Total Blocking Time --}}
    <script>
    (function () {
        function loadScript(src, onload) {
            var s = document.createElement('script');
            s.src = src;
            s.async = true;
            if (onload) s.onload = onload;
            document.body.appendChild(s);
        }

        function loadDeferred() {
            loadScript('/js/validator.min.js');
            loadScript('/js/jquery.magnific-popup.min.js');
            loadScript('/js/parallaxie.js');

            // Desktop-only heavy animation libs (big TBT hit on mobile)
            if (window.matchMedia('(min-width: 992px) and (pointer: fine)').matches) {
                [
                    '/js/gsap.min.js',
                    '/js/ScrollTrigger.min.js',
                    '/js/SplitText.js',
                    '/js/SmoothScroll.js',
                    '/js/jquery.mb.YTPlayer.min.js',
                    '/js/magiccursor.js'
                ].forEach(function (src) { loadScript(src); });
            }

            // Swiper only when needed, after first paint
            if (document.querySelector('.swiper')) {
                loadScript('/js/swiper-bundle.min.js', function () {
                    if (typeof window.initPageSwipers === 'function') {
                        window.initPageSwipers();
                    }
                });
            }
        }

        function loadGTranslate() {
            if (window.__gtLoaded) return;
            window.__gtLoaded = true;
            window.gtranslateSettings = {
                default_language: 'de',
                languages: ['de', 'en'],
                wrapper_selector: '.gtranslate_wrapper',
                switcher_horizontal_position: 'right',
                switcher_vertical_position: 'top'
            };
            loadScript('https://cdn.gtranslate.net/widgets/latest/float.js');
        }

        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadDeferred, { timeout: 3000 });
            requestIdleCallback(loadGTranslate, { timeout: 4500 });
        } else {
            window.addEventListener('load', function () {
                setTimeout(loadDeferred, 1000);
                setTimeout(loadGTranslate, 1600);
            });
        }
    })();
    </script>

    <div class="gtranslate_wrapper" aria-label="Sprachauswahl"></div>
