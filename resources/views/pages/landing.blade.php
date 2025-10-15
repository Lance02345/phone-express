@extends('layouts.landing-master')

@section('styles')
    <!-- SWIPERJS CSS -->
    <link rel="stylesheet" href="{{asset('build/assets/libs/swiper/swiper-bundle.min.css')}}">

    <style>
        /* Enhanced Hero Section Animations */
        .landing-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            padding-top: 120px !important;
            position: relative;
            overflow: hidden;
        }

        .landing-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .landing-banner-heading {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: fadeInUp 1s ease-out;
        }

        .text-secondary {
            color: #e8f5e9 !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .text-fixed-white {
            color: #ffffff !important;
        }

        .op-7 {
            opacity: 0.9 !important;
        }

        .op-8 {
            opacity: 0.8 !important;
        }

        .op-9 {
            opacity: 1 !important;
        }

        .landing-banner .fs-16 {
            font-size: 1.2rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 400;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            border: none !important;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out 0.4s both;
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
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
        }

        /* Enhanced Floating Animations */
        .floating-animation {
            animation: floatEnhanced 6s ease-in-out infinite;
        }

        @keyframes floatEnhanced {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-15px) rotate(2deg);
            }
            50% {
                transform: translateY(-25px) rotate(0deg);
            }
            75% {
                transform: translateY(-15px) rotate(-2deg);
            }
        }

        /* Enhanced Floating Elements */
        .floating-element {
            position: absolute;
            animation: floatElementEnhanced 8s ease-in-out infinite;
            z-index: 2;
        }

        .element-1 {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .element-2 {
            top: 60%;
            right: 15%;
            animation-delay: 1.5s;
        }

        .element-3 {
            bottom: 20%;
            left: 20%;
            animation-delay: 3s;
        }

        @keyframes floatElementEnhanced {
            0%, 100% {
                transform: translateY(0px) rotate(0deg) scale(1);
            }
            25% {
                transform: translateY(-20px) rotate(5deg) scale(1.05);
            }
            50% {
                transform: translateY(-10px) rotate(0deg) scale(1);
            }
            75% {
                transform: translateY(-15px) rotate(-5deg) scale(1.03);
            }
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

        /* Enhanced Features List */
        .features-list {
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Categories Section */
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

        .phone-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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

        .delivery-info {
            background: var(--primary-light);
            border-left: 4px solid var(--primary-color);
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Enhanced Pricing Tabs */
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

        /* Enhanced Statistics */
        .stat-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Enhanced Testimonials */
        .testimonial-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Enhanced FAQ */
        .accordion-button:not(.collapsed) {
            background: var(--primary-light) !important;
            color: var(--primary-color) !important;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }

        /* Enhanced Contact Form */
        .contact-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .landing-banner-heading {
                font-size: 2.5rem;
            }
            
            .landing-banner .fs-16 {
                font-size: 1.1rem;
            }
            
            .btn-primary,
            .btn-outline-light {
                padding: 10px 24px;
                font-size: 1rem;
            }
            
            .floating-element {
                display: none;
            }
            
            .landing-main-image {
                margin-top: 2rem;
            }
            
            .category-filter {
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {
            .landing-banner-heading {
                font-size: 2rem;
            }
            
            .landing-banner {
                padding-top: 100px !important;
            }
            
            .d-flex.flex-wrap {
                flex-direction: column;
                gap: 1rem !important;
            }
            
            .btn-primary,
            .btn-outline-light {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row align-items-center">
                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                        <div class="py-lg-5">
                            <div class="mb-3">
                                <h5 class="fw-semibold text-fixed-white op-9">PHONES MADE ACCESSIBLE</h5>
                            </div>
                            <h1 class="landing-banner-heading mb-3">
                                Get your dream phone today with <span class="text-secondary">Phone Express!</span>
                            </h1>
                            <div class="fs-16 mb-5 text-fixed-white op-7">
                                Phone Express brings you the latest smartphones at unbeatable prices. Enjoy flexible payment
                                with our <strong class="text-secondary">Lipa Mdogo Mdogo</strong> option and take home your phone today without
                                breaking the bank.
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('pricing') }}" class="btn btn-primary btn-lg">
                                    Shop Now
                                    <i class="ri-shopping-bag-line ms-2 align-middle"></i>
                                </a>
                                <a href="#categories" class="btn btn-outline-light btn-lg">
                                    Browse Categories
                                    <i class="ri-arrow-down-line ms-2 align-middle"></i>
                                </a>
                            </div>
                            <div class="mt-4 d-flex align-items-center text-fixed-white op-8 features-list">
                                <div class="d-flex align-items-center me-4">
                                    <i class="ri-checkbox-circle-fill text-secondary me-2"></i>
                                    <span>Latest Models</span>
                                </div>
                                <div class="d-flex align-items-center me-4">
                                    <i class="ri-checkbox-circle-fill text-secondary me-2"></i>
                                    <span>Flexible Payments</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ri-checkbox-circle-fill text-secondary me-2"></i>
                                    <span>Free Nairobi Delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
                        <div class="text-end landing-main-image landing-heading-img position-relative">
                            <img src="{{asset('build/assets/images/media/landing/phones.png')}}" alt="Phone Express"
                                class="img-fluid floating-animation">
                            <!-- Enhanced Floating elements -->
                            <div class="floating-element element-1">
                                <div class="floating-badge bg-primary text-white">
                                    <i class="ri-smartphone-line me-1"></i>
                                    iPhone
                                </div>
                            </div>
                            <div class="floating-element element-2">
                                <div class="floating-badge bg-success text-white">
                                    <i class="ri-android-line me-1"></i>
                                    Samsung
                                </div>
                            </div>
                            <div class="floating-element element-3">
                                <div class="floating-badge bg-warning text-dark">
                                    <i class="ri-shopping-bag-line me-1"></i>
                                    Accessories
                                </div>
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
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">CATEGORIES</span>
            </p>
            <h3 class="fw-semibold mb-2">Browse Our Phone Categories</h3>
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <p class="text-muted fs-15 mb-5 fw-normal">
                        Explore our wide range of smartphones from top brands. Find the perfect phone that matches your style and budget.
                    </p>
                </div>
            </div>
            
            <!-- Category Filter -->
            <div class="category-filter">
                <div class="d-flex flex-wrap justify-content-center">
                    <button class="btn btn-outline-primary category-btn active" data-category="all">
                        All Phones
                    </button>
                    <button class="btn btn-outline-primary category-btn" data-category="iphone">
                        <i class="ri-smartphone-line me-2"></i>iPhones
                    </button>
                    <button class="btn btn-outline-primary category-btn" data-category="samsung">
                        <i class="ri-android-line me-2"></i>Samsung
                    </button>
                    <button class="btn btn-outline-primary category-btn" data-category="tecno">
                        <i class="ri-smartphone-line me-2"></i>Tecno
                    </button>
                    <button class="btn btn-outline-primary category-btn" data-category="infinix">
                        <i class="ri-smartphone-line me-2"></i>Infinix
                    </button>
                </div>
            </div>

            <!-- Categories will be dynamically filtered by JavaScript -->
        </div>
    </section>
    <!-- End:: Categories Section -->

    <!-- Top-End Smartphones Pricing Section -->
    <section class="section" id="pricing">
        <div class="container text-center">
            <p class="fs-12 fw-semibold text-success mb-1">
                <span class="landing-section-heading">PRICING</span>
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
            <div class="delivery-info text-start">
                <i class="ri-truck-line text-primary me-2"></i>
                <strong>Free Delivery:</strong> Enjoy free delivery within Nairobi. Other regions: KSh 500-1000 depending on location.
            </div>

            <!-- Payment Method Tabs -->
            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-tabs mb-3 tab-style-6 bg-primary-transparent" id="paymentMethodTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="full-payment-tab" data-bs-toggle="tab"
                            data-bs-target="#full-payment" type="button" role="tab" aria-controls="full-payment"
                            aria-selected="true">Full Payment</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lipa-tab" data-bs-toggle="tab" data-bs-target="#lipa-polepole"
                            type="button" role="tab" aria-controls="lipa-polepole" aria-selected="false">Lipa PolePole
                            <span class="badge bg-warning ms-1">iPhone Only</span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="paymentMethodContent">

                <!-- Full Payment -->
                <div class="tab-pane show active p-0" id="full-payment" role="tabpanel" aria-labelledby="full-payment-tab"
                    tabindex="0">
                    <div class="row justify-content-center">
                        @foreach($fullPhones as $phone)
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="p-4 text-center border rounded-3 phone-card">
                                    <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                        class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                    <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                    <p class="fs-25 fw-semibold mb-1">KES {{ number_format($phone->price) }}</p>
                                    <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                    <ul class="list-unstyled fs-12 mb-3">
                                        <li>Storage: (check specs)</li>
                                        <li>Dual/Triple Camera</li>
                                        <li>Face ID</li>
                                        <li>Multiple Colors</li>
                                    </ul>
                                    <a href="https://wa.me/254721920545?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($phone->name) }}"
                                    target="_blank"
                                    class="btn btn-primary-light btn-wave">
                                    Buy Now
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pricing') }}" class="btn btn-primary">Show More</a>
                    </div>
                </div>

                <!-- Lipa PolePole - iPhone Only -->
                <div class="tab-pane p-0" id="lipa-polepole" role="tabpanel" aria-labelledby="lipa-tab" tabindex="0">
                    <div class="row justify-content-center">
                        @foreach($lipaPhones as $phone)
                            @if(stripos($phone->name, 'iPhone') !== false)
                                @php
                                    $months = 10;
                                    $interestRate = 1.1; // 10% extra
                                    $monthlyInstallment = ceil(($phone->price * $interestRate) / $months);
                                @endphp

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="p-4 text-center border rounded-3 phone-card position-relative">
                                        <span class="lipa-polepole-badge">Lipa PolePole</span>
                                        <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                            class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                        <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                        <p class="fs-25 fw-semibold mb-1">KES {{ number_format($monthlyInstallment) }} x
                                            {{ $months }} months</p>
                                        <p class="text-muted fs-11 fw-semibold mb-3">Lipa PolePole (iPhone Only)</p>
                                        <ul class="list-unstyled fs-12 mb-3">
                                            <li>Storage: (check specs)</li>
                                            <li>Dual/Triple Camera</li>
                                            <li>Face ID</li>
                                            <li>Multiple Colors</li>
                                        </ul>
                                        <a href="https://wa.me/254721920545?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($phone->name) }}%20on%20Lipa%20PolePole"
                                        target="_blank"
                                        class="btn btn-primary-light btn-wave">
                                        Buy Now
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pricing') }}" class="btn btn-primary">Show More iPhones</a>
                    </div>
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
                        options like <strong>Lipa Mdogo Mdogo</strong>. Here's a glimpse of our growth and trust among our
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
                                <h3 class="fw-semibold mb-0 text-dark">10K+</h3>
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
                                <h3 class="fw-semibold mb-0 text-dark">25K+</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Happy Customers
                                </p>
                            </div>
                        </div>
                        {{-- <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-money'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">KSh 120M</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Revenue Earned
                                </p>
                            </div>
                        </div> --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border stat-card">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-store-alt'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">2</h3>
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
                                <h3 class="fw-semibold mb-0 text-dark">8+</h3>
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
                        Enjoy the convenience of our <strong>Lipa Mdogo Mdogo</strong> plan and shop with confidence.
                    </p>
                </div>
            </div>
            <div class="row justify-content-between align-items-center mx-0">
                <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                    <div class="text-lg-end">
                        <img src="{{ asset('Images/3iphones.jpg') }}" alt="Phone Express" class="img-fluid rounded-4">
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
                                    <h6 class="fw-semibold mb-0">Flexible Installments with Lipa Mdogo Mdogo</h6>
                                    <p class="text-muted">Get your favorite phones today and pay in small, manageable
                                        amounts over time.</p>
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
                        payment options like <strong>Lipa Mdogo Mdogo</strong> to make owning a phone simple and affordable.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-mobile fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Latest Smartphones</h6>
                                    <p class="mb-0 text-muted">We offer the newest phone models from top brands to keep you
                                        ahead in technology.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-money fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Flexible Payments</h6>
                                    <p class="mb-0 text-muted">With Lipa Mdogo Mdogo, you can pay in small installments and
                                        take your phone home today.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-support fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Excellent Support</h6>
                                    <p class="mb-0 text-muted">Our team is available 24/7 to help you choose the right phone
                                        and resolve any issues.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-store-alt fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Wide Selection</h6>
                                    <p class="mb-0 text-muted">From premium to budget-friendly phones, we have options for
                                        every customer.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-calendar fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Trusted Experience</h6>
                                    <p class="mb-0 text-muted">Years of serving customers and building trust in the mobile
                                        phone market.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-store fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Multiple Branches</h6>
                                    <p class="mb-0 text-muted">Convenient locations to shop in person or get support
                                        whenever you need.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-star fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Quality Assurance</h6>
                                    <p class="mb-0 text-muted">All phones are checked to ensure the highest quality
                                        standards for our customers.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card custom-card text-start landing-missions">
                        <div class="card-body">
                            <div class="align-items-top">
                                <div class="mb-2">
                                    <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                        <i class='bx bx-desktop fs-25'></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Seamless Online Experience</h6>
                                    <p class="mb-0 text-muted">Shop online with ease, track your orders, and enjoy home
                                        delivery options.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                    <div class="swiper-slide">
                        <div class="card custom-card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md avatar-rounded me-3">
                                        <img src="{{asset('build/assets/images/faces/15.jpg')}}" alt="">
                                    </span>
                                    <div>
                                        <p class="mb-0 fw-semibold fs-14">Nancy Wambui</p>
                                        <p class="mb-0 fs-10 fw-semibold text-muted">Entrepreneur</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted">
                                        - I love my new phone from Phone Express! The Lipa Mdogo Mdogo plan made it so easy
                                        to afford. --
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted">Rating : </span>
                                        <span class="text-warning d-block ms-1">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-half-fill"></i>
                                        </span>
                                    </div>
                                    <div class="float-end fs-12 fw-semibold text-muted text-end">
                                        <span>3 days ago</span>
                                        <span class="d-block fw-normal fs-12 text-success"><i>Nancy Wambui</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card custom-card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md avatar-rounded me-3">
                                        <img src="{{asset('build/assets/images/faces/4.jpg')}}" alt="">
                                    </span>
                                    <div>
                                        <p class="mb-0 fw-semibold fs-14">James Mwangi</p>
                                        <p class="mb-0 fs-10 fw-semibold text-muted">Student</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted">
                                        - Great service and very helpful staff. My phone arrived quickly and the installment
                                        plan is very convenient. --
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted">Rating : </span>
                                        <span class="text-warning d-block ms-1">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-half-fill"></i>
                                        </span>
                                    </div>
                                    <div class="float-end fs-12 fw-semibold text-muted text-end">
                                        <span>1 week ago</span>
                                        <span class="d-block fw-normal fs-12 text-success"><i>James Mwangi</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card custom-card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md avatar-rounded me-3">
                                        <img src="{{asset('build/assets/images/faces/2.jpg')}}" alt="">
                                    </span>
                                    <div>
                                        <p class="mb-0 fw-semibold fs-14">Alice Njeri</p>
                                        <p class="mb-0 fs-10 fw-semibold text-muted">Freelancer</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted">
                                        - Amazing variety of phones and excellent customer support. I recommend Phone
                                        Express to everyone. --
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted">Rating : </span>
                                        <span class="text-warning d-block ms-1">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </span>
                                    </div>
                                    <div class="float-end fs-12 fw-semibold text-muted text-end">
                                        <span>2 weeks ago</span>
                                        <span class="d-block fw-normal fs-12 text-success"><i>Alice Njeri</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon1One">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon1One" aria-expanded="true"
                                            aria-controls="collapsecustomicon1One">
                                            What types of phones do you sell?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon1One" class="accordion-collapse collapse show"
                                        aria-labelledby="headingcustomicon1One" data-bs-parent="#accordionFAQ1">
                                        <div class="accordion-body">
                                            At Phone Express Kenya, we offer a wide range of top-end smartphones including
                                            iPhones (10, 11, 12, 13, 14, 15, 16), Samsung Galaxy, and other premium devices.
                                            You can choose between <strong>Brand New, UK Used,</strong> or <strong>US
                                                Used</strong> phones.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon1Two">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon1Two" aria-expanded="false"
                                            aria-controls="collapsecustomicon1Two">
                                            Can I pay in installments (Lipa Mdogo Mdogo)?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon1Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingcustomicon1Two" data-bs-parent="#accordionFAQ1">
                                        <div class="accordion-body">
                                            Yes! We offer the option to pay in full or through our flexible
                                            <strong>Lipa Mdogo Mdogo / Lipa PolePole</strong> plan.
                                            You can start using your phone with a deposit and complete the balance in
                                            installments.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon1Three">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon1Three" aria-expanded="false"
                                            aria-controls="collapsecustomicon1Three">
                                            Do your phones come with a warranty?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon1Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingcustomicon1Three" data-bs-parent="#accordionFAQ1">
                                        <div class="accordion-body">
                                            Yes. All our phones (brand new or UK/US used) come with a
                                            <strong>warranty period</strong> that covers major defects.
                                            Terms vary depending on the type of phone you choose.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-xl-6">
                            <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                id="accordionFAQ2">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon2One">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon2One" aria-expanded="false"
                                            aria-controls="collapsecustomicon2One">
                                            How do I place an order?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon2One" class="accordion-collapse collapse"
                                        aria-labelledby="headingcustomicon2One" data-bs-parent="#accordionFAQ2">
                                        <div class="accordion-body">
                                            You can place your order directly on our website, via WhatsApp, or by
                                            visiting our physical store. No account is required to buy.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon2Two">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon2Two" aria-expanded="false"
                                            aria-controls="collapsecustomicon2Two">
                                            Do you offer delivery across Kenya?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon2Two" class="accordion-collapse collapse"
                                        aria-labelledby="headingcustomicon2Two" data-bs-parent="#accordionFAQ2">
                                        <div class="accordion-body">
                                            Yes. We deliver countrywide. Customers within Nairobi can enjoy same-day
                                            delivery,
                                            while other regions may take 1-2 business days.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingcustomicon2Three">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsecustomicon2Three" aria-expanded="false"
                                            aria-controls="collapsecustomicon2Three">
                                            Can I return or exchange my phone?
                                        </button>
                                    </h2>
                                    <div id="collapsecustomicon2Three" class="accordion-collapse collapse"
                                        aria-labelledby="headingcustomicon2Three" data-bs-parent="#accordionFAQ2">
                                        <div class="accordion-body">
                                            Yes, you can return or exchange your phone within our
                                            <strong>return policy window</strong> if it has issues covered by warranty.
                                            Conditions apply.
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
                    <div class="card custom-card border shadow-none contact-card">
                        <div class="card-body p-0">
                            <iframe
                                src="https://www.google.com/maps?q=Kimathi+House,+Suite+507,+5th+Floor,+Opposite+Sarova+Stanley+Hotel,+Kimathi+Street,+Nairobi+CBD&output=embed"
                                height="365" style="border:0;width:100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card custom-card overflow-hidden section-bg border overflow-hidden shadow-none contact-card">
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
                                            <textarea class="form-control" id="contact-address" rows="1"></textarea>
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
                                            <!-- WhatsApp button -->
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
                            <a href="{{ url('index') }}">
                                <img src="{{ asset('Images/logo-removebg-preview.png') }}" alt="Phone Express Kenya"
                                    class="img-fluid" style="max-height: 60px;">
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
                            <li><a href="{{ url('shop') }}" class="text-fixed-white">Shop</a></li>
                            <li><a href="{{ url('about') }}" class="text-fixed-white">About Us</a></li>
                            <li><a href="{{ url('contact') }}" class="text-fixed-white">Contact</a></li>
                            <li><a href="{{ url('faq') }}" class="text-fixed-white">FAQs</a></li>
                            <li><a href="{{ url('terms') }}" class="text-fixed-white">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Info -->
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="px-4">
                        <h6 class="fw-semibold text-fixed-white">INFO</h6>
                        <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                            <li><a href="{{ url('lipapolepole') }}" class="text-fixed-white">Lipa PolePole</a></li>
                            <li><a href="{{ url('testimonials') }}" class="text-fixed-white">Testimonials</a></li>
                            <li><a href="{{ url('blog') }}" class="text-fixed-white">Blog</a></li>
                            <li><a href="{{ url('support') }}" class="text-fixed-white">Support</a></li>
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
@endsection

@section('scripts')
    <!-- SWIPER JS -->
    <script src="{{asset('build/assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- INTERNAL LANDING JS -->
    @vite('resources/assets/js/landing.js')

    <script>
        // Enhanced Category Filtering
        document.addEventListener('DOMContentLoaded', function() {
            // Category filtering functionality
            const categoryBtns = document.querySelectorAll('.category-btn');
            
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-category');
                    filterPhones(category);
                });
            });

            function filterPhones(category) {
                // This would typically make an API call to filter phones
                // For now, we'll just show a message
                if (category !== 'all') {
                    // In a real implementation, this would filter the phone listings
                    console.log(`Filtering by category: ${category}`);
                    // You would implement AJAX calls here to filter the phone data
                }
            }

            // Enhanced smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation to buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.href && !this.href.startsWith('#')) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="ri-loader-4-line spin me-2"></i>Loading...';
                        this.disabled = true;
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 2000);
                    }
                });
            });

            // Enhanced phone card interactions
            document.querySelectorAll('.phone-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // CSS for loading spinner
        const style = document.createElement('style');
        style.textContent = `
            .spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection