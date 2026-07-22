@php
// Pre-calculate values for better performance
$whatsappBase = 'https://wa.me/254721920545?text=';
$primaryColor = '#1a472a';
$secondaryColor = '#2e7d32';
$lightColor = '#e8f5e9';

// Optimize image paths
$landingImage = asset('Images/herowq.jpeg');
$aboutImage = asset('Images/phoniana.jpeg');
$logoImage = asset('Images/logo-removebg-preview.png');

// Prepare phone data with optimized calculations
$fullPhonesOptimized = $fullPhones->map(function($phone) use ($whatsappBase) {
    $phone->whatsapp_url = $whatsappBase . urlencode("Hello, I am interested in {$phone->name} (Full Payment)");
    $phone->image_url = asset($phone->image_path);
    $phone->image_available = filled($phone->image_path) && is_file(public_path($phone->image_path));
    return $phone;
});

$lipaPhonesOptimized = $lipaPhones->map(function($phone) use ($whatsappBase) {
    $phone->whatsapp_url = $whatsappBase . urlencode("Hello, I am interested in {$phone->name} (Lipa PolePole)");
    $phone->image_url = asset($phone->image_path);
    $phone->image_available = filled($phone->image_path) && is_file(public_path($phone->image_path));
    return $phone;
});
@endphp

@extends('layouts.landing-master')

