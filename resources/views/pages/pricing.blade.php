@php
// Optimized helper functions with caching
if (!function_exists('extractBrand')) {
    function extractBrand($name) {
        static $cache = [];
        if (isset($cache[$name])) {
            return $cache[$name];
        }
        
        if (stripos($name, 'iPhone') !== false) {
            $cache[$name] = 'Apple';
        } elseif (stripos($name, 'Samsung') !== false) {
            $cache[$name] = 'Samsung';
        } else {
            $cache[$name] = 'Other';
        }
        
        return $cache[$name];
    }
}

if (!function_exists('extractStorage')) {
    function extractStorage($name) {
        static $cache = [];
        if (isset($cache[$name])) {
            return $cache[$name];
        }
        
        if (preg_match('/(\d+)GB/', $name, $matches)) {
            $cache[$name] = $matches[1];
        } else {
            $cache[$name] = '';
        }
        
        return $cache[$name];
    }
}

if (!function_exists('extractSeries')) {
    function extractSeries($name) {
        static $cache = [];
        if (isset($cache[$name])) {
            return $cache[$name];
        }
        
        if (preg_match('/(iPhone \d+)/', $name, $matches)) {
            $cache[$name] = $matches[1];
        } elseif (stripos($name, 'Galaxy S') !== false) {
            $cache[$name] = 'Galaxy S';
        } elseif (stripos($name, 'Galaxy Note') !== false) {
            $cache[$name] = 'Galaxy Note';
        } elseif (stripos($name, 'Galaxy Fold') !== false) {
            $cache[$name] = 'Galaxy Fold';
        } elseif (stripos($name, 'Galaxy Flip') !== false) {
            $cache[$name] = 'Galaxy Flip';
        } else {
            $cache[$name] = '';
        }
        
        return $cache[$name];
    }
}

// Pre-calculate Lipa prices for performance
$lipaCalculations = [];
if ($filters['payment_method'] === 'lipa' && $phones->isNotEmpty()) {
    foreach ($phones as $phone) {
        if ($phone->price > 0) {
            $upfrontPayment = ceil($phone->price * 0.4);
            $remainingBalance = $phone->price - $upfrontPayment;
            $totalBalance = ceil($remainingBalance * 1.5);
            $weeklyPayment = ceil($totalBalance / 12);
            
            $lipaCalculations[$phone->id] = [
                'upfront' => $upfrontPayment,
                'weekly' => $weeklyPayment,
            ];
        }
    }
}

// Check if any iPhone exists for Lipa tab
$hasIphones = $phones->contains(function ($phone) {
    return stripos($phone->name, 'iPhone') !== false;
});
@endphp

@extends('layouts.landing-master')

@section('styles')
    <!-- SWIPERJS CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
    
    <!-- Lazy Load Images -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/loading-attribute-polyfill/2.1.7/loading-attribute-polyfill.min.css">
    
    <style>
        /* Optimized Critical CSS */
        .landing-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            padding: clamp(40px, 10vw, 80px) 0 clamp(30px, 8vw, 60px) !important;
            position: relative;
            overflow: hidden;
        }

        .landing-banner-heading {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .filters-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }

        .phone-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .phone-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        /* Deferred CSS - Load after critical content */
        .deferred-styles {
            display: none;
        }
    </style>

    <!-- Inline critical CSS -->
    <noscript>
        <style>
            .phone-card:hover {
                transform: none;
            }
            .quick-filter:hover {
                transform: none;
            }
        </style>
    </noscript>
@endsection

@section('content')
    <!-- Simplified Hero Section -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="landing-banner-heading mb-3">
                            Shop Premium Phones with <span class="text-secondary">Flexible Payments</span>
                        </h1>
                        <p class="lead text-fixed-white mb-0">
                            Latest smartphones at unbeatable prices. Pay full or use our <strong class="text-secondary">Lipa Mdogo Mdogo</strong> option.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

