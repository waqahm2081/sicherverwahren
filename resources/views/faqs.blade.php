<!DOCTYPE html>
<html lang="de">

<head>

    <title>Bitcoin FAQ – Häufige Fragen zur sicheren Verwahrung | DACH</title>
    <meta name="description" content="Antworten zu den wichtigsten Fragen rund um Bitcoin Verwahrung: Hardware Wallets, Multisig, Backup, Sicherheit und Risiken. Bitcoin Sicherheitsberatung für Deutschland, Österreich und die Schweiz.">
	
    @include('includes.styles')

    <link rel="canonical" href="{{ url('/faqs') }}">

    {{-- FAQPage Schema --}}
    @php
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq->answer),
                ],
            ])->values()->all(),
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>

</head>
<body>

	
    @include('includes.header')

    <div class="page-header parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">FAQs</h1>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>


    <div class="page-faqs">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <!-- Page FAQs Category Start -->
                    <div class="page-faqs-catagery">
                        <!-- FAQs section start -->
                        <div class="page-faqs-accordion" id="general_security">
                            <!-- Section Title Start -->
                            <div class="section-title text-center">
                                <h2 class="wow fadeInUp" data-cursor="-opaque">Häufig gestellte Fragen zur Bitcoin Verwahrung</h2>
                                <p>Hier finden Sie die wichtigsten Antworten zur sicheren Bitcoin Selbstverwahrung in Deutschland, Österreich und der Schweiz.</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- FAQ Accordion Start -->
                            <div class="faq-accordion" id="accordion">
                                @forelse($faqs as $index => $faq)
                                <div class="accordion-item wow fadeInUp" data-wow-delay="{{ min(0.2 + $index * 0.2, 1.0) }}s">
                                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                        <button class="accordion-button {{ $index === 1 ? '' : 'collapsed' }}" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                aria-expanded="{{ $index === 1 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 1 ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center">Keine FAQs verfügbar.</p>
                                @endforelse
                            </div>
                            <!-- FAQ Accordion End -->
                        </div>
                        <!-- FAQs section End -->
                    </div>  
                    <!-- Page FAQs Category End -->
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')

    @include('includes.scripts')
    
    
</body>

</html>