@section('styles')
    <!-- SWIPERJS CSS - Load after critical content -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}" media="print" onload="this.media='all'">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap');

        :root {
            --primary-color: #123f2b;
            --primary-dark: #092a1c;
            --primary-light: #eaf4ed;
            --accent-color: #f3b33d;
            --page-bg: #fbfcfa;
            --surface: #ffffff;
            --ink: #14221b;
            --muted: #66736c;
            --border: #e4e9e5;
        }

        html { scroll-padding-top: 84px; }
        body.landing-body {
            background: var(--page-bg);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6,
        .landing-banner-heading { font-family: 'Manrope', sans-serif; letter-spacing: -0.035em; }
        .section { padding-block: clamp(4rem, 7vw, 7rem); }
        .section-bg { background: #f2f6f3 !important; }

        .landing-banner {
            min-height: calc(100vh - 84px);
            display: flex;
            align-items: center;
            background:
                radial-gradient(circle at 82% 12%, rgba(71, 151, 104, .22), transparent 25%),
                linear-gradient(125deg, #082a1c 0%, #0d3725 55%, #12442e 100%) !important;
            padding-top: 82px !important;
            position: relative;
            overflow: hidden;
        }
        .landing-banner .section { width: 100%; padding: 3.25rem 0 !important; }
        .landing-body .landing-banner .main-banner-container { padding: 0 1.5rem !important; }
        .landing-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            width: auto;
            height: auto;
            background-color: transparent !important;
            background-image: radial-gradient(rgba(255,255,255,.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: .18;
            pointer-events: none;
        }
        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem .9rem;
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            color: #dcece2;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .1em;
        }
        .hero-kicker::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--accent-color); }
        .landing-body .landing-banner .landing-banner-heading {
            max-width: 760px;
            font-size: clamp(3rem, 5vw, 4.5rem);
            font-weight: 800 !important;
            line-height: 1.04;
            color: #ffffff;
            text-wrap: balance;
            text-shadow: none;
        }
        .hero-highlight { color: #f7c965; }
        .hero-copy { max-width: 650px; font-size: 1.12rem; line-height: 1.75; color: rgba(255,255,255,.72); }
        .hero-actions .btn {
            min-height: 54px;
            display: inline-flex;
            align-items: center;
            border-radius: 12px;
            padding: .8rem 1.25rem;
            font-size: .95rem;
            font-weight: 700;
        }
        .hero-actions .btn-primary { background: var(--accent-color) !important; border-color: var(--accent-color) !important; color: #172219 !important; box-shadow: 0 12px 34px rgba(243,179,61,.22); }
        .hero-actions .btn-primary:hover { background: #ffc85a !important; transform: translateY(-2px); }
        .hero-actions .btn-outline-light { border-color: rgba(255,255,255,.28) !important; background: rgba(255,255,255,.04); }
        .hero-trust { display: flex; flex-wrap: wrap; gap: .7rem 1.4rem; color: rgba(255,255,255,.74); font-size: .88rem; }
        .hero-trust span { display: inline-flex; align-items: center; gap: .45rem; }
        .hero-trust i { color: #8fd2a8; font-size: 1rem; }
        .hero-visual { position: relative; padding: 10px 12px 10px 24px; }
        .hero-photo-frame {
            position: relative;
            overflow: hidden;
            min-height: 460px;
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 28px;
            background: rgba(255,255,255,.08);
            box-shadow: 0 30px 70px rgba(0,0,0,.3);
        }
        .hero-photo-frame img { width: 100%; height: 460px; object-fit: cover; object-position: 50% center; }
        .hero-photo-frame::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 55%, rgba(6,25,17,.48)); }
        .hero-price-card {
            position: absolute;
            z-index: 3;
            left: -4px;
            bottom: 34px;
            padding: 1rem 1.1rem;
            width: 210px;
            text-align: left;
            background: rgba(255,255,255,.96);
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0,0,0,.2);
        }
        .hero-price-card small { color: var(--muted); }
        .hero-price-card strong { display: block; color: var(--ink); font-family: 'Manrope', sans-serif; font-size: 1.05rem; }
        .hero-rating { position: absolute; z-index: 3; right: -2px; top: 34px; padding: .65rem .85rem; border-radius: 999px; background: #fff; color: var(--ink); font-weight: 700; box-shadow: 0 14px 35px rgba(0,0,0,.18); }
        .hero-rating i { color: var(--accent-color); }

        .landing-section-heading {
            display: inline-block;
            color: #27724b !important;
            font-weight: 800;
            letter-spacing: .14em;
        }
        .section-intro { max-width: 680px; margin-inline: auto; }
        .section-intro h2, .section-intro h3 { font-size: clamp(2rem, 3.2vw, 3rem); line-height: 1.12; }
        .category-grid { margin-top: 2.25rem; }
        .category-tile { position: relative; display: flex; min-height: 210px; padding: 1.5rem; overflow: hidden; color: var(--ink); text-align: left; text-decoration: none; background: #fff; border: 1px solid var(--border); border-radius: 20px; box-shadow: 0 12px 38px rgba(20,34,27,.06); transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
        .category-tile:hover { color: var(--ink); transform: translateY(-5px); border-color: #bfd7c6; box-shadow: 0 22px 50px rgba(20,34,27,.11); }
        .category-tile--dark { color: #fff; background: linear-gradient(145deg, #0d3725, #18543a); border-color: transparent; }
        .category-tile--dark:hover { color: #fff; }
        .category-tile--gold { background: linear-gradient(145deg, #fff8e8, #f9e4b4); }
        .category-tile__content { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: flex-start; }
        .category-tile__count { padding: .35rem .65rem; border-radius: 999px; background: rgba(18,63,43,.08); color: #27724b; font-size: .72rem; font-weight: 800; }
        .category-tile--dark .category-tile__count { color: #dff2e5; background: rgba(255,255,255,.1); }
        .category-tile h4 { margin: auto 0 .25rem; font-size: 1.5rem; }
        .category-tile__link { font-size: .82rem; font-weight: 700; opacity: .72; }
        .category-tile__icon { position: absolute; right: 1.25rem; top: 1.3rem; font-size: 4.75rem; opacity: .1; transform: rotate(-8deg); }
        .text-fixed-white {
            color: #ffffff !important;
        }
        .landing-body .section h2, .landing-body .section h3 { color: var(--ink); font-weight: 800 !important; }
        .landing-body .text-muted { color: var(--muted) !important; }
        .category-filter { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: .55rem; box-shadow: 0 8px 30px rgba(20,34,27,.05); }
        .category-btn { border: 0 !important; border-radius: 10px !important; color: #415047 !important; padding: .75rem 1rem; }
        .category-btn.active, .category-btn:hover { background: var(--primary-color) !important; color: #fff !important; }
        .phone-card {
            background: #fff;
            transition: transform .25s ease, box-shadow .25s ease;
            border: 1px solid var(--border) !important;
            box-shadow: 0 10px 35px rgba(20,34,27,.06);
            border-radius: 20px !important;
            overflow: hidden;
            padding: .75rem !important;
            text-align: left !important;
        }
        .phone-card img { width: 100%; height: 250px !important; padding: 1rem; margin-bottom: 1rem !important; background: #f5f7f5; border-radius: 14px !important; object-fit: contain !important; }
        .phone-card:hover { transform: translateY(-6px); box-shadow: 0 22px 50px rgba(20,34,27,.12); }
        .phone-card__body { display: flex; flex: 1; flex-direction: column; padding: .25rem .5rem .5rem; }
        .phone-card__meta { color: #27724b; font-size: .7rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
        .phone-card__name { min-height: 2.6rem; margin: .45rem 0 .8rem; font-size: 1rem; line-height: 1.35; }
        .phone-card__name a { color: var(--ink); }
        .phone-card__name a:hover { color: #27724b; }
        .phone-card__price { margin: 0; color: var(--ink); font-family: 'Manrope', sans-serif; font-size: 1.35rem; font-weight: 800; letter-spacing: -.03em; }
        .phone-card__action { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding: .8rem .9rem; border-radius: 11px; background: var(--primary-light); color: var(--primary-color); font-size: .86rem; font-weight: 800; }
        .phone-card__action:hover { background: var(--primary-color); color: #fff; }
        .dashboard-image-placeholder { display: grid; width: 100%; height: 250px; margin-bottom: 1rem; place-items: center; color: #8b9890; text-align: center; background: #f3f6f4; border-radius: 14px; }
        .dashboard-image-placeholder i { display: block; margin-bottom: .4rem; color: #aab5ae; font-size: 2.4rem; }
        .dashboard-image-placeholder span { font-size: .75rem; font-weight: 700; }
        #testimonials { background: #fff !important; }
        .about-photo { width: 100%; height: 500px; object-fit: cover; border-radius: 24px !important; box-shadow: 0 24px 60px rgba(20,34,27,.13); }
        .floating-whatsapp { position: fixed; z-index: 999; right: 22px; bottom: 22px; display: inline-flex; align-items: center; gap: .55rem; padding: .85rem 1rem; color: #fff; background: #1f9d55; border-radius: 999px; box-shadow: 0 16px 38px rgba(13,94,49,.3); font-weight: 800; text-decoration: none; }
        .floating-whatsapp:hover { color: #fff; background: #168447; transform: translateY(-2px); }
        .stat-card, .testimonial-card, .contact-card, .landing-missions { border: 1px solid var(--border) !important; border-radius: 18px !important; box-shadow: 0 10px 34px rgba(20,34,27,.05) !important; }
        .alert-info { color: #25583c; background: #edf7f0; border-color: #d5eadb; border-radius: 14px; }
        .accordion-item { margin-bottom: .75rem; overflow: hidden; border: 1px solid var(--border) !important; border-radius: 14px !important; }
        .accordion-button { font-weight: 700; }
        .accordion-button:not(.collapsed) { color: var(--primary-color); background: var(--primary-light); box-shadow: none; }
        .form-control { border-color: var(--border); border-radius: 10px; padding: .75rem .9rem; }
        .landing-footer { background: #0b2b1d !important; }
        .deferred-styles {
            display: none;
        }

        @media (max-width: 768px) {
            .landing-banner { min-height: auto; padding-top: 100px !important; }
            .landing-body .landing-banner .landing-banner-heading { font-size: clamp(2.65rem, 12vw, 4rem); }
            .hero-photo-frame, .hero-photo-frame img { min-height: 420px; height: 420px; }
            .hero-visual { margin-top: 2rem; padding-inline: 8px; }
            .hero-price-card { left: -4px; }
            .floating-element {
                display: none;
            }
        }
        @media (max-width: 576px) {
            .section { padding-block: 4rem; }
            .hero-actions { display: grid !important; }
            .hero-actions .btn { justify-content: center; width: 100%; }
            .hero-photo-frame, .hero-photo-frame img { min-height: 350px; height: 350px; }
            .about-photo { height: 340px; }
            .floating-whatsapp span { display: none; }
        }
    </style>
    
    <noscript>
        <style>
            .phone-card:hover { transform: none; }
            .floating-animation { animation: none; }
        </style>
    </noscript>
@endsection

@section('content')
    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row align-items-center g-5">
                    <div class="col-xl-7 col-lg-7">
                        <div class="py-lg-5 position-relative">
                            <div class="mb-4">
                                <span class="hero-kicker">PHONES MADE ACCESSIBLE</span>
                            </div>
                            <h1 class="landing-banner-heading mb-4">
                                Your next phone, <span class="hero-highlight">made affordable.</span>
                            </h1>
                            <p class="hero-copy mb-4">
                                Shop genuine smartphones at competitive prices, explore flexible payment options, and confirm delivery with our team.
                            </p>
                            <div class="hero-actions d-flex flex-wrap gap-3">
                                <a href="{{ route('pricing') }}" class="btn btn-primary">
                                    Explore phones <i class="ri-arrow-right-line ms-2"></i>
                                </a>
                                <a href="{{ $whatsappBase . urlencode('Hello Phone Express, I would like help choosing a phone.') }}" target="_blank" rel="noopener" class="btn btn-outline-light">
                                    <i class="ri-whatsapp-line me-2"></i> Talk to us
                                </a>
                            </div>
                            <div class="hero-trust mt-4 pt-2">
                                <span><i class="ri-shield-check-line"></i> Quality checked</span>
                                <span><i class="ri-bank-card-line"></i> Flexible payments</span>
                                <span><i class="ri-truck-line"></i> Delivery options</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="hero-visual">
                            <div class="hero-photo-frame">
                                <img src="{{ $landingImage }}" alt="A selection of premium smartphones at Phone Express" width="640" height="720" fetchpriority="high">
                            </div>
                            <div class="hero-rating"><i class="ri-star-fill me-1"></i> Trusted locally</div>
                            <div class="hero-price-card">
                                <small>Need help choosing?</small>
                                <strong>Tell us your budget</strong>
                                <span class="text-success fs-12">We’ll find your best match</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End:: Section-1 -->

    <!-- Start:: Categories Section -->
    <section class="section section-bg" id="categories">
        <div class="container text-center">
            <div class="section-intro">
                <p class="fs-12 fw-semibold text-success mb-2"><span class="landing-section-heading">SHOP BY CATEGORY</span></p>
                <h3 class="fw-semibold mb-3">Find the right phone, faster.</h3>
                <p class="text-muted fs-15 mb-0">Start with your preferred brand or browse the complete collection.</p>
            </div>
            <div class="row g-4 category-grid">
                <div class="col-lg-4">
                    <a href="{{ route('pricing', ['brand' => 'Apple']) }}" class="category-tile category-tile--dark">
                        <div class="category-tile__content"><span class="category-tile__count">{{ $categories['iphone'] ?? 0 }} MODELS</span><h4>Apple iPhone</h4><span class="category-tile__link">Browse iPhones <i class="ri-arrow-right-line ms-1"></i></span></div>
                        <i class="ri-apple-fill category-tile__icon"></i>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{ route('pricing', ['brand' => 'Samsung']) }}" class="category-tile category-tile--gold">
                        <div class="category-tile__content"><span class="category-tile__count">{{ $categories['samsung'] ?? 0 }} MODELS</span><h4>Samsung Galaxy</h4><span class="category-tile__link">Browse Samsung <i class="ri-arrow-right-line ms-1"></i></span></div>
                        <i class="ri-android-fill category-tile__icon"></i>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{ route('pricing') }}" class="category-tile">
                        <div class="category-tile__content"><span class="category-tile__count">{{ $categories['all'] ?? 0 }} PHONES</span><h4>All smartphones</h4><span class="category-tile__link">View collection <i class="ri-arrow-right-line ms-1"></i></span></div>
                        <i class="ri-smartphone-line category-tile__icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Categories Section -->

    <!-- Top-End Smartphones Pricing Section -->
    <section class="section" id="pricing">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">FEATURED PHONES</span>
            </p>
            <h3 class="fw-semibold mb-2">Get your favorite smartphone at the most affordable rates.</h3>
            <div class="row justify-content-center mb-4">
                <div class="col-xl-9">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        Choose your smartphone and payment method — Full Payment or Lipa PolePole (installments).
                    </p>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="alert alert-info mb-4 text-start">
                <i class="ri-truck-line me-2"></i>
                <strong>Delivery details:</strong> Share your location with our team to confirm availability, charges and timing before payment.
                <a href="{{ route('policies.show', 'delivery') }}" class="ms-1 fw-semibold">Read delivery guidance</a>
            </div>

            <!-- Payment Method Tabs -->
            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-tabs mb-3 tab-style-6 bg-primary-transparent" id="paymentMethodTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="full-payment-tab" data-bs-toggle="tab"
                            data-bs-target="#full-payment" type="button" role="tab" aria-controls="full-payment"
                            aria-selected="true">
                            <i class="ri-money-dollar-circle-line me-1"></i> Full Payment
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lipa-tab" data-bs-toggle="tab" data-bs-target="#lipa-polepole"
                            type="button" role="tab" aria-controls="lipa-polepole" aria-selected="false">
                            <i class="ri-calendar-check-line me-1"></i> Lipa PolePole
                            <span class="badge bg-warning ms-1">iPhone Only</span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="paymentMethodContent">

                <!-- Full Payment -->
                <div class="tab-pane show active fade" id="full-payment" role="tabpanel" aria-labelledby="full-payment-tab">
                    @if($fullPhonesOptimized->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($fullPhonesOptimized as $phone)
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="phone-card h-100 d-flex flex-column">
                                    @if($phone->image_available)
                                        <img src="{{ $phone->image_url }}" alt="{{ $phone->name }}" class="img-fluid" loading="lazy">
                                    @else
                                        <div class="dashboard-image-placeholder"><div><i class="ri-image-line"></i><span>Image coming soon</span></div></div>
                                    @endif
                                    <div class="phone-card__body">
                                        <span class="phone-card__meta">Pay in full</span>
                                        <h6 class="phone-card__name"><a href="{{ route('phones.show', $phone) }}">{{ $phone->name }}</a></h6>
                                        <p class="phone-card__price">KES {{ number_format($phone->price) }}</p>
                                        <a href="{{ $phone->whatsapp_url }}" target="_blank" rel="noopener" class="phone-card__action"><span>Enquire on WhatsApp</span><i class="ri-arrow-right-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pricing') }}" class="btn btn-primary">
                            <i class="ri-eye-line me-2"></i> View All Phones
                        </a>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="ri-information-line me-2"></i>
                        No phones available for full payment at the moment.
                    </div>
                    @endif
                </div>

                <!-- Lipa PolePole - iPhone Only -->
                <div class="tab-pane fade" id="lipa-polepole" role="tabpanel" aria-labelledby="lipa-tab">
                    @if($lipaPhonesOptimized->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($lipaPhonesOptimized as $phone)
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="phone-card h-100 d-flex flex-column position-relative">
                                    <span class="lipa-polepole-badge">Lipa PolePole</span>
                                    @if($phone->image_available)
                                        <img src="{{ $phone->image_url }}" alt="{{ $phone->name }}" class="img-fluid" loading="lazy">
                                    @else
                                        <div class="dashboard-image-placeholder"><div><i class="ri-image-line"></i><span>Image coming soon</span></div></div>
                                    @endif
                                    <div class="phone-card__body">
                                        <span class="phone-card__meta">40% upfront, then 12 weekly payments</span>
                                        <h6 class="phone-card__name"><a href="{{ route('phones.show', $phone) }}">{{ $phone->name }}</a></h6>
                                        <p class="phone-card__price">KES {{ number_format($phone->lipa_installment ?? 0) }} <small class="fs-12 text-muted">/ week</small></p>
                                        <a href="{{ $phone->whatsapp_url }}" target="_blank" rel="noopener" class="phone-card__action"><span>Ask about this plan</span><i class="ri-arrow-right-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pricing') }}?payment_method=lipa" class="btn btn-primary">
                            <i class="ri-smartphone-line me-2"></i> View All iPhones
                        </a>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="ri-information-line me-2"></i>
                        No iPhones available for Lipa PolePole at the moment. Check back soon!
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <!-- Start:: Section-2 -->
    <section class="section section-bg" id="statistics">
        <div class="container text-center position-relative">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">STATISTICS</span>
            </p>
            <h3 class="fw-semibold mb-2">Serving thousands of happy customers every year!</h3>
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        At Phone Express, we pride ourselves on delivering the latest smartphones with flexible payment
                        options like <strong>Lipa PolePole</strong>. Here's a glimpse of our growth and trust among our
                        clients.
                    </p>
                </div>
            </div>
            <div class="row g-2 justify-content-center">
                <div class="col-xl-12">
                    <div class="row justify-content-evenly">
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-mobile'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">{{ number_format($statistics['phones_sold']) }}+</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Phones Sold
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-user-plus'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">{{ number_format($statistics['happy_customers']) }}+</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Happy Customers
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-store-alt'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">{{ $statistics['branches'] }}</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Branches
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-calendar'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">{{ $statistics['years_experience'] }}+</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Years of Experience
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-2 -->

    <!-- Start:: Section-3 -->
    <section class="section" id="about">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">WHY CHOOSE US</span>
            </p>
            <h3 class="fw-semibold mb-2">Premium Phones, Flexible Payments</h3>
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-3 fw-normal">
                        Phone Express offers a wide selection of smartphones and accessories, all at competitive prices.
                        Enjoy the convenience of our <strong>Lipa PolePole</strong> plan and shop with confidence.
                    </p>
                </div>
            </div>
            <div class="row justify-content-between align-items-center mx-0">
                <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                    <div class="text-lg-end">
                        <img src="{{ $aboutImage }}" alt="A selection of phones from Phone Express" class="about-photo" loading="lazy" width="500" height="500">
                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6 pt-5 pb-0 px-lg-2 px-5 text-start">
                    <h5 class="text-lg-start fw-semibold mb-0">Experience Shopping Like Never Before</h5>
                    <p class="text-muted">
                        We make it simple to find the perfect phone and pay in a way that suits you.
                    </p>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="d-flex mb-3">
                                <span>
                                    <i class='bx bxs-badge-check text-primary fs-18'></i>
                                </span>
                                <div class="ms-2">
                                    <h6 class="fw-semibold mb-0">Flexible Installments with Lipa PolePole</h6>
                                    <p class="text-muted">Ask our team about eligibility and the confirmed payment schedule for your chosen phone.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="d-flex mb-3">
                                <span>
                                    <i class='bx bxs-badge-check text-primary fs-18'></i>
                                </span>
                                <div class="ms-2">
                                    <h6 class="fw-semibold mb-0">Wide Selection of Latest Smartphones</h6>
                                    <p class="text-muted">Choose from the latest models from top brands at competitive
                                        prices.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="d-flex mb-3">
                                <span>
                                    <i class='bx bxs-badge-check text-primary fs-18'></i>
                                </span>
                                <div class="ms-2">
                                    <h6 class="fw-semibold mb-0">Easy Online and In-Store Shopping</h6>
                                    <p class="text-muted">Shop at your convenience, whether online or at one of our
                                        branches.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-3 -->

    <!-- Start:: Section-4 -->
    <section class="section section-bg" id="our-mission">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">OUR MISSION</span>
            </p>
            <h2 class="fw-semibold mb-2">Our mission is to make phones accessible to everyone.</h2>
            <div class="row justify-content-center mb-5">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-0 fw-normal">
                        At Phone Express, we aim to provide the latest smartphones, excellent customer service, and flexible
                        payment options like <strong>Lipa PolePole</strong> to make owning a phone simple and affordable.
                    </p>
                </div>
            </div>
            <div class="row">
                @foreach([
                    ['icon' => 'bx-mobile', 'title' => 'Latest Smartphones', 'desc' => 'We offer the newest phone models from top brands to keep you ahead in technology.'],
                    ['icon' => 'bx-money', 'title' => 'Flexible Payments', 'desc' => 'View an estimate, then confirm eligibility and the final payment schedule with our team.'],
                    ['icon' => 'bx-support', 'title' => 'Excellent Support', 'desc' => 'Our team is available to help you choose the right phone and resolve any issues.'],
                    ['icon' => 'bx-store-alt', 'title' => 'Wide Selection', 'desc' => 'From premium to budget-friendly phones, we have options for every customer.'],
                    ['icon' => 'bx-calendar', 'title' => 'Trusted Experience', 'desc' => 'Years of serving customers and building trust in the mobile phone market.'],
                    ['icon' => 'bx-store', 'title' => 'Multiple Branches', 'desc' => 'Convenient locations to shop in person or get support whenever you need.'],
                    ['icon' => 'bx-star', 'title' => 'Quality Assurance', 'desc' => 'All phones are checked to ensure the highest quality standards for our customers.'],
                    ['icon' => 'bx-desktop', 'title' => 'Seamless Online Experience', 'desc' => 'Shop online with ease, track your orders, and enjoy home delivery options.']
                ] as $mission)
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions h-100">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx {{ $mission['icon'] }} fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $mission['title'] }}</h6>
                                    <p class="mb-0 text-muted">{{ $mission['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End:: Section-4 -->

    <!-- Start:: Section-6 -->
    <section class="section landing-testimonials section-bg" id="testimonials">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">TESTIMONIALS</span>
            </p>
            <h3 class="fw-semibold mb-2">Our customers love Phone Express!</h3>
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        Here's what some of our happy customers say about buying their phones and using our flexible payment
                        plans.
                    </p>
                </div>
            </div>
            <div class="swiper pagination-dynamic text-start">
                <div class="swiper-wrapper">
                    @foreach([
                        ['name' => 'Nancy Wambui', 'role' => 'Entrepreneur', 'img' => '15.jpg', 'testimonial' => 'I love my new phone from Phone Express! The Lipa PolePole plan made it so easy to afford.', 'rating' => 4.5, 'time' => '3 days ago'],
                        ['name' => 'James Mwangi', 'role' => 'Student', 'img' => '4.jpg', 'testimonial' => 'Great service and very helpful staff. My phone arrived quickly and the installment plan is very convenient.', 'rating' => 4.5, 'time' => '1 week ago'],
                        ['name' => 'Alice Njeri', 'role' => 'Freelancer', 'img' => '2.jpg', 'testimonial' => 'Amazing variety of phones and excellent customer support. I recommend Phone Express to everyone.', 'rating' => 5, 'time' => '2 weeks ago']
                    ] as $testimonial)
                    <div class="swiper-slide">
                        <div class="card custom-card testimonial-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md avatar-rounded me-3">
                                        <img src="{{ asset('build/assets/images/faces/' . $testimonial['img']) }}" alt="{{ $testimonial['name'] }}" loading="lazy">
                                    </span>
                                    <div>
                                        <p class="mb-0 fw-semibold fs-14">{{ $testimonial['name'] }}</p>
                                        <p class="mb-0 fs-10 fw-semibold text-muted">{{ $testimonial['role'] }}</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted">
                                        {{ $testimonial['testimonial'] }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted">Rating: </span>
                                        <span class="text-warning d-block ms-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($testimonial['rating']))
                                                    <i class="ri-star-fill"></i>
                                                @elseif($i == ceil($testimonial['rating']) && $testimonial['rating'] != floor($testimonial['rating']))
                                                    <i class="ri-star-half-fill"></i>
                                                @else
                                                    <i class="ri-star-line"></i>
                                                @endif
                                            @endfor
                                        </span>
                                    </div>
                                    <div class="float-end fs-12 fw-semibold text-muted text-end">
                                        <span>{{ $testimonial['time'] }}</span>
                                        <span class="d-block fw-normal fs-12 text-success"><i>{{ $testimonial['name'] }}</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>
    <!-- End:: Section-6 -->

    <!-- Start:: Section-9 -->
    <section class="section section-bg" id="faq">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">F.A.Q</span>
            </p>
            <h3 class="fw-semibold mb-2">Frequently Asked Questions</h3>
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        Here are some of the most common questions our customers ask about Phone Express Kenya.
                    </p>
                </div>
            </div>
            <div class="row text-start">
                <div class="col-xl-12">
                    <div class="row gy-2">
                        <!-- Left Column -->
                        <div class="col-xl-6">
                            <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                id="accordionFAQ1">
                                @foreach([
                                    ['id' => 'One', 'question' => 'What types of phones do you sell?', 'answer' => 'At Phone Express Kenya, we offer a wide range of top-end smartphones including iPhones (10, 11, 12, 13, 14, 15, 16), Samsung Galaxy, and other premium devices. You can choose between Brand New, UK Used, or US Used phones.', 'show' => true],
                                    ['id' => 'Two', 'question' => 'Can I pay in installments (Lipa PolePole)?', 'answer' => 'Payment-plan estimates are shown for eligible catalogue items. Our team must confirm eligibility, requirements and the final schedule before payment.', 'show' => false],
                                    ['id' => 'Three', 'question' => 'Do your phones come with a warranty?', 'answer' => 'Warranty terms can vary by device and condition. Ask our team to confirm the exact written coverage for the phone you choose.', 'show' => false]
                                ] as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon1{{ $faq['id'] }}">
                                        <button class="accordion-button {{ !$faq['show'] ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon1{{ $faq['id'] }}" aria-expanded="{{ $faq['show'] ? 'true' : 'false' }}"
                                            aria-controls="collapsecustomicon1{{ $faq['id'] }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon1{{ $faq['id'] }}" class="accordion-collapse collapse {{ $faq['show'] ? 'show' : '' }}"
                                        aria-labelledby="headingcustomicon1{{ $faq['id'] }}" data-bs-parent="#accordionFAQ1">
                                        <div class="accordion-body">
                                            {!! $faq['answer'] !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-xl-6">
                            <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                id="accordionFAQ2">
                                @foreach([
                                    ['id' => 'One', 'question' => 'How do I place an order?', 'answer' => 'You can place your order directly on our website, via WhatsApp, or by visiting our physical store. No account is required to buy.', 'show' => false],
                                    ['id' => 'Two', 'question' => 'Do you offer delivery?', 'answer' => 'Share your destination with our team so they can confirm delivery availability, charges and expected timing for your order.', 'show' => false],
                                    ['id' => 'Three', 'question' => 'Can I return or exchange my phone?', 'answer' => 'Contact our team before returning a device. They will review the phone, purchase details and applicable terms before confirming eligibility and next steps.', 'show' => false]
                                ] as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon2{{ $faq['id'] }}">
                                        <button class="accordion-button {{ !$faq['show'] ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon2{{ $faq['id'] }}" aria-expanded="{{ $faq['show'] ? 'true' : 'false' }}"
                                            aria-controls="collapsecustomicon2{{ $faq['id'] }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon2{{ $faq['id'] }}" class="accordion-collapse collapse {{ $faq['show'] ? 'show' : '' }}"
                                        aria-labelledby="headingcustomicon2{{ $faq['id'] }}" data-bs-parent="#accordionFAQ2">
                                        <div class="accordion-body">
                                            {!! $faq['answer'] !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-9 -->

    <!-- Start:: Section-10 -->
    <section class="section" id="contact">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">CONTACT US</span>
            </p>
            <h3 class="fw-semibold mb-2">Have any questions? We would love to hear from you.</h3>
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        You can reach us anytime regarding any queries or deals. Don't hesitate to clear your doubts before
                        getting your next phone.
                    </p>
                    <p class="fw-semibold text-dark">
                        📍 Kimathi House, Suite 507, 5th Floor, Opposite Sarova Stanley Hotel, Kimathi Street, Nairobi CBD
                    </p>
                </div>
            </div>
            <div class="row text-start">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card custom-card border shadow-none contact-card h-100">
                        <div class="card-body p-0">
                            <iframe
                                src="https://www.google.com/maps?q=Kimathi+House,+Suite+507,+5th+Floor,+Opposite+Sarova+Stanley+Hotel,+Kimathi+Street,+Nairobi+CBD&output=embed"
                                height="365" style="border:0;width:100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" title="Phone Express Location"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card custom-card overflow-hidden section-bg border overflow-hidden shadow-none contact-card h-100">
                        <div class="card-body">
                            <div class="row gy-3 mt-2 px-3">
                                <div class="col-xl-6">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label for="contact-name" class="form-label">Full Name :</label>
                                            <input type="text" class="form-control" id="contact-name"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="contact-phone" class="form-label">Phone No :</label>
                                            <input type="text" class="form-control" id="contact-phone"
                                                placeholder="Enter Phone No">
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="contact-address" class="form-label">Address :</label>
                                            <textarea class="form-control" id="contact-address" rows="1" placeholder="Enter your address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label for="contact-message" class="form-label">Message :</label>
                                    <textarea class="form-control" id="contact-message" rows="8"
                                        placeholder="Write your message..."></textarea>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex mt-4">
                                        <div>
                                            <div class="btn-list">
                                                <a href="https://www.facebook.com/" target="_blank"
                                                    class="btn btn-icon btn-primary-light btn-wave">
                                                    <i class="ri-facebook-line fw-bold"></i>
                                                </a>
                                                <a href="https://twitter.com/" target="_blank"
                                                    class="btn btn-icon btn-primary-light btn-wave">
                                                    <i class="ri-twitter-line fw-bold"></i>
                                                </a>
                                                <a href="https://instagram.com/" target="_blank"
                                                    class="btn btn-icon btn-primary-light btn-wave">
                                                    <i class="ri-instagram-line fw-bold"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="https://wa.me/254721920545?text=Hello%20Phone%20Express,%20I%20would%20like%20to%20inquire%20about..."
                                                target="_blank" class="btn btn-success btn-wave">
                                                <i class="ri-whatsapp-line me-1"></i> Send via WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End:: Section-10 -->

    <!-- Start:: Section-11 -->
    <section class="section landing-footer text-fixed-white">
        <div class="container">
            <div class="row">
                <!-- Logo & About -->
                <div class="col-md-4 col-sm-6 col-12 mb-md-0 mb-3">
                    <div class="px-4">
                        <p class="fw-semibold mb-3">
                            <a href="{{ route('home') }}">
                                <img src="{{ $logoImage }}" alt="Phone Express Kenya"
                                    class="img-fluid" style="max-height: 60px;" loading="lazy">
                            </a>
                        </p>
                        <p class="mb-2 op-6 fw-normal">
                            At Phone Express Kenya, we bring you the latest iPhones, Samsungs, and other premium smartphones
                            at unbeatable prices. Choose between paying in full or using our flexible <strong>Lipa
                                PolePole</strong> plan.
                        </p>
                        <p class="mb-0 op-6 fw-normal">Trusted by thousands of happy customers across Kenya.</p>
                    </div>
                </div>

                <!-- Pages -->
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="px-4">
                        <h6 class="fw-semibold mb-3 text-fixed-white">PAGES</h6>
                        <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                            <li><a href="{{ route('pricing') }}" class="text-fixed-white">Shop</a></li>
                            <li><a href="{{ route('home') }}#about" class="text-fixed-white">About Us</a></li>
                            <li><a href="{{ route('home') }}#contact" class="text-fixed-white">Contact</a></li>
                            <li><a href="{{ route('home') }}#faq" class="text-fixed-white">FAQs</a></li>
                            <li><a href="{{ route('policies.index') }}" class="text-fixed-white">Shopping help</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Info -->
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="px-4">
                        <h6 class="fw-semibold text-fixed-white">INFO</h6>
                        <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                            <li><a href="{{ route('policies.show', 'payment-plans') }}" class="text-fixed-white">Payment plans</a></li>
                            <li><a href="{{ route('policies.show', 'delivery') }}" class="text-fixed-white">Delivery</a></li>
                            <li><a href="{{ route('policies.show', 'warranty') }}" class="text-fixed-white">Warranty</a></li>
                            <li><a href="{{ route('policies.show', 'returns') }}" class="text-fixed-white">Returns</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="px-4">
                        <h6 class="fw-semibold text-fixed-white">CONTACT</h6>
                        <ul class="list-unstyled fw-normal landing-footer-list">
                            <li>
                                <a href="tel:+254721920545" class="text-fixed-white op-6">
                                    <i class="ri-phone-line me-1 align-middle"></i> Call/WhatsApp: 0721920545
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/phoneexpresskenya._" target="_blank"
                                    class="text-fixed-white op-6">
                                    <i class="ri-instagram-line me-1 align-middle"></i> Instagram: @phoneexpresskenya._
                                </a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@phoneexpresskenya" target="_blank"
                                    class="text-fixed-white op-6">
                                    <i class="ri-tiktok-line me-1 align-middle"></i> TikTok: @phoneexpresskenya
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/PhoneExpressKe" target="_blank" class="text-fixed-white op-6">
                                    <i class="ri-twitter-line me-1 align-middle"></i> Twitter: @PhoneExpressKe
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-11 -->

    <a href="{{ $whatsappBase . urlencode('Hello Phone Express, I would like help choosing a phone.') }}"
       class="floating-whatsapp" target="_blank" rel="noopener" aria-label="Chat with Phone Express on WhatsApp">
        <i class="ri-whatsapp-line fs-18"></i><span>Chat with us</span>
    </a>

    <!-- Deferred non-critical styles -->
    <div class="deferred-styles">
        <style>
            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
                border: none !important;
                padding: 12px 30px;
                font-weight: 600;
                font-size: 1.1rem;
                box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(26, 71, 42, 0.4);
            }

            .btn-outline-light {
                border: 2px solid rgba(255, 255, 255, 0.3) !important;
                color: #ffffff !important;
                padding: 12px 30px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
            }

            .btn-outline-light:hover {
                background-color: rgba(255, 255, 255, 0.1) !important;
                border-color: rgba(255, 255, 255, 0.5) !important;
                transform: translateY(-2px);
            }

            .floating-animation {
                animation: floatEnhanced 6s ease-in-out infinite;
            }

            @keyframes floatEnhanced {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                25% { transform: translateY(-15px) rotate(2deg); }
                50% { transform: translateY(-25px) rotate(0deg); }
                75% { transform: translateY(-15px) rotate(-2deg); }
            }

            .floating-element {
                position: absolute;
                animation: floatElementEnhanced 8s ease-in-out infinite;
                z-index: 2;
            }

            @keyframes floatElementEnhanced {
                0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
                25% { transform: translateY(-20px) rotate(5deg) scale(1.05); }
                50% { transform: translateY(-10px) rotate(0deg) scale(1); }
                75% { transform: translateY(-15px) rotate(-5deg) scale(1.03); }
            }

            .floating-badge {
                padding: 10px 18px;
                border-radius: 25px;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 8px 25px rgba(0,0,0,0.3);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
            }

            .floating-badge:hover {
                transform: scale(1.1);
                box-shadow: 0 12px 35px rgba(0,0,0,0.4);
            }

            .category-filter {
                background: var(--primary-light);
                border-radius: 15px;
                padding: 15px;
                margin-bottom: 30px;
            }

            .category-btn {
                border: 2px solid transparent;
                transition: all 0.3s ease;
                margin: 5px;
            }

            .category-btn.active, .category-btn:hover {
                background: var(--primary-color) !important;
                color: white !important;
                border-color: var(--primary-color);
                transform: translateY(-2px);
            }

            .phone-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            }

            .lipa-polepole-badge {
                background: linear-gradient(45deg, #ff6b35, #ff8e35);
                color: white;
                font-size: 0.7rem;
                padding: 3px 8px;
                border-radius: 10px;
                position: absolute;
                top: 10px;
                right: 10px;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }

            .testimonial-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }

            .contact-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }

            .nav-tabs .nav-link {
                padding: 12px 30px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .nav-tabs .nav-link.active {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
                border: none !important;
                color: white !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
            }

            .accordion-button:not(.collapsed) {
                background: var(--primary-light) !important;
                color: var(--primary-color) !important;
                box-shadow: none;
            }

            .accordion-button:focus {
                box-shadow: none;
                border-color: var(--primary-color);
            }

            .btn-primary-light {
                background: var(--primary-light);
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
                transition: all 0.3s ease;
            }

            .btn-primary-light:hover {
                background: var(--primary-color);
                color: white;
                transform: translateY(-2px);
            }
        </style>
    </div>
@endsection

@section('scripts')
    <!-- SWIPER JS - Load only if needed -->
    @if($fullPhonesOptimized->count() > 0 || $lipaPhonesOptimized->count() > 0)
    <script src="{{ asset('build/assets/libs/swiper/swiper-bundle.min.js') }}" defer></script>
    @endif

    <!-- INTERNAL LANDING JS -->
    @vite('resources/assets/js/landing.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load deferred styles
            loadDeferredStyles();
            
            // Initialize animations
            initAnimations();
            
            // Initialize category filtering
            initCategoryFiltering();
            
            // Initialize smooth scrolling
            initSmoothScrolling();
            
            // Initialize tab functionality
            initTabs();
            
            // Initialize testimonials swiper
            initTestimonialsSwiper();
        });
        
        function loadDeferredStyles() {
            const deferredStyles = document.querySelector('.deferred-styles');
            if (deferredStyles) {
                const styles = deferredStyles.innerHTML;
                const styleElement = document.createElement('style');
                styleElement.innerHTML = styles;
                document.head.appendChild(styleElement);
                deferredStyles.remove();
            }
            
            // Add floating badges after styles are loaded
            addFloatingBadges();
        }
        
        function addFloatingBadges() {
            const badgesContainer = document.querySelector('.floating-badges-container');
            if (!badgesContainer) return;
            
            const badges = [
                { top: '20%', left: '10%', text: 'iPhone', icon: 'ri-smartphone-line', color: 'bg-primary', delay: '0s' },
                { top: '60%', right: '15%', text: 'Samsung', icon: 'ri-android-line', color: 'bg-success', delay: '1.5s' },
                { bottom: '20%', left: '20%', text: 'Accessories', icon: 'ri-shopping-bag-line', color: 'bg-warning text-dark', delay: '3s' }
            ];
            
            badges.forEach(badge => {
                const element = document.createElement('div');
                element.className = 'floating-element';
                element.style.cssText = `${badge.top ? `top: ${badge.top};` : ''} ${badge.left ? `left: ${badge.left};` : ''} ${badge.right ? `right: ${badge.right};` : ''} animation-delay: ${badge.delay};`;
                
                const badgeElement = document.createElement('div');
                badgeElement.className = `floating-badge ${badge.color}`;
                badgeElement.innerHTML = `<i class="${badge.icon} me-1"></i>${badge.text}`;
                
                element.appendChild(badgeElement);
                badgesContainer.appendChild(element);
            });
        }
        
        function initAnimations() {
            // Add animation classes to elements as they come into view
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);
            
            // Observe elements that should animate
            document.querySelectorAll('.phone-card, .stat-card, .testimonial-card').forEach(el => {
                observer.observe(el);
            });
        }
        
        function initCategoryFiltering() {
            const categoryBtns = document.querySelectorAll('.category-btn');
            
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-category');
                    // In a real implementation, this would filter the displayed phones
                    console.log(`Filtering by category: ${category}`);
                    // You would make an AJAX call here to fetch filtered phones
                });
            });
        }
        
        function initSmoothScrolling() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;
                    
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }
        
        function initTabs() {
            // Handle tab switching
            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update URL hash without page reload
                    const tabId = this.getAttribute('data-bs-target');
                    if (tabId) {
                        history.pushState(null, null, tabId);
                    }
                });
            });
            
            // Restore tab from URL on page load
            const hash = window.location.hash;
            if (hash && (hash === '#full-payment' || hash === '#lipa-polepole')) {
                const tab = document.querySelector(`[data-bs-target="${hash}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }
        }
        
        function initTestimonialsSwiper() {
            if (typeof Swiper !== 'undefined' && document.querySelector('.swiper')) {
                new Swiper('.swiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                        },
                        992: {
                            slidesPerView: 3,
                        }
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                });
            }
        }
        
        // Phone card hover effects
        document.querySelectorAll('.phone-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Statistics counter animation
        const statCards = document.querySelectorAll('.stat-card h3');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalValue = parseInt(target.textContent.replace(/,/g, ''));
                    const suffix = target.textContent.includes('+') ? '+' : '';
                    
                    let current = 0;
                    const increment = finalValue / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= finalValue) {
                            current = finalValue;
                            clearInterval(timer);
                        }
                        target.textContent = Math.floor(current).toLocaleString() + suffix;
                    }, 20);
                    
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        statCards.forEach(card => observer.observe(card));
    </script>
@endsection