<!-- Search and Filter Section -->
<section class="section pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Filters Card -->
                <div class="card filters-card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('pricing') }}" id="filterForm">
                            <!-- Payment Method (Hidden Field) -->
                            <input type="hidden" name="payment_method" id="paymentMethodInput" value="{{ $filters['payment_method'] }}">
                            
                            <!-- Search Bar with Autocomplete -->
                            <div class="mb-3">
                                <input type="text" 
                                       class="form-control search-input" 
                                       name="search" 
                                       placeholder="🔍 Search for iPhone 13, Samsung Galaxy S23, or any phone model..." 
                                       value="{{ $filters['search'] ?? '' }}"
                                       data-autocomplete-url="{{ route('api.phone.search') }}"
                                       autocomplete="off">
                                <div id="searchSuggestions" class="list-group position-absolute d-none" style="z-index: 1050;"></div>
                            </div>
                            
                            <!-- Quick Filter Badges -->
                            <div class="mb-3">
                                <small class="text-muted d-block mb-2 fw-semibold">Quick Filters:</small>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="quick-filter {{ $filters['brand'] === 'Apple' ? 'active' : '' }}" 
                                            onclick="toggleFilter('brand', 'Apple')">
                                        <i class="ri-apple-fill me-1"></i> iPhone
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['brand'] === 'Samsung' ? 'active' : '' }}" 
                                            onclick="toggleFilter('brand', 'Samsung')">
                                        <i class="ri-android-fill me-1"></i> Samsung
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['price_range'] === '0-50000' ? 'active' : '' }}" 
                                            onclick="toggleFilter('price_range', '0-50000')">
                                        💰 Under 50K
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['price_range'] === '50000-80000' ? 'active' : '' }}" 
                                            onclick="toggleFilter('price_range', '50000-80000')">
                                        💰 50K-80K
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['price_range'] === '80000+' ? 'active' : '' }}" 
                                            onclick="toggleFilter('price_range', '80000+')">
                                        💎 80K+
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['storage'] === '128' ? 'active' : '' }}" 
                                            onclick="toggleFilter('storage', '128')">
                                        📱 128GB
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['storage'] === '256' ? 'active' : '' }}" 
                                            onclick="toggleFilter('storage', '256')">
                                        📱 256GB
                                    </button>
                                    <button type="button" class="quick-filter {{ $filters['storage'] === '512' ? 'active' : '' }}" 
                                            onclick="toggleFilter('storage', '512')">
                                        📱 512GB
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Hidden Inputs for Quick Filters -->
                            <input type="hidden" name="brand" id="brandInput" value="{{ $filters['brand'] ?? '' }}">
                            <input type="hidden" name="price_range" id="priceRangeInput" value="{{ $filters['price_range'] ?? '' }}">
                            <input type="hidden" name="storage" id="storageInput" value="{{ $filters['storage'] ?? '' }}">
                            
                            <!-- Advanced Filters -->
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <select class="form-select filter-control" name="sort" onchange="this.form.submit()">
                                        <option value="newest" {{ $filters['sort'] === 'newest' ? 'selected' : '' }}>⭐ Newest First</option>
                                        <option value="price_asc" {{ $filters['sort'] === 'price_asc' ? 'selected' : '' }}>💲 Price: Low to High</option>
                                        <option value="price_desc" {{ $filters['sort'] === 'price_desc' ? 'selected' : '' }}>💎 Price: High to Low</option>
                                        <option value="name_asc" {{ $filters['sort'] === 'name_asc' ? 'selected' : '' }}>🔤 Name: A-Z</option>
                                        <option value="name_desc" {{ $filters['sort'] === 'name_desc' ? 'selected' : '' }}>🔤 Name: Z-A</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-filter flex-fill">
                                            <i class="ri-search-line me-1"></i> Search
                                        </button>
                                        <a href="{{ route('pricing') }}" class="btn btn-clear">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Results Summary -->
                <div class="results-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">
                                <i class="ri-smartphone-line me-2"></i>
                                <span class="fw-bold">{{ $phones->total() }}</span> phones found
                                @if(isset($filters['price_stats']['min']))
                                    <span class="badge bg-white text-primary ms-2">KES {{ number_format($filters['price_stats']['min']) }} - {{ number_format($filters['price_stats']['max']) }}</span>
                                @endif
                            </h6>
                            <small>
                                @if($filters['search'])
                                    Results for "{{ $filters['search'] }}"
                                @elseif($filters['brand'] || $filters['price_range'] || $filters['storage'])
                                    Filtered results
                                @else
                                    Browse our complete collection
                                @endif
                            </small>
                        </div>
                        <div class="text-end">
                            <i class="ri-shopping-bag-3-line fs-3 opacity-50 d-none d-md-block"></i>
                            @if(isset($filters['suggestions']) && count($filters['suggestions']) > 0)
                                <div class="mt-2">
                                    @foreach($filters['suggestions'] as $suggestion)
                                        <small class="d-block text-white-80">{{ $suggestion }}</small>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="section pt-0" id="pricing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Payment Method Tabs -->
                <div class="d-flex justify-content-center mb-4">
                    <ul class="nav nav-tabs mb-3 tab-style-6 bg-primary-transparent" id="paymentMethodTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $filters['payment_method'] === 'full' ? 'active' : '' }}" 
                                    type="button"
                                    onclick="switchPaymentMethod('full')">
                                <i class="ri-money-dollar-circle-line me-2"></i>Full Payment
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $filters['payment_method'] === 'lipa' ? 'active' : '' }}" 
                                    type="button"
                                    onclick="switchPaymentMethod('lipa')"
                                    @if(!$hasIphones) disabled title="No iPhones available for Lipa Mdogo Mdogo" @endif>
                                <i class="ri-calendar-check-line me-2"></i>Lipa Mdogo Mdogo
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Lipa Info (only show on lipa tab) -->
                @if($filters['payment_method'] === 'lipa')
                <div class="alert alert-info mb-4">
                    <h6 class="alert-heading"><i class="ri-information-fill me-2"></i>Lipa Mdogo Mdogo Explained! 😃</h6>
                    <p class="mb-0">
                        <strong>For iPhones only:</strong> 40% upfront payment, then the remaining balance plus 50% interest divided into 12 weekly payments.
                        <br><strong>Requirements:</strong> National ID and MPESA/Bank statements for the last 3 months.
                    </p>
                </div>
                @endif

                <!-- Phone Grid -->
                @if($phones->count() > 0)
                <div class="row" id="phoneGrid">
                    @foreach($phones as $phone)
                        @php
                            $isIphone = stripos($phone->name, 'iPhone') !== false;
                            $hasLipaPrice = $filters['payment_method'] === 'lipa' && $isIphone && isset($lipaCalculations[$phone->id]);
                            $whatsappMessage = "Hello, I am interested in {$phone->name}";
                            $whatsappUrl = "https://wa.me/254721920545?text=" . urlencode($whatsappMessage);
                        @endphp
                        
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="p-4 text-center border rounded-3 h-100 phone-card">
                                <div class="card-body position-relative">
                                    @if($hasLipaPrice)
                                        <span class="lipa-polepole-badge">Lipa Mdogo Mdogo</span>
                                    @endif
                                    
                                    <!-- Lazy loaded image with placeholder -->
                                    <img src="{{ asset('build/assets/images/placeholder-phone.png') }}" 
                                         data-src="{{ asset($phone->image_path) }}" 
                                         alt="{{ $phone->name }}"
                                         class="img-fluid mb-3 rounded-3 lazy-image" 
                                         style="height:220px; object-fit:cover;"
                                         loading="lazy">
                                    
                                    <h6 class="fw-semibold">{{ $phone->name }}</h6>
                                    
                                    @if($hasLipaPrice)
                                        @if($phone->price == 0)
                                            <p class="fs-18 fw-semibold mb-1 text-info">Price on Request</p>
                                            <p class="text-muted fs-11 fw-semibold mb-3">Contact for Lipa Mdogo Mdogo</p>
                                        @else
                                            <p class="fs-18 fw-semibold mb-1">Upfront: KES {{ number_format($lipaCalculations[$phone->id]['upfront']) }}</p>
                                            <p class="fs-18 fw-semibold mb-1 text-success">Then: KES {{ number_format($lipaCalculations[$phone->id]['weekly']) }}/week</p>
                                            <p class="text-muted fs-11 fw-semibold mb-3">12 weekly payments</p>
                                        @endif
                                    @else
                                        <p class="fs-25 fw-semibold mb-1">
                                            @if($phone->price == 0)
                                                <span class="text-info">Price on Request</span>
                                            @else
                                                KES {{ number_format($phone->price) }}
                                            @endif
                                        </p>
                                        <p class="text-muted fs-11 fw-semibold mb-3">
                                            @if($filters['payment_method'] === 'lipa' && !$isIphone)
                                                Full Payment Only (Not iPhone)
                                            @else
                                                Full Payment
                                            @endif
                                        </p>
                                    @endif
                                    
                                    <a href="{{ $whatsappUrl }}"
                                       target="_blank"
                                       class="btn btn-primary-light btn-wave w-100"
                                       onclick="trackConversion('{{ $phone->name }}')">
                                       <i class="ri-whatsapp-line me-1"></i> Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $phones->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
                
                <!-- Load More Button (AJAX alternative) -->
                @if($phones->hasMorePages() && $phones->currentPage() < 3)
                <div class="text-center mt-4 d-none" id="loadMoreContainer">
                    <button id="loadMoreBtn" class="btn btn-primary" data-page="2" data-loading="false">
                        <i class="ri-refresh-line me-2"></i> Load More Phones
                    </button>
                </div>
                @endif
                
                @else
                <!-- No Results Message -->
                <div class="no-results">
                    <i class="ri-search-line"></i>
                    <h5>No phones found</h5>
                    <p>Try adjusting your search criteria or filters</p>
                    
                    @if(isset($filters['suggestions']) && count($filters['suggestions']) > 0)
                        <div class="mt-3">
                            <p class="text-muted">Suggestions:</p>
                            <ul class="list-unstyled">
                                @foreach($filters['suggestions'] as $suggestion)
                                    <li><small>{{ $suggestion }}</small></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <a href="{{ route('pricing') }}" class="btn btn-primary mt-3">
                        <i class="ri-refresh-line me-2"></i> Clear All Filters
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Deferred non-critical content -->
<div class="deferred-styles">
    <!-- Filter Section styles -->
    <style>
        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(26, 71, 42, 0.15);
        }

        .quick-filter {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .quick-filter:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .quick-filter.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
        }

        .quick-filter:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .filter-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 71, 42, 0.4);
        }

        .btn-clear {
            background: transparent;
            color: #6c757d;
            border: 2px solid #e9ecef;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-clear:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            transform: translateY(-2px);
        }

        /* Payment Tabs */
        .nav-tabs .nav-link {
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 10px 10px 0 0;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
            border: none !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        }

        .nav-tabs .nav-link:hover:not(.active) {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        /* Badge */
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

        /* Results Info */
        .results-info {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        }

        /* Alert */
        .alert-info {
            background: var(--primary-light);
            border-left: 4px solid var(--primary-color);
            color: var(--primary-dark);
        }

        /* Empty State */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        /* Pagination */
        .pagination .page-link {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            color: var(--primary-color);
            padding: 8px 16px;
            margin: 0 4px;
        }

        .pagination .page-link:hover {
            background: var(--primary-light);
            border-color: var(--primary-color);
        }

        .pagination .active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
    </style>
</div>
@endsection

@section('scripts')
    <!-- Deferred JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
            crossorigin="anonymous" referrerpolicy="no-referrer"
            defer></script>
    
    <!-- SWIPER JS (only load if needed) -->
    @if($phones->count() > 8)
    <script src="{{ asset('build/assets/libs/swiper/swiper-bundle.min.js') }}" defer></script>
    @endif

    <!-- INTERNAL LANDING JS -->
    @vite('resources/assets/js/landing.js')

    <!-- Main JavaScript -->
    <script>
        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Load deferred styles
            loadDeferredStyles();
            
            // Initialize lazy loading
            initLazyLoading();
            
            // Initialize search autocomplete
            initSearchAutocomplete();
            
            // Initialize scroll position restoration
            initScrollRestoration();
            
            // Initialize load more button
            initLoadMore();
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
        }
        
        function initLazyLoading() {
            const lazyImages = document.querySelectorAll('.lazy-image');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy-image');
                            imageObserver.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '50px 0px',
                    threshold: 0.01
                });
                
                lazyImages.forEach(img => imageObserver.observe(img));
            } else {
                // Fallback for older browsers
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.remove('lazy-image');
                });
            }
        }
        
        function initSearchAutocomplete() {
            const searchInput = document.querySelector('[data-autocomplete-url]');
            const suggestionsContainer = document.getElementById('searchSuggestions');
            
            if (!searchInput || !suggestionsContainer) return;
            
            let debounceTimer;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    suggestionsContainer.classList.add('d-none');
                    return;
                }
                
                debounceTimer = setTimeout(() => {
                    fetch(`${searchInput.dataset.autocompleteUrl}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.suggestions.length > 0) {
                                suggestionsContainer.innerHTML = '';
                                data.suggestions.forEach(suggestion => {
                                    const item = document.createElement('a');
                                    item.href = '#';
                                    item.className = 'list-group-item list-group-item-action';
                                    item.textContent = suggestion;
                                    item.addEventListener('click', (e) => {
                                        e.preventDefault();
                                        searchInput.value = suggestion;
                                        suggestionsContainer.classList.add('d-none');
                                        document.getElementById('filterForm').submit();
                                    });
                                    suggestionsContainer.appendChild(item);
                                });
                                suggestionsContainer.classList.remove('d-none');
                            } else {
                                suggestionsContainer.classList.add('d-none');
                            }
                        })
                        .catch(() => {
                            suggestionsContainer.classList.add('d-none');
                        });
                }, 300);
            });
            
            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                    suggestionsContainer.classList.add('d-none');
                }
            });
            
            // Handle keyboard navigation
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    suggestionsContainer.classList.add('d-none');
                }
            });
        }
        
        function initScrollRestoration() {
            if (localStorage.getItem('scrollPosition')) {
                setTimeout(() => {
                    window.scrollTo(0, parseInt(localStorage.getItem('scrollPosition')));
                    localStorage.removeItem('scrollPosition');
                }, 100);
            }
            
            document.getElementById('filterForm').addEventListener('submit', function() {
                localStorage.setItem('scrollPosition', window.pageYOffset);
            });
        }
        
        function initLoadMore() {
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const phoneGrid = document.getElementById('phoneGrid');
            
            if (!loadMoreBtn || !phoneGrid) return;
            
            loadMoreBtn.addEventListener('click', function() {
                if (this.dataset.loading === 'true') return;
                
                this.dataset.loading = 'true';
                this.innerHTML = '<i class="ri-loader-4-line me-2"></i> Loading...';
                
                const nextPage = parseInt(this.dataset.page);
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('page', nextPage);
                
                fetch(currentUrl)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newItems = doc.querySelectorAll('#phoneGrid > div');
                        
                        newItems.forEach(item => {
                            phoneGrid.appendChild(item);
                        });
                        
                        this.dataset.page = nextPage + 1;
                        this.dataset.loading = 'false';
                        this.innerHTML = '<i class="ri-refresh-line me-2"></i> Load More Phones';
                        
                        // Check if there are more pages
                        const pagination = doc.querySelector('.pagination');
                        if (!pagination || !pagination.querySelector('.page-item:last-child .page-link')) {
                            this.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        this.dataset.loading = 'false';
                        this.innerHTML = '<i class="ri-refresh-line me-2"></i> Try Again';
                    });
            });
        }
        
        // Filter functions
        function toggleFilter(filterName, value) {
            const input = document.getElementById(filterName + 'Input');
            const currentValue = input.value;
            
            if (currentValue === value) {
                input.value = '';
            } else {
                input.value = value;
            }
            
            document.getElementById('filterForm').submit();
        }
        
        function switchPaymentMethod(method) {
            document.getElementById('paymentMethodInput').value = method;
            document.getElementById('filterForm').submit();
        }
        
        function trackConversion(phoneName) {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'conversion', {
                    'send_to': 'AW-XXXXXXXXX/YYYYYYYYYYYY',
                    'value': 1.0,
                    'currency': 'KES',
                    'transaction_id': phoneName
                });
            }
            
            // Store in localStorage for analytics
            const conversions = JSON.parse(localStorage.getItem('phone_conversions') || '[]');
            conversions.push({
                phone: phoneName,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem('phone_conversions', JSON.stringify(conversions.slice(-50)));
        }
        
        // Performance monitoring
        window.addEventListener('load', function() {
            const perfData = {
                dcl: performance.timing.domContentLoadedEventEnd - performance.timing.navigationStart,
                load: performance.timing.loadEventEnd - performance.timing.navigationStart,
                fcp: performance.getEntriesByName('first-contentful-paint')[0]?.startTime || 0
            };
            
            console.log('Performance Metrics:', perfData);
            
            // Send to analytics if needed
            if (typeof gtag !== 'undefined') {
                gtag('event', 'timing_complete', {
                    'name': 'page_load',
                    'value': perfData.load,
                    'event_category': 'Performance'
                });
            }
        });
    </script>
@endsection