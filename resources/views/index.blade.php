<!DOCTYPE html>
<html lang="de">

<head>
    <title>Bitcoin sicher verwahren in Deutschland, Österreich & Schweiz | Privat & Unternehmen | Sicher Bitcoin Verwahren</title>
    <meta name="description" content="Bitcoin sicher verwahren – für Privatpersonen und KMU in Deutschland, Österreich und der Schweiz. Hardware Wallets, Multisig, sichere Backup Strategien und klare Video Anleitungen. Einfach, sicher, unabhängig.">
	
    @include('includes.styles')
    

</head>
<body>

	
    @include('includes.header')


    {{-- Skip purple splash on mobile (was delaying FCP/LCP in Lighthouse) --}}
    <div class="preloader" aria-hidden="true">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon">
				<picture>
					<source srcset="/images/loader.webp" type="image/webp">
					<img src="/images/loader.jpg" width="80" height="80" alt="Sicher Bitcoin Verwahren wird geladen">
				</picture>
			</div>
		</div>
	</div>

    <div class="hero parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <div class="hero-content">
                        <div class="section-title dark-section">
                            <h3 class="wow fadeInUp">Sichere Bitcoin‑Selbstverwahrung. Lokal vertraut, weltweit verfügbar.</h3>
                            <h1 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Bitcoin sicher verwahren – für Privatpersonen & KMU weltweit</h1>
                            <!-- <p class="wow fadeInUp" data-wow-delay="0.4s">Wir helfen Ihnen, Ihre Bitcoin selbst zu sichern – mit Hardware Wallets, Multi-Signature und persönlicher Beratung. Ob Privatperson oder Unternehmen: Ihre Bitcoin gehören Ihnen. Wir zeigen Ihnen, wie.</p> -->
                            <ul>
                                <li>Schutz vor Verlust, Diebstahl und typischen Fehlern </li>
                                <li>Dokumentierte Backups & Multisig-Systeme für maximale Sicherheit </li>
                                <li>Schweizer Fachkompetenz – keine technische Vorkenntnisse nötig</li>
                            </ul>
                        </div>

                        <div class="hero-content-body wow fadeInUp" data-wow-delay="0.6s">
                            <div class="hero-btn">
                                <a href="/contact-us" class="btn-default btn-highlighted" style="text-transform: initial;">Kostenlose Erstberatung anfragen</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <section class="teaservidsection">
        <div class="container">
            <video src="https://sicher-bitcoin-videos.s3.ap-southeast-1.amazonaws.com/homepage/teaser.mp4"
                   controls
                   preload="metadata"
                   playsinline
                   title="Sicher Bitcoin Verwahren Teaser-Video"
                   style="width:100%;aspect-ratio:16/9;background:#0f0a1e;"></video>
        </div>
    </section>


    <div class="our-services">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Unsere Leistungen</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Dienstleistungen, die <span>wir anbieten</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item wow fadeInUp">
                        <div class="icon-box">
                            <img src="/images/icon-service-1.svg" width="64" height="64" loading="lazy" alt="Bitcoin Self-Custody Beratung">
                        </div>
                        <div class="service-title-box">
                            <div class="service-title">
                                <h3><a href="/pricing">Private Self-Custody Beratung</a></h3>
                            </div>
                            <div class="service-btn">
                                <a href="/pricing">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="service-content">
                            <p>Erfahren Sie, wie Sie Ihre Bitcoins sicher speichern und verwalten. Wir führen Sie Schritt für Schritt durch Hardware-Wallets, Backup-Strategien und sicheres Schlüsselmanagement.</p>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item active wow fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-box">
                            <img src="/images/icon-service-2.svg" width="64" height="64" loading="lazy" alt="Hardware Wallet Einrichtung">
                        </div>
                        <div class="service-title-box">
                            <div class="service-title">
                                <h3><a href="/pricing">Bitcoin Verwahrung für Unternehmen</a></h3>
                            </div>
                            <div class="service-btn">
                                <a href="/pricing">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="service-content">
                            <p>Wir unterstützen Unternehmen beim Aufbau sicherer Bitcoin-Verwahrstrukturen. Von der Richtliniengestaltung bis zur technischen Einrichtung bleiben Ihre Geschäftswerte geschützt.</p>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="icon-box">
                            <img src="/images/icon-service-3.svg" width="64" height="64" loading="lazy" alt="Multisig und Backup Strategien">
                        </div>
                        <div class="service-title-box">
                            <div class="service-title">
                                <h3><a href="/workshops">Schulungen & Sicherheitskonzepte</a></h3>
                            </div>
                            <div class="service-btn">
                                <a href="/workshops">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="service-content">
                            <p>Erhalten Sie praktische Schulungen zur sicheren Bitcoin-Aufbewahrung und Risikoprävention. Wir entwickeln maßgeschneiderte Sicherheitskonzepte, die Ihren Bedürfnissen entsprechen.</p>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                
            </div>
        </div>
    </div>

    <div class="cta-box-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- CTA Box Start -->
                    <div class="cta-box">
                        <!-- CTA Box Content Start -->
                        <div class="cta-box-content">
                            <!-- Section Title Start -->
                            <div class="section-title dark-section">
                                <h2 class="wow fadeInUp" data-cursor="-opaque">Warum wir?</h2>
                            </div>
                            <!-- Section Title End -->

                            <!-- CTA Contact Info Start -->
                            <div class="cta-contact-info">
                                <div class="cta-contact-item">
                                    <div class="icon-box">
                                    </div>
                                    <div class="cta-contact-content">
                                        <h3>Schweizer Standort (Thun)</h3>
                                    </div>
                                </div>
                                <div class="cta-contact-item">
                                    <div class="icon-box">
                                    </div>
                                    <div class="cta-contact-content">
                                        <h3>Offizielle Partnerschaften mit führenden Herstellern</h3>
                                    </div>
                                </div>
                                <div class="cta-contact-item">
                                    <div class="icon-box">
                                    </div>
                                    <div class="cta-contact-content">
                                        <h3>Keine Anlageberatung – nur technische Sicherheit & Selbstbestimmung</h3>
                                    </div>
                                </div>
                                <div class="cta-contact-item">
                                    <div class="icon-box">
                                    </div>
                                    <div class="cta-contact-content">
                                        <h3>Persönlich, diskret, unabhängig</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- CTA Contact Info End -->
                        </div>
                        <!-- CTA Box Content End -->

                        <!-- CTA Box Image Start -->
                        <div class="cta-box-image">
                            <figure class="image-anime reveal">
                                <picture>
                                    <source srcset="/images/cta-box-image.webp" type="image/webp">
                                    <img src="/images/cta-box-image.jpg" width="600" height="400" loading="lazy" decoding="async" alt="Kostenlose Bitcoin Sicherheitsberatung">
                                </picture>
                            </figure>
                        </div>
                        <!-- CTA Box Image End -->
                    </div>
                    <!-- CTA Box End -->
                </div>
            </div>
        </div>
    </div>

    <div class="about-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- About Us Image Start -->
                    <div class="about-us-image">
                        <!-- About Image Box Start -->
                        <div class="about-image-box about-img-1">
                            <figure class="image-anime reveal">
                                <picture>
                                    <source srcset="/images/about-image-1.webp" type="image/webp">
                                    <img src="/images/about-image-1.jpg" width="560" height="420" loading="lazy" decoding="async" alt="Über Sicher Bitcoin Verwahren">
                                </picture>
                            </figure>
                        </div>
                        <!-- About Image Box End -->

                        <!-- About Image Box Start -->
                        <div class="about-image-box">
                            <div class="about-img-2">
                                <figure class="image-anime reveal">
                                    <picture>
                                        <source srcset="/images/about-image-2.webp" type="image/webp">
                                        <img src="/images/about-image-2.jpg" width="280" height="210" loading="lazy" decoding="async" alt="Persönliche Bitcoin Beratung">
                                    </picture>
                                </figure>
                            </div>

                            <div class="about-img-3">
                                <figure class="image-anime reveal">
                                    <picture>
                                        <source srcset="/images/about-image-3.webp" type="image/webp">
                                        <img src="/images/about-image-3.jpg" width="280" height="210" loading="lazy" decoding="async" alt="Sichere Bitcoin Verwahrung">
                                    </picture>
                                </figure>
                            </div>
                        </div>
                        <!-- About Image Box Start -->

                        <!-- Get Free Security Circle Start -->
                        <div class="get-free-security-circle">
                            <a href="contact.html">
                                <img src="/images/get-free-security-circle.svg" width="160" height="160" loading="lazy" alt="Kostenloser Sicherheits-Selbsttest">
                            </a>
                        </div>
                        <!-- Get Free Security Circle End -->
                    </div>
                    <!-- About Us Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- About Us Content Start -->
                    <div class="about-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Über uns</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Experten für Bitcoin  <span>Sicherheit und Unabhängigkeit</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s"> Wir sind ein auf Bitcoin-Sicherheit spezialisiertes Unternehmen aus Thun. Unser Team hilft Privatpersonen und Unternehmen, ihre Bitcoin sicher selbst zu verwahren.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- About Us Body Start -->
                        <div class="about-us-body wow fadeInUp" data-wow-delay="0.6s">
                            <!-- About Us Body Image Start -->
                            <div class="about-us-body-img">
                                <figure class="image-anime">
                                    <picture>
                                        <source srcset="/images/about-body-img.webp" type="image/webp">
                                        <img src="/images/about-body-img.png" width="540" height="360" loading="lazy" decoding="async" alt="Bitcoin Self-Custody Prozess">
                                    </picture>
                                </figure>
                            </div>
                            <!-- About Us Body Image End -->
                            
                            <!-- About Us Body Content Start -->
                            <div class="about-us-body-content">
                                <h3>Stärkung der finanziellen Souveränität</h3>
                                <p>Übernehmen Sie durch sichere Selbstverwahrung die volle Kontrolle über Ihre Bitcoins.</p>
                            </div>
                            <!-- About Us Body Content End -->
                        </div>
                        <!-- About Us Body End -->

                        <!-- About Us Footer Start -->
                        <div class="about-us-footer wow fadeInUp" data-wow-delay="0.8s">
                            <!-- About Footer List Start -->
                            <div class="about-footer-list">
                                <ul>
                                    <li>Kompetente Unterstützung</li>
                                    <li>Höchste Sicherheit</li>
                                    <li>Volle Unabhängigkeit</li>
                                </ul>
                            </div>
                            <!-- About Footer List End -->
                            
                            <!-- About Footer Content Start -->
                            <!--<div class="about-footer-content">-->
                                <!-- About Content Button Start -->
                            <!--    <div class="about-contact-btn">-->
                            <!--        <div class="icon-box">-->
                            <!--            <img src="/images/icon-phone.svg" alt="">-->
                            <!--        </div>-->
                                    
                            <!--        <div class="about-footer-btn-content">-->
                            <!--            <h3><a href="tel:(123) 456-7890">(123) 456-7890</a></h3>-->
                            <!--        </div>-->
                            <!--    </div>-->
                                <!-- About Content Button End -->
                                
                                <!-- About Footer Button Start -->
                                <div class="about-footer-btn">
                                    <a href="/about-us" class="btn-default">Mehr lesen</a>
                                </div>
                                <!-- About Footer Button End -->
                            </div>
                            <!-- About Footer Content End -->
                        </div>
                        <!-- About Us Footer End -->
                    </div>
                    <!-- About Us Content End -->
                </div>
            </div>
        </div>
    </div>

    <div class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Why Choose Image Start -->
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <picture>
                                <source srcset="/images/why-choose-image.webp" type="image/webp">
                                <img src="/images/why-choose-image.jpg" width="560" height="420" loading="lazy" decoding="async" alt="Warum Sicher Bitcoin Verwahren">
                            </picture>
                        </figure>
                    </div>
                    <!-- Why Choose Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- Why Choose Content Start -->
                    <div class="why-choose-content">
                        <!-- Section Title Start -->
                        <div class="section-title dark-section">
                            <h3 class="wow fadeInUp">Wie es funktioniert</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Ihr Weg zur Bitcoin-Sicherheit</h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Why Choose List Start -->
                        <div class="why-choose-list">
                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="icon-box">
                                    <img src="/images/icon-why-choose-1.svg" width="48" height="48" loading="lazy" alt="">
                                </div>
                                <div class="why-choose-item-content">
                                    <h3 style="text-transform: initial;">Kostenlose Erstberatung anfragen</h3>
                                    <p>Senden Sie uns eine unverbindliche Anfrage über unser Kontaktformular. Wir melden uns schnellstmöglich bei Ihnen für ein erstes Gespräch.</p>
                                </div>
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.6s">
                                <div class="icon-box">
                                    <img src="/images/icon-why-choose-2.svg" width="48" height="48" loading="lazy" alt="">
                                </div>
                                <div class="why-choose-item-content">
                                    <h3 style="text-transform: initial;" >Individuelles Angebot erhalten</h3>
                                    <p>Gemeinsam finden wir das passende Service-Paket für Sie. Sie erhalten ein detailliertes, transparentes Angebot.</p>
                                </div>
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.8s">
                                <div class="icon-box">
                                    <img src="/images/icon-why-choose-3.svg" width="48" height="48" loading="lazy" alt="">
                                </div>
                                <div class="why-choose-item-content">
                                    <h3 style="text-transform: initial;">Termin vereinbaren & vorbereiten</h3>
                                    <p>Sie bestätigen das Angebot und wir vereinbaren einen Termin. Wir kommen zu Ihnen – diskret und professionell.</p>
                                </div>
                            </div>

                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.6s">
                                <div class="icon-box">
                                    <img src="/images/icon-why-choose-2.svg" width="48" height="48" loading="lazy" alt="">
                                </div>
                                <div class="why-choose-item-content">
                                    <h3>Persönliche Einrichtung & Schulung</h3>
                                    <p>Unser Expertenteam richtet bei Ihnen vor Ort Ihr sicheres Bitcoin-Setup ein und schult Sie im Umgang damit.</p>
                                </div>
                            </div>

                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.8s">
                                <div class="icon-box">
                                    <img src="/images/icon-why-choose-3.svg" width="48" height="48" loading="lazy" alt="">
                                </div>
                                <div class="why-choose-item-content">
                                    <h3 style="text-transform: inherit;">Souverän in die Zukunft</h3>
                                    <p>Sie gehen mit einem fertigen, dokumentierten Setup und dem Wissen, Ihre Bitcoin souverän zu verwalten.</p>
                                </div>
                            </div>
                            <!-- Why Choose Item End -->
                        </div>
                        <!-- Why Choose List End -->
                    </div>
                    <!-- Why Choose Content End -->
                </div>

            </div>
        </div>
    </div>

    <div class="our-testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Unsere Bewertungen</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Das sagen <span>unsere Kunden</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-12">
                    <!-- Testimonial Box Start -->
                    <div class="testimonial-box parallaxie">
                        <!-- Testimonial Video Button Start -->
                        <div class="testimonial-video-button" style="opacity: 0;">
                            <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">
                                <i class="fa-solid fa-play"></i>
                            </a>
                            <h3>Watch video</h3>
                        </div>
                        <!-- Testimonial Video Button End -->

                        <!-- Testimonial Slide Box Start -->
                        <div class="testimonial-slider-box">
                            <!-- Testimonial Slide Start -->
                            <div class="testimonial-slider">
                                <div class="swiper">
                                    <div class="swiper-wrapper" data-cursor-text="Drag">
                                        <!-- Testimonial Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="testimonial-item">
                                                <div class="testimonial-header">
                                                    <div class="testimonial-company-logo">
                                                        <img src="/images/company-logo.jpg" width="80" height="80" loading="lazy" alt="Kundenlogo">
                                                    </div>        
                                                    <div class="testimonial-quote">
                                                        <img src="/images/testimonial-quote.svg" width="32" height="32" loading="lazy" alt="">
                                                    </div>
                                                </div>                               
                                                <div class="testimonial-content">
                                                    <p>
                                                        Äußerst professioneller Service! Die Einrichtung unseres Multi-Signature Setups für die Firmen-Bitcoin war reibungslos. Endlich schlafe ich wieder ruhig
                                                    </p>
                                                </div>
                                                <div class="testimonial-body">
                                                    <div class="author-content">
                                                        <h3>Thomas B.</h3>
                                                        <p>Unternehmer aus Bern</p>
                                                    </div>   
                                                </div>                                    
                                            </div>
                                        </div>
                                        <!-- Testimonial Slide End -->

                                        <!-- Testimonial Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="testimonial-item">
                                                <div class="testimonial-header">
                                                    <div class="testimonial-company-logo">
                                                        <img src="/images/company-logo.jpg" width="80" height="80" loading="lazy" alt="Kundenlogo">
                                                    </div>        
                                                    <div class="testimonial-quote">
                                                        <img src="/images/testimonial-quote.svg" width="32" height="32" loading="lazy" alt="">
                                                    </div>
                                                </div>                               
                                                <div class="testimonial-content">
                                                    <p>Ich fühle mich viel sicherer. Die geduldige Schulung hat mir alle Ängste genommen. Absolute Empfehlung!</p>
                                                </div>
                                                <div class="testimonial-body">
                                                    <div class="author-content">
                                                        <h3>Familie M.</h3>
                                                        <p>Privatkundin aus Interlaken</p>
                                                    </div>   
                                                </div>                                    
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-item">
                                                <div class="testimonial-header">
                                                    <div class="testimonial-company-logo">
                                                        <img src="/images/company-logo.jpg" width="80" height="80" loading="lazy" alt="Kundenlogo">
                                                    </div>        
                                                    <div class="testimonial-quote">
                                                        <img src="/images/testimonial-quote.svg" width="32" height="32" loading="lazy" alt="">
                                                    </div>
                                                </div>                               
                                                <div class="testimonial-content">
                                                    <p>Genau der kompetente Partner, den ich in der Schweiz gesucht habe. Klare Kommunikation, tiefes Fachwissen und diskret.</p>
                                                </div>
                                                <div class="testimonial-body">
                                                    <div class="author-content">
                                                        <h3>Daniel R.</h3>
                                                        <p>Investor aus Zürich</p>
                                                    </div>   
                                                </div>                                    
                                            </div>
                                        </div>
                                        <!-- Testimonial Slide End -->
                                    </div>
                                    <div class="testimonial-btn">
                                        <div class="testimonial-button-prev"></div>
                                        <div class="testimonial-button-next"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial Slide End -->

                            <!-- Testimnoial Contact Info Start -->
                            <div class="testimonial-contact-info">
                               <div class="testimonial-contact-box">
                                    <div class="testimonial-contact-content">
                                        <p>Wenn Sie Fragen haben oder Hilfe benötigen.</p>
                                    </div>
                                </div>
                                <!-- Testimonial Contact Box End -->
                                
                                <!-- Testimonial Contact Button Start -->
                                <div class="testimonial-contact-btn">
                                    <a href="/contact-us" class="btn-default">kontaktieren</a>
                                </div>
                                <!-- Testimonial Contact Button End -->
                            </div>
                            <!-- Testimnoial Contact Info End -->
                        </div>
                        <!-- Testimonial Slide Box End -->
                    </div>
                    <!-- Testimonials Box End -->
                </div>
            </div>
        </div>
    </div>


    {{-- ── Latest Blog Articles ────────────────────────────────────────────── --}}
    @if(isset($latestBlogs) && $latestBlogs->isNotEmpty())
    <div class="our-testimonials" style="padding-top:0;">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Wissen & Tipps</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Neueste <span>Artikel</span></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($latestBlogs as $blog)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <div class="service-item" style="display:flex;flex-direction:column;height:100%;">
                        @if($blog->featured_image)
                            <a href="{{ route('blog.show', $blog->slug) }}" style="display:block;border-radius:12px;overflow:hidden;margin-bottom:18px;aspect-ratio:16/9;">
                                <img src="{{ asset('storage/'.$blog->featured_image) }}" alt="{{ $blog->title }}"
                                     width="640" height="360"
                                     style="width:100%;height:100%;object-fit:cover;transition:transform .4s;" loading="lazy"
                                     onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        @else
                            <a href="{{ route('blog.show', $blog->slug) }}" style="display:flex;align-items:center;justify-content:center;border-radius:12px;aspect-ratio:16/9;background:linear-gradient(135deg,#f4f2f9,#ede9f5);margin-bottom:18px;">
                                <svg style="width:40px;height:40px;fill:#c8bde0;" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                            </a>
                        @endif

                        @if($blog->category)
                            <span style="display:inline-block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6f54a4;background:rgba(111,84,164,.08);padding:3px 10px;border-radius:20px;margin-bottom:10px;width:fit-content;">{{ $blog->category->name }}</span>
                        @endif

                        <div class="service-title-box" style="margin-bottom:10px;">
                            <div class="service-title">
                                <h3><a href="{{ route('blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 65) }}</a></h3>
                            </div>
                            <div class="service-btn">
                                <a href="{{ route('blog.show', $blog->slug) }}">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        @if($blog->excerpt)
                            <div class="service-content" style="flex:1;">
                                <p>{{ Str::limit($blog->excerpt, 100) }}</p>
                            </div>
                        @endif

                        <div style="font-size:12px;color:#a89fc0;margin-top:14px;display:flex;align-items:center;gap:12px;">
                            <span>{{ $blog->author }}</span>
                            @if($blog->published_at)
                                <span>·</span>
                                <span>{{ $blog->published_at->format('d.m.Y') }}</span>
                            @endif
                            <span>·</span>
                            <span>{{ $blog->reading_time }} Min.</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row" style="margin-top:36px;">
                <div class="col-12 text-center">
                    <a href="{{ route('blog.index') }}" class="btn-default wow fadeInUp">
                        Alle Artikel anzeigen
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Lead Generation Section ─────────────────────────────────────────── --}}
    <div class="cta-box-section" style="padding: 0px 0 60px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-box" style="flex-direction:column;gap:24px;padding:40px 48px;">
                        <div class="cta-box-content" style="flex:unset;width:100%;text-align:center;">
                            <div class="section-title dark-section" style="text-align:center;">
                                <h2 class="wow fadeInUp" data-cursor="-opaque">Wie sicher sind Ihre Bitcoin wirklich?</h2>
                                <p style="max-width:540px;margin:0 auto 28px;">Finden Sie in weniger als fünf Minuten heraus, ob Ihr Bitcoin-Setup ausreichend gegen Verlust, Diebstahl und typische Fehler geschützt ist – mit dem kostenlosen Bitcoin Sicherheits-Selbsttest 2026.</p>
                            </div>
                            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                                <button onclick="openLeadModal('checklist')"
                                        class="btn-default btn-highlighted"
                                        style="background:linear-gradient(135deg,#fff,#f4f2f9);color:#6f54a4;border:none;cursor:pointer;font-family:inherit;">
                                    Jetzt kostenlosen Selbsttest herunterladen
                                </button>
                                <a href="{{ route('pricing.index') }}"
                                        class="btn-default"
                                        style="background:transparent;border:2px solid rgba(255,255,255,.4);color:#fff;cursor:pointer;font-family:inherit;">
                                    Videokurse entdecken
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('includes.footer')
    @include('includes.lead-modal')
    @include('includes.scripts')
    
    
</body>

</html>