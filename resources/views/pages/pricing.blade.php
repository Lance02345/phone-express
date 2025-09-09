@php
if (!function_exists('extractBrand')) {
    function extractBrand($name) {
        if (stripos($name, 'iPhone') !== false) return 'Apple';
        if (stripos($name, 'Samsung') !== false) return 'Samsung';
        return 'Other';
    }
}

if (!function_exists('extractStorage')) {
    function extractStorage($name) {
        if (preg_match('/(\d+)GB/', $name, $matches)) {
            return $matches[1];
        }
        return '';
    }
}

if (!function_exists('extractSeries')) {
    function extractSeries($name) {
        if (preg_match('/(iPhone \d+)/', $name, $matches)) return $matches[1];
        if (stripos($name, 'Galaxy S') !== false) return 'Galaxy S';
        if (stripos($name, 'Galaxy Note') !== false) return 'Galaxy Note';
        if (stripos($name, 'Galaxy Fold') !== false) return 'Galaxy Fold';
        if (stripos($name, 'Galaxy Flip') !== false) return 'Galaxy Flip';
        return '';
    }
}
@endphp

@extends('layouts.landing-master')

@section('styles')
    <!-- SWIPERJS CSS -->
    <link rel="stylesheet" href="{{asset('build/assets/libs/swiper/swiper-bundle.min.css')}}">
    <!-- SELECT2 CSS - Using CDN as fallback -->
    <link rel="stylesheet" href="{{asset('build/assets/libs/select2/select2.min.css')}}" 
          onerror="this.onerror=null;this.href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css';">
    <!-- Fallback CDN for Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" 
          integrity="sha512-aD9ophpFQ61nFZP6hXYu4Q/b/USW7rpLCQLX6Bi0WJHXNO7Js/fUENpBQf/+P4NtpzNX0jSgR5zVvPOJp+W2Kg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        .search-container {
            position: relative;
        }
        
        .search-input {
            padding-left: 45px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            transform: translateY(-2px);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }
        
        .clear-search {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }
        
        .clear-search.show {
            opacity: 1;
        }
        
        .clear-search:hover {
            color: #dc3545;
        }
        
        .filter-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            margin: 0.125rem;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            position: relative;
        }
        
        .filter-badge.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .results-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .phone-card {
            transition: all 0.3s ease;
        }
        
        .phone-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .phone-card .card-body {
            position: relative;
            overflow: hidden;
        }
        
        .phone-card .card-body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
            opacity: 0;
        }
        
        .phone-card:hover .card-body::before {
            animation: shimmer 1.5s ease-in-out;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
        }
        
        .advanced-filters {
            display: none;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }
        
        .advanced-filters.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .filter-toggle {
            cursor: pointer;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s ease;
        }
        
        .filter-toggle:hover {
            color: #0a58ca;
        }
        
        .filter-toggle i {
            transition: transform 0.3s ease;
        }
        
        .filter-toggle.active i {
            transform: rotate(180deg);
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .no-results i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }
        
        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            transition: background-color 0.2s ease;
        }
        
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .suggestion-brand {
            font-weight: 600;
            color: #0d6efd;
        }
        
        .suggestion-price {
            color: #28a745;
            font-weight: 500;
        }
    </style>
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

