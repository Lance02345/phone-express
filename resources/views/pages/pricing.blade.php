@extends('layouts.landing-master')

@section('styles')
    <!-- SWIPERJS CSS -->
    <link rel="stylesheet" href="{{asset('build/assets/libs/swiper/swiper-bundle.min.css')}}">
@endsection

@section('content')
<div class="landing-banner">
    <section class="section">
        <div class="container main-banner-container pb-lg-0">
            <div class="row">
                <div class="col-12">
                    <div class="py-lg-5 text-center">
                        <div class="mb-3">
                            <h5 class="fw-semibold text-fixed-white op-9">PHONES MADE ACCESSIBLE</h5>
                        </div>
                        <p class="landing-banner-heading mb-3">
                            Get your dream phone today with <span class="text-secondary">Phone Express!</span>
                        </p>
                        <div class="fs-16 mb-5 text-fixed-white op-7">
                            Choose your preferred payment method and browse our selection of premium smartphones.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Pricing Section -->
<section class="section" id="pricing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
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
                                type="button" role="tab" aria-controls="lipa-polepole" aria-selected="false">
                                Lipa Mdogo Mdogo
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="paymentMethodContent">

                    <!-- Full Payment -->
                    <div class="tab-pane fade show active p-0" id="full-payment" role="tabpanel" aria-labelledby="full-payment-tab">
                        <div class="row">
                            @foreach($fullPhones as $phone)
                                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="p-4 text-center border rounded-3 h-100">
                                        <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                            class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                        <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                        <p class="fs-25 fw-semibold mb-1">KES {{ number_format($phone->price) }}</p>
                                        <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                        <button class="btn btn-primary-light btn-wave">Buy Now</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $fullPhones->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <!-- Lipa Mdogo Mdogo -->
                    <div class="tab-pane fade p-0" id="lipa-polepole" role="tabpanel" aria-labelledby="lipa-tab">
                        <div class="row">
                            @foreach($lipaPhones as $phone)
                                @php
                                    $months = 10;
                                    $interestRate = 1.1; // 10% extra
                                    $monthlyInstallment = ceil(($phone->price * $interestRate) / $months);
                                @endphp
                                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="p-4 text-center border rounded-3 h-100">
                                        <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                            class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                        <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                        <p class="fs-25 fw-semibold mb-1">KES {{ number_format($monthlyInstallment) }} x {{ $months }} months</p>
                                        <p class="text-muted fs-11 fw-semibold mb-3">Lipa Mdogo Mdogo</p>
                                        <button class="btn btn-primary-light btn-wave">Buy Now</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $lipaPhones->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <!-- SWIPER JS -->
    <script src="{{asset('build/assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- INTERNAL LANDING JS -->
    @vite('resources/assets/js/landing.js')
@endsection