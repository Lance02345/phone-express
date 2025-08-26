@extends('layouts.landing-master')

@section('styles')

    <!-- SWIPERJS CSS -->
    <link rel="stylesheet" href="{{asset('build/assets/libs/swiper/swiper-bundle.min.css')}}">

@endsection

@section('content')

    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row">
                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                        <div class="py-lg-5">
                            <div class="mb-3">
                                <h5 class="fw-semibold text-fixed-white op-9">PHONES MADE ACCESSIBLE</h5>
                            </div>
                            <p class="landing-banner-heading mb-3">
                                Get your dream phone today with <span class="text-secondary">Phone Express!</span>
                            </p>
                            <div class="fs-16 mb-5 text-fixed-white op-7">
                                Phone Express brings you the latest smartphones at unbeatable prices. Enjoy flexible payment
                                with our <strong>Lipa Mdogo Mdogo</strong> option and take home your phone today without
                                breaking the bank.
                            </div>
                            <a href="{{url('index')}}" class="m-1 btn btn-primary">
                                Shop Now
                                <i class="ri-shopping-bag-line ms-2 align-middle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
                        <div class="text-end landing-main-image landing-heading-img">
                            <img src="{{asset('build/assets/images/media/landing/phones.png')}}" alt="Phone Express"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End:: Section-1 -->

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
                        options like <strong>Lipa Mdogo Mdogo</strong>. Here’s a glimpse of our growth and trust among our
                        clients.
                    </p>
                </div>
            </div>
            <div class="row g-2 justify-content-center">
                <div class="col-xl-12">
                    <div class="row justify-content-evenly">
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border">
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
                            <div class="p-3 text-center rounded-2 bg-white border">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-user-plus'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">25K+</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Happy Customers
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-money'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">KSh 120M</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Revenue Earned
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border">
                                <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                    <i class='fs-24 bx bx-store-alt'></i>
                                </span>
                                <h3 class="fw-semibold mb-0 text-dark">12</h3>
                                <p class="mb-1 fs-14 op-7 text-muted">
                                    Branches
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="p-3 text-center rounded-2 bg-white border">
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
                        Here’s what some of our happy customers say about buying their phones and using our flexible payment
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

                    <!-- Add more slides as needed with similar structure -->

                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>
    <!-- End:: Section-6 -->

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
                            type="button" role="tab" aria-controls="lipa-polepole" aria-selected="false">Lipa
                            PolePole</button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="paymentMethodContent">

                <!-- Full Payment -->
                <div class="tab-pane show active p-0" id="full-payment" role="tabpanel" aria-labelledby="full-payment-tab"
                    tabindex="0">
                    <div class="row justify-content-center">

                        <!-- iPhone 13 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/iphone13.jpg') }}" alt="iPhone 13"
                                    class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">iPhone 13</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 100,000</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>128GB Storage</li>
                                    <li>Dual Camera</li>
                                    <li>Face ID</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                        <!-- iPhone 14 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/iphone12.jpg') }}" alt="iPhone 14"
                                    class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">iPhone 14</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 130,000</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>128GB Storage</li>
                                    <li>Dual Camera</li>
                                    <li>Face ID</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                        <!-- Samsung Galaxy S23 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/iphone11pro.jpg') }}" alt="Samsung Galaxy S23"
                                    class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">Samsung Galaxy S23</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 120,000</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>256GB Storage</li>
                                    <li>Triple Camera</li>
                                    <li>Fingerprint & Face Unlock</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Lipa PolePole -->
                <div class="tab-pane p-0" id="lipa-polepole" role="tabpanel" aria-labelledby="lipa-tab" tabindex="0">
                    <div class="row justify-content-center">

                        <!-- iPhone 13 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/alexander-andrews-Wzs4-QEmCUQ-unsplash.jpg') }}" alt="iPhone 13"
                                    class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">iPhone 13</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 10,000 x 10 months</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Lipa PolePole</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>128GB Storage</li>
                                    <li>Dual Camera</li>
                                    <li>Face ID</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                        <!-- iPhone 14 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/filip-baotic-DV0mB2uJM34-unsplash.jpg') }}" alt="iPhone 14"
                                    class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">iPhone 14</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 13,000 x 10 months</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Lipa PolePole</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>128GB Storage</li>
                                    <li>Dual Camera</li>
                                    <li>Face ID</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                        <!-- Samsung Galaxy S23 -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="p-4 text-center">
                                <img src="{{ asset('Images/omid-armin-B2w4rdIihEo-unsplash.jpg') }}"
                                    alt="Samsung Galaxy S23" class="img-fluid mb-3 rounded-3"
                                    style="height:220px; object-fit:cover;">
                                <h6 class="fw-semibold">Samsung Galaxy S23</h6>
                                <p class="fs-25 fw-semibold mb-1">KES 12,000 x 10 months</p>
                                <p class="text-muted fs-11 fw-semibold mb-3">Lipa PolePole</p>
                                <ul class="list-unstyled fs-12 mb-3">
                                    <li>256GB Storage</li>
                                    <li>Triple Camera</li>
                                    <li>Fingerprint & Face Unlock</li>
                                    <li>Multiple Colors</li>
                                </ul>
                                <button class="btn btn-primary-light btn-wave">Buy Now</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


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
                        You can reach us anytime regarding any queries or deals. Don’t hesitate to clear your doubts before
                        getting your next phone.
                    </p>
                    <p class="fw-semibold text-dark">
                        📍 Kimathi House, Suite 507, 5th Floor, Opposite Sarova Stanley Hotel, Kimathi Street, Nairobi CBD
                    </p>
                </div>
            </div>
            <div class="row text-start">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card custom-card border shadow-none">
                        <div class="card-body p-0">
                            <iframe
                                src="https://www.google.com/maps?q=Kimathi+House,+Suite+507,+5th+Floor,+Opposite+Sarova+Stanley+Hotel,+Kimathi+Street,+Nairobi+CBD&output=embed"
                                height="365" style="border:0;width:100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card custom-card overflow-hidden section-bg border overflow-hidden shadow-none">
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
                            <img src="{{ asset('Images/logo-removebg-preview.png') }}" alt="Phone Express Kenya" class="img-fluid" style="max-height: 60px;">
                        </a>
                    </p>
                    <p class="mb-2 op-6 fw-normal">
                        At Phone Express Kenya, we bring you the latest iPhones, Samsungs, and other premium smartphones at unbeatable prices. Choose between paying in full or using our flexible <strong>Lipa PolePole</strong> plan.
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
                            <a href="https://www.instagram.com/phoneexpresskenya._" target="_blank" class="text-fixed-white op-6">
                                <i class="ri-instagram-line me-1 align-middle"></i> Instagram: @phoneexpresskenya._
                            </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@phoneexpresskenya" target="_blank" class="text-fixed-white op-6">
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


@endsection