<!-- Search and Filter Section -->
<section class="section" id="search-filters">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Advanced Search Box -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="search-container">
                            <i class="ri-search-line search-icon"></i>
                            <input type="text" class="form-control search-input" id="phoneSearch" 
                                   placeholder="Search for iPhone 13, Samsung Galaxy S23, or any phone model...">
                            <button class="clear-search" id="clearSearch">
                                <i class="ri-close-line"></i>
                            </button>
                            <div class="search-suggestions" id="searchSuggestions"></div>
                        </div>
                        
                        <!-- Quick Filter Badges -->
                        <div class="mt-3">
                            <small class="text-muted d-block mb-2">Quick Filters:</small>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="filter-badge" data-filter="brand" data-value="Apple">iPhone</span>
                                <span class="filter-badge" data-filter="brand" data-value="Samsung">Samsung</span>
                                <span class="filter-badge" data-filter="price" data-value="0-50000">Under 50K</span>
                                <span class="filter-badge" data-filter="price" data-value="50000-80000">50K-80K</span>
                                <span class="filter-badge" data-filter="price" data-value="80000+">80K+</span>
                                <span class="filter-badge" data-filter="storage" data-value="128">128GB</span>
                                <span class="filter-badge" data-filter="storage" data-value="256">256GB</span>
                                <span class="filter-badge" data-filter="storage" data-value="512">512GB</span>
                            </div>
                        </div>
                        
                        <!-- Advanced Filters Toggle -->
                        <div class="mt-3">
                            <a href="#" class="filter-toggle" id="advancedToggle">
                                <i class="ri-arrow-down-s-line"></i>
                                Advanced Filters
                            </a>
                        </div>
                        
                        <!-- Advanced Filters -->
                        <div class="advanced-filters" id="advancedFilters">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="brandFilter" class="form-label">Brand</label>
                                    <select class="form-select" id="brandFilter">
                                        <option value="">All Brands</option>
                                        <option value="Apple">Apple (iPhone)</option>
                                        <option value="Samsung">Samsung Galaxy</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="priceFilter" class="form-label">Price Range</label>
                                    <select class="form-select" id="priceFilter">
                                        <option value="">All Prices</option>
                                        <option value="0-30000">Under KES 30,000</option>
                                        <option value="30000-50000">KES 30,000 - 50,000</option>
                                        <option value="50000-70000">KES 50,000 - 70,000</option>
                                        <option value="70000-90000">KES 70,000 - 90,000</option>
                                        <option value="90000+">Over KES 90,000</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="storageFilter" class="form-label">Storage</label>
                                    <select class="form-select" id="storageFilter">
                                        <option value="">All Storage</option>
                                        <option value="64">64GB</option>
                                        <option value="128">128GB</option>
                                        <option value="256">256GB</option>
                                        <option value="512">512GB</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="sortFilter" class="form-label">Sort By</label>
                                    <select class="form-select" id="sortFilter">
                                        <option value="relevance">Most Relevant</option>
                                        <option value="price_asc">Price: Low to High</option>
                                        <option value="price_desc">Price: High to Low</option>
                                        <option value="name_asc">Name: A to Z</option>
                                        <option value="name_desc">Name: Z to A</option>
                                        <option value="newest">Newest First</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Model/Series Filter -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="seriesFilter" class="form-label">iPhone Series</label>
                                    <select class="form-select" id="seriesFilter">
                                        <option value="">All iPhone Series</option>
                                        <option value="iPhone X">iPhone X Series</option>
                                        <option value="iPhone 11">iPhone 11 Series</option>
                                        <option value="iPhone 12">iPhone 12 Series</option>
                                        <option value="iPhone 13">iPhone 13 Series</option>
                                        <option value="iPhone 14">iPhone 14 Series</option>
                                        <option value="iPhone 15">iPhone 15 Series</option>
                                        <option value="iPhone 16">iPhone 16 Series</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="samsungSeriesFilter" class="form-label">Samsung Series</label>
                                    <select class="form-select" id="samsungSeriesFilter">
                                        <option value="">All Samsung Series</option>
                                        <option value="Galaxy S">Galaxy S Series</option>
                                        <option value="Galaxy Note">Galaxy Note Series</option>
                                        <option value="Galaxy Fold">Galaxy Fold Series</option>
                                        <option value="Galaxy Flip">Galaxy Flip Series</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="conditionFilter" class="form-label">Condition</label>
                                    <select class="form-select" id="conditionFilter">
                                        <option value="">All Conditions</option>
                                        <option value="new">Brand New</option>
                                        <option value="refurbished">Refurbished</option>
                                        <option value="used">Used</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-2" id="clearAllFilters">
                                        <i class="ri-close-line"></i> Clear All Filters
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" id="applyFilters">
                                        <i class="ri-filter-3-line"></i> Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Results Summary -->
                <div class="results-summary" id="resultsSummary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">
                                <span id="resultsCount">{{ $fullPhones->count() + $lipaPhones->count() }}</span> phones found
                            </h6>
                            <small id="resultsDescription">Browse our complete collection</small>
                        </div>
                        <div>
                            <i class="ri-smartphone-line fs-3 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                        <div class="row" id="fullPaymentPhones">
                            @foreach($fullPhones as $phone)
                                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4 phone-card" 
                                     data-brand="{{ extractBrand($phone->name) }}" 
                                     data-price="{{ $phone->price }}"
                                     data-storage="{{ extractStorage($phone->name) }}"
                                     data-series="{{ extractSeries($phone->name) }}"
                                     data-name="{{ strtolower($phone->name) }}"
                                     data-search-text="{{ strtolower($phone->name) }}">
                                    <div class="p-4 text-center border rounded-3 h-100">
                                        <div class="card-body">
                                            <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                                class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                            <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                            <p class="fs-25 fw-semibold mb-1">
                                                @if($phone->price == 0)
                                                    <span class="text-info">Price on Request</span>
                                                @else
                                                    KES {{ number_format($phone->price) }}
                                                @endif
                                            </p>
                                            <p class="text-muted fs-11 fw-semibold mb-3">Full Payment</p>
                                            <a href="https://wa.me/254721920545?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($phone->name) }}"
                                               target="_blank"
                                               class="btn btn-primary-light btn-wave">
                                               Buy Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- No Results Message -->
                        <div class="no-results d-none" id="noResultsFull">
                            <i class="ri-search-line"></i>
                            <h5>No phones found</h5>
                            <p>Try adjusting your search criteria or filters</p>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $fullPhones->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <!-- Lipa Mdogo Mdogo -->
                    <div class="tab-pane fade p-0" id="lipa-polepole" role="tabpanel" aria-labelledby="lipa-tab">
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">Lipa Mdogo Mdogo Explained! 😃</h6>
                            <p class="mb-0">
                                For iPhones only: 40% upfront payment, then the remaining balance plus 50% interest divided into 12 weekly payments.
                                Requirements: National ID and MPESA/Bank statements for the last 3 months.
                            </p>
                        </div>
                        <div class="row" id="lipaPhones">
                            @foreach($lipaPhones as $phone)
                                @php
                                    // Only apply Lipa Mdogo Mdogo to iPhones
                                    if (stripos($phone->name, 'iPhone') !== false || extractBrand($phone->name) === 'Apple') {
                                        $upfrontPercent = 0.4; // 40% upfront
                                        $interestRate = 1.5; // 50% interest
                                        $weeks = 12; // 12 weeks
                                        
                                        $upfrontPayment = ceil($phone->price * $upfrontPercent);
                                        $remainingBalance = $phone->price - $upfrontPayment;
                                        $totalBalance = ceil($remainingBalance * $interestRate);
                                        $weeklyPayment = ceil($totalBalance / $weeks);
                                    } else {
                                        // For non-iPhones, show standard pricing
                                        $upfrontPayment = null;
                                        $weeklyPayment = null;
                                    }
                                @endphp
                                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4 phone-card" 
                                     data-brand="{{ extractBrand($phone->name) }}" 
                                     data-price="{{ $phone->price }}"
                                     data-storage="{{ extractStorage($phone->name) }}"
                                     data-series="{{ extractSeries($phone->name) }}"
                                     data-name="{{ strtolower($phone->name) }}"
                                     data-search-text="{{ strtolower($phone->name) }}">
                                    <div class="p-4 text-center border rounded-3 h-100">
                                        <div class="card-body">
                                            <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                                class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
                                            <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                            
                                            @if(stripos($phone->name, 'iPhone') !== false || extractBrand($phone->name) === 'Apple')
                                                @if($phone->price == 0)
                                                    <p class="fs-18 fw-semibold mb-1 text-info">Price on Request</p>
                                                    <p class="text-muted fs-11 fw-semibold mb-3">Contact for Lipa Mdogo Mdogo</p>
                                                @else
                                                    <p class="fs-18 fw-semibold mb-1">Upfront: KES {{ number_format($upfrontPayment) }}</p>
                                                    <p class="fs-18 fw-semibold mb-1">Then: KES {{ number_format($weeklyPayment) }}/week for {{ $weeks }} weeks</p>
                                                    <p class="text-muted fs-11 fw-semibold mb-3">Lipa Mdogo Mdogo (iPhone)</p>
                                                @endif
                                            @else
                                                @if($phone->price == 0)
                                                    <p class="fs-25 fw-semibold mb-1 text-info">Price on Request</p>
                                                @else
                                                    <p class="fs-25 fw-semibold mb-1">KES {{ number_format($phone->price) }}</p>
                                                @endif
                                                <p class="text-muted fs-11 fw-semibold mb-3">Full Payment Only</p>
                                            @endif
                                            
                                            <a href="https://wa.me/254721920545?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($phone->name) }}"
                                               target="_blank"
                                               class="btn btn-primary-light btn-wave">
                                               Buy Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- No Results Message -->
                        <div class="no-results d-none" id="noResultsLipa">
                            <i class="ri-search-line"></i>
                            <h5>No phones found</h5>
                            <p>Try adjusting your search criteria or filters</p>
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
    <!-- jQuery - Load first -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- SWIPER JS -->
    <script src="{{asset('build/assets/libs/swiper/swiper-bundle.min.js')}}"></script>
    
    <!-- SELECT2 JS - With fallback -->
    <script src="{{asset('build/assets/libs/select2/select2.min.js')}}" 
            onerror="this.remove(); var script = document.createElement('script'); script.src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js'; document.head.appendChild(script);"></script>
    <!-- Fallback CDN for Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js" 
            integrity="sha512-4MvcHwcbqXKUHB6Lx3Zb5CEAVoE9u84qN+ZSMM6s7z8IeJriExrV3ND5zRze9mxNlABJ6k864P/Vl8m0Sd3DtQ==" 
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- INTERNAL LANDING JS -->
    @vite('resources/assets/js/landing.js')

    <script>
        $(document).ready(function() {
            let searchTimeout;
            let allPhones = [];
            let activeFilters = {
                search: '',
                brand: '',
                price: '',
                storage: '',
                series: '',
                samsungSeries: '',
                condition: '',
                sort: 'relevance'
            };
            
            // Initialize
            initializeComponents();
            collectPhoneData();
            
            function initializeComponents() {
                // Wait for Select2 to be available
                function initSelect2() {
                    if (typeof $.fn.select2 !== 'undefined') {
                        // Initialize select2
                        $('#brandFilter, #priceFilter, #storageFilter, #sortFilter, #seriesFilter, #samsungSeriesFilter, #conditionFilter').select2({
                            minimumResultsForSearch: Infinity
                        });
                        setupEventListeners();
                    } else {
                        setTimeout(initSelect2, 100);
                    }
                }
                initSelect2();
            }
            
            function collectPhoneData() {
                $('.phone-card').each(function() {
                    const $card = $(this);
                    allPhones.push({
                        element: $card,
                        brand: $card.data('brand'),
                        price: parseInt($card.data('price')),
                        storage: $card.data('storage'),
                        series: $card.data('series'),
                        name: $card.data('name'),
                        searchText: $card.data('search-text')
                    });
                });
            }
            
            function setupEventListeners() {
                // Search input with debouncing
                $('#phoneSearch').on('input', function() {
                    const query = $(this).val().trim();
                    
                    // Show/hide clear button
                    if (query.length > 0) {
                        $('#clearSearch').addClass('show');
                        showSearchSuggestions(query);
                    } else {
                        $('#clearSearch').removeClass('show');
                        hideSearchSuggestions();
                    }
                    
                    // Debounce search
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        activeFilters.search = query;
                        applyAllFilters();
                    }, 300);
                });
                
                // Clear search
                $('#clearSearch').on('click', function() {
                    $('#phoneSearch').val('').focus();
                    $('#clearSearch').removeClass('show');
                    hideSearchSuggestions();
                    activeFilters.search = '';
                    applyAllFilters();
                });
                
                // Hide suggestions when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.search-container').length) {
                        hideSearchSuggestions();
                    }
                });
                
                // Quick filter badges
                $('.filter-badge').on('click', function() {
                    const $badge = $(this);
                    const filterType = $badge.data('filter');
                    const value = $badge.data('value');
                    
                    // Toggle badge
                    if ($badge.hasClass('active')) {
                        $badge.removeClass('active');
                        activeFilters[filterType] = '';
                    } else {
                        // Remove active from siblings
                        $(`.filter-badge[data-filter="${filterType}"]`).removeClass('active');
                        $badge.addClass('active');
                        activeFilters[filterType] = value;
                        
                        // Update corresponding dropdown
                        if (filterType === 'brand') {
                            $('#brandFilter').val(value === 'Apple' ? 'Apple' : value).trigger('change');
                        } else if (filterType === 'price') {
                            $('#priceFilter').val(value).trigger('change');
                        } else if (filterType === 'storage') {
                            $('#storageFilter').val(value).trigger('change');
                        }
                    }
                    
                    applyAllFilters();
                });
                
                // Advanced filter toggle
                $('#advancedToggle').on('click', function(e) {
                    e.preventDefault();
                    const $toggle = $(this);
                    const $filters = $('#advancedFilters');
                    
                    if ($filters.hasClass('show')) {
                        $filters.removeClass('show');
                        $toggle.removeClass('active');
                    } else {
                        $filters.addClass('show');
                        $toggle.addClass('active');
                    }
                });
                
                // Filter dropdowns
                $('#brandFilter, #priceFilter, #storageFilter, #sortFilter, #seriesFilter, #samsungSeriesFilter, #conditionFilter').on('change', function() {
                    const id = $(this).attr('id');
                    const value = $(this).val();
                    
                    switch(id) {
                        case 'brandFilter':
                            activeFilters.brand = value;
                            updateQuickBadges('brand', value);
                            break;
                        case 'priceFilter':
                            activeFilters.price = value;
                            updateQuickBadges('price', value);
                            break;
                        case 'storageFilter':
                            activeFilters.storage = value;
                            updateQuickBadges('storage', value);
                            break;
                        case 'sortFilter':
                            activeFilters.sort = value;
                            break;
                        case 'seriesFilter':
                            activeFilters.series = value;
                            break;
                        case 'samsungSeriesFilter':
                            activeFilters.samsungSeries = value;
                            break;
                        case 'conditionFilter':
                            activeFilters.condition = value;
                            break;
                    }
                    
                    applyAllFilters();
                });
                
                // Clear all filters
                $('#clearAllFilters').on('click', function() {
                    // Reset all filters
                    Object.keys(activeFilters).forEach(key => {
                        activeFilters[key] = key === 'sort' ? 'relevance' : '';
                    });
                    
                    // Reset UI
                    $('#phoneSearch').val('');
                    $('#clearSearch').removeClass('show');
                    $('.filter-badge').removeClass('active');
                    $('#brandFilter, #priceFilter, #storageFilter, #seriesFilter, #samsungSeriesFilter, #conditionFilter').val('').trigger('change');
                    $('#sortFilter').val('relevance').trigger('change');
                    
                    hideSearchSuggestions();
                    applyAllFilters();
                });
                
                // Apply filters button (mainly for mobile)
                $('#applyFilters').on('click', function() {
                    applyAllFilters();
                    $('#advancedFilters').removeClass('show');
                    $('#advancedToggle').removeClass('active');
                });
                
                // Tab change event
                $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
                    setTimeout(() => {
                        applyAllFilters();
                    }, 100);
                });
            }
            
            function showSearchSuggestions(query) {
                if (query.length < 2) {
                    hideSearchSuggestions();
                    return;
                }
                
                const suggestions = generateSuggestions(query);
                if (suggestions.length === 0) {
                    hideSearchSuggestions();
                    return;
                }
                
                const $container = $('#searchSuggestions');
                $container.empty();
                
                suggestions.slice(0, 6).forEach(suggestion => {
                    const $item = $(`
                        <div class="suggestion-item" data-suggestion="${suggestion.value}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="suggestion-brand">${suggestion.brand}</div>
                                    <div class="small text-muted">${suggestion.name}</div>
                                </div>
                                <div class="suggestion-price">
                                    ${suggestion.price === 0 ? 'Price on Request' : 'KES ' + suggestion.price.toLocaleString()}
                                </div>
                            </div>
                        </div>
                    `);
                    
                    $item.on('click', function() {
                        $('#phoneSearch').val(suggestion.value);
                        activeFilters.search = suggestion.value;
                        hideSearchSuggestions();
                        applyAllFilters();
                    });
                    
                    $container.append($item);
                });
                
                $container.show();
            }
            
            function hideSearchSuggestions() {
                $('#searchSuggestions').hide();
            }
            
            function generateSuggestions(query) {
                const suggestions = [];
                const queryLower = query.toLowerCase();
                
                allPhones.forEach(phone => {
                    if (phone.searchText.includes(queryLower)) {
                        suggestions.push({
                            value: phone.name,
                            brand: phone.brand,
                            name: phone.name,
                            price: phone.price,
                            relevance: calculateRelevance(phone.searchText, queryLower)
                        });
                    }
                });
                
                // Sort by relevance
                return suggestions.sort((a, b) => b.relevance - a.relevance);
            }
            
            function calculateRelevance(text, query) {
                let score = 0;
                
                // Exact match gets highest score
                if (text === query) score += 100;
                
                // Word boundary matches
                if (new RegExp(`\\b${query}`, 'i').test(text)) score += 50;
                
                // Contains query
                if (text.includes(query)) score += 25;
                
                // Length difference penalty
                const lengthDiff = Math.abs(text.length - query.length);
                score -= lengthDiff * 0.1;
                
                return score;
            }
            
            function updateQuickBadges(filterType, value) {
                $(`.filter-badge[data-filter="${filterType}"]`).removeClass('active');
                if (value) {
                    $(`.filter-badge[data-filter="${filterType}"][data-value="${value}"]`).addClass('active');
                }
            }
            
            function applyAllFilters() {
                const activeTab = $('.tab-pane.active');
                let visibleCount = 0;
                let filteredPhones = [];
                
                activeTab.find('.phone-card').each(function() {
                    const $card = $(this);
                    const phone = {
                        element: $card,
                        brand: $card.data('brand'),
                        price: parseInt($card.data('price')),
                        storage: $card.data('storage'),
                        series: $card.data('series'),
                        name: $card.data('name'),
                        searchText: $card.data('search-text')
                    };
                    
                    let show = true;
                    
                    // Search filter
                    if (activeFilters.search && !phone.searchText.includes(activeFilters.search.toLowerCase())) {
                        show = false;
                    }
                    
                    // Brand filter
                    if (activeFilters.brand && phone.brand !== activeFilters.brand) {
                        show = false;
                    }
                    
                    // Price filter
                    if (activeFilters.price && !matchesPriceRange(phone.price, activeFilters.price)) {
                        show = false;
                    }
                    
                    // Storage filter
                    if (activeFilters.storage && phone.storage !== activeFilters.storage) {
                        show = false;
                    }
                    
                    // Series filter
                    if (activeFilters.series && !phone.series.includes(activeFilters.series)) {
                        show = false;
                    }
                    
                    // Samsung series filter
                    if (activeFilters.samsungSeries && phone.brand === 'Samsung' && !phone.series.includes(activeFilters.samsungSeries)) {
                        show = false;
                    }
                    
                    if (show) {
                        $card.show();
                        visibleCount++;
                        filteredPhones.push(phone);
                    } else {
                        $card.hide();
                    }
                });
                
                // Sort visible phones
                if (filteredPhones.length > 0) {
                    sortPhones(filteredPhones, activeFilters.sort);
                }
                
                // Update results summary
                updateResultsSummary(visibleCount);
                
                // Show/hide no results message
                const noResultsId = activeTab.attr('id') === 'full-payment' ? '#noResultsFull' : '#noResultsLipa';
                if (visibleCount === 0) {
                    $(noResultsId).removeClass('d-none');
                } else {
                    $(noResultsId).addClass('d-none');
                }
            }
            
            function matchesPriceRange(price, range) {
                if (price === 0) return true; // Price on request matches all ranges
                
                if (range.includes('+')) {
                    const min = parseInt(range.replace('+', ''));
                    return price >= min;
                }
                
                const [min, max] = range.split('-').map(Number);
                return price >= min && price <= max;
            }
            
            function sortPhones(phones, sortBy) {
                const activeTab = $('.tab-pane.active');
                const container = activeTab.find('.row').first();
                
                phones.sort((a, b) => {
                    switch(sortBy) {
                        case 'price_asc':
                            // Handle "Price on Request" phones
                            if (a.price === 0 && b.price === 0) return 0;
                            if (a.price === 0) return 1;
                            if (b.price === 0) return -1;
                            return a.price - b.price;
                        case 'price_desc':
                            if (a.price === 0 && b.price === 0) return 0;
                            if (a.price === 0) return 1;
                            if (b.price === 0) return -1;
                            return b.price - a.price;
                        case 'name_asc':
                            return a.name.localeCompare(b.name);
                        case 'name_desc':
                            return b.name.localeCompare(a.name);
                        case 'newest':
                            // Sort by series number (newer first)
                            const aNum = extractSeriesNumber(a.name);
                            const bNum = extractSeriesNumber(b.name);
                            return bNum - aNum;
                        case 'relevance':
                            if (activeFilters.search) {
                                return calculateRelevance(b.searchText, activeFilters.search.toLowerCase()) - 
                                       calculateRelevance(a.searchText, activeFilters.search.toLowerCase());
                            }
                            return Math.random() - 0.5;
                        default:
                            return Math.random() - 0.5;
                    }
                });
                
                // Reorder DOM elements
                phones.forEach(phone => {
                    container.append(phone.element);
                });
            }
            
            function extractSeriesNumber(name) {
                const match = name.match(/(\d+)/);
                return match ? parseInt(match[1]) : 0;
            }
            
            function updateResultsSummary(count) {
                $('#resultsCount').text(count);
                
                let description = 'Browse our complete collection';
                if (activeFilters.search) {
                    description = `Results for "${activeFilters.search}"`;
                } else if (activeFilters.brand || activeFilters.price || activeFilters.storage) {
                    const filters = [];
                    if (activeFilters.brand) filters.push(activeFilters.brand);
                    if (activeFilters.price) filters.push(`KES ${activeFilters.price}`);
                    if (activeFilters.storage) filters.push(`${activeFilters.storage}GB`);
                    description = `Filtered by: ${filters.join(', ')}`;
                }
                
                $('#resultsDescription').text(description);
                
                // Animate count change
                $('#resultsCount').addClass('fw-bold text-warning');
                setTimeout(() => {
                    $('#resultsCount').removeClass('fw-bold text-warning');
                }, 500);
            }
            
            // Keyboard navigation for search suggestions
            $('#phoneSearch').on('keydown', function(e) {
                const $suggestions = $('#searchSuggestions .suggestion-item');
                const $active = $suggestions.filter('.active');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if ($active.length === 0) {
                        $suggestions.first().addClass('active');
                    } else {
                        $active.removeClass('active');
                        const next = $active.next('.suggestion-item');
                        if (next.length) {
                            next.addClass('active');
                        } else {
                            $suggestions.first().addClass('active');
                        }
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if ($active.length === 0) {
                        $suggestions.last().addClass('active');
                    } else {
                        $active.removeClass('active');
                        const prev = $active.prev('.suggestion-item');
                        if (prev.length) {
                            prev.addClass('active');
                        } else {
                            $suggestions.last().addClass('active');
                        }
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if ($active.length) {
                        $active.click();
                    }
                } else if (e.key === 'Escape') {
                    hideSearchSuggestions();
                }
            });
            
            // Add hover effect to suggestions
            $(document).on('mouseenter', '.suggestion-item', function() {
                $('.suggestion-item').removeClass('active');
                $(this).addClass('active');
            });
            
            // Initial load
            setTimeout(() => {
                applyAllFilters();
            }, 100);
        });
    </script>
@endsection