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

// Pre-calculate Lipa prices for performance
$lipaCalculations = [];
if (isset($filters['payment_method']) && $filters['payment_method'] === 'lipa' && $phones->isNotEmpty()) {
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
    
    <style>
        /* Fixed Banner CSS - Green Theme */
        .landing-banner {
            background: linear-gradient(135deg, #1a472a 0%, #2e7d32 100%) !important;
            padding: clamp(40px, 10vw, 80px) 0 clamp(30px, 8vw, 60px) !important;
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
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .text-secondary {
            color: #e8f5e9 !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .text-fixed-white {
            color: #ffffff !important;
        }

        .landing-banner .lead {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 400;
        }

        /* Filters Card */
        .filters-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }

        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #1a472a;
            box-shadow: 0 0 0 0.25rem rgba(26, 71, 42, 0.15);
        }

        /* Quick Filter Badges */
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
            margin: 4px;
            background: white;
        }

        .quick-filter:hover {
            border-color: #1a472a;
            color: #1a472a;
            background: #e8f5e9;
            transform: translateY(-2px);
        }

        .quick-filter.active {
            background: #1a472a;
            color: white;
            border-color: #1a472a;
            box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
        }

        /* Phone Cards */
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

        /* Results Info */
        .results-info {
            background: linear-gradient(135deg, #1a472a, #2e7d32);
            color: white;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        }

        /* Other styles remain the same... */
        
        /* Responsive design */
        @media (max-width: 768px) {
            .landing-banner-heading {
                font-size: 2rem;
            }
            
            .landing-banner {
                padding: 60px 0 40px !important;
            }
            
            .filters-card {
                margin-top: -20px;
            }
            
            .quick-filter {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
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
                            
                            <!-- Search Bar -->
                            <div class="mb-3">
                                <input type="text" 
                                       class="form-control search-input" 
                                       name="search" 
                                       placeholder="🔍 Search for iPhone 13, Samsung Galaxy S23, or any phone model..." 
                                       value="{{ $filters['search'] ?? '' }}">
                            </div>
                            
                            <!-- Quick Filter Badges -->
                            <div class="mb-3">
                                <small class="text-muted d-block mb-2 fw-semibold">Quick Filters:</small>
                                <div class="d-flex flex-wrap">
                                    <span class="quick-filter {{ $filters['brand'] === 'Apple' ? 'active' : '' }}" 
                                          onclick="toggleFilter('brand', 'Apple')">
                                        <i class="ri-apple-fill me-1"></i> iPhone
                                    </span>
                                    <span class="quick-filter {{ $filters['brand'] === 'Samsung' ? 'active' : '' }}" 
                                          onclick="toggleFilter('brand', 'Samsung')">
                                        <i class="ri-android-fill me-1"></i> Samsung
                                    </span>
                                    <span class="quick-filter {{ $filters['price_range'] === '0-50000' ? 'active' : '' }}" 
                                          onclick="toggleFilter('price_range', '0-50000')">
                                        💰 Under 50K
                                    </span>
                                    <span class="quick-filter {{ $filters['price_range'] === '50000-80000' ? 'active' : '' }}" 
                                          onclick="toggleFilter('price_range', '50000-80000')">
                                        💰 50K-80K
                                    </span>
                                    <span class="quick-filter {{ $filters['price_range'] === '80000+' ? 'active' : '' }}" 
                                          onclick="toggleFilter('price_range', '80000+')">
                                        💎 80K+
                                    </span>
                                    <span class="quick-filter {{ $filters['storage'] === '128' ? 'active' : '' }}" 
                                          onclick="toggleFilter('storage', '128')">
                                        📱 128GB
                                    </span>
                                    <span class="quick-filter {{ $filters['storage'] === '256' ? 'active' : '' }}" 
                                          onclick="toggleFilter('storage', '256')">
                                        📱 256GB
                                    </span>
                                    <span class="quick-filter {{ $filters['storage'] === '512' ? 'active' : '' }}" 
                                          onclick="toggleFilter('storage', '512')">
                                        📱 512GB
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Hidden Inputs for Quick Filters -->
                            <input type="hidden" name="brand" id="brandInput" value="{{ $filters['brand'] ?? '' }}">
                            <input type="hidden" name="price_range" id="priceRangeInput" value="{{ $filters['price_range'] ?? '' }}">
                            <input type="hidden" name="storage" id="storageInput" value="{{ $filters['storage'] ?? '' }}">
                            
                            <!-- Advanced Filters -->
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <select class="form-select filter-control" name="sort">
                                        <option value="random" {{ $filters['sort'] === 'random' ? 'selected' : '' }}>🎲 Random</option>
                                        <option value="newest" {{ $filters['sort'] === 'newest' ? 'selected' : '' }}>⭐ Newest First</option>
                                        <option value="price_asc" {{ $filters['sort'] === 'price_asc' ? 'selected' : '' }}>💲 Price: Low to High</option>
                                        <option value="price_desc" {{ $filters['sort'] === 'price_desc' ? 'selected' : '' }}>💎 Price: High to Low</option>
                                        <option value="name_asc" {{ $filters['sort'] === 'name_asc' ? 'selected' : '' }}>🔤 Name: A-Z</option>
                                        <option value="name_desc" {{ $filters['sort'] === 'name_desc' ? 'selected' : '' }}>🔤 Name: Z-A</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-filter flex-fill" style="background: linear-gradient(135deg, #1a472a, #2e7d32); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 600;">
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
                                @if(isset($filters['price_stats']) && $filters['price_stats'])
                                    <span class="badge bg-white text-primary ms-2">KES {{ number_format($filters['price_stats']['min']) }} - {{ number_format($filters['price_stats']['max']) }}</span>
                                @endif
                            </h6>
                            <small>
                                @if($filters['search'])
                                    Results for "{{ $filters['search'] }}"
                                @elseif($filters['brand'] || $filters['price_range'] || $filters['storage'])
                                    Filtered results
                                @else
                                    Browse our complete collection (Random order)
                                @endif
                            </small>
                        </div>
                        <div>
                            <i class="ri-shopping-bag-3-line fs-3 opacity-50"></i>
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
                    <ul class="nav nav-tabs mb-3 tab-style-6" id="paymentMethodTab" role="tablist" style="background: rgba(26, 71, 42, 0.1);">
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
                <div class="alert alert-info mb-4" style="background: #e8f5e9; border-left: 4px solid #1a472a; color: #1a472a;">
                    <h6 class="alert-heading"><i class="ri-information-fill me-2"></i>Lipa Mdogo Mdogo Explained! 😃</h6>
                    <p class="mb-0">
                        <strong>For iPhones only:</strong> 40% upfront payment, then the remaining balance plus 50% interest divided into 12 weekly payments.
                        <br><strong>Requirements:</strong> National ID and MPESA/Bank statements for the last 3 months.
                    </p>
                </div>
                @endif

                <!-- Phone Grid -->
                @if($phones->count() > 0)
                <div class="row">
                    @foreach($phones as $phone)
                        @php
                            $isIphone = stripos($phone->name, 'iPhone') !== false;
                            $hasLipaPrice = isset($filters['payment_method']) && $filters['payment_method'] === 'lipa' && $isIphone && isset($lipaCalculations[$phone->id]);
                            $whatsappMessage = "Hello, I am interested in {$phone->name}";
                            $whatsappUrl = "https://wa.me/254721920545?text=" . urlencode($whatsappMessage);
                        @endphp
                        
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="p-4 text-center border rounded-3 h-100 phone-card">
                                <div class="card-body position-relative">
                                    @if($hasLipaPrice)
                                        <span class="lipa-polepole-badge">Lipa Mdogo Mdogo</span>
                                    @endif
                                    
                                    <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}"
                                        class="img-fluid mb-3 rounded-3" style="height:220px; object-fit:cover;">
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
                                            @if(isset($filters['payment_method']) && $filters['payment_method'] === 'lipa' && !$isIphone)
                                                Full Payment Only (Not iPhone)
                                            @else
                                                Full Payment
                                            @endif
                                        </p>
                                    @endif
                                    
                                    <a href="{{ $whatsappUrl }}"
                                       target="_blank"
                                       class="btn btn-primary-light btn-wave w-100" style="background: #e8f5e9; color: #1a472a; border: 2px solid #1a472a;">
                                       <i class="ri-whatsapp-line me-1"></i> Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $phones->links('pagination::bootstrap-5') }}
                </div>
                @else
                <!-- No Results Message -->
                <div class="no-results" style="text-align: center; padding: 60px 20px; color: #6c757d;">
                    <i class="ri-search-line" style="font-size: 4rem; margin-bottom: 20px; opacity: 0.5;"></i>
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
                    
                    <a href="{{ route('pricing') }}" class="btn btn-primary mt-3" style="background: #1a472a; border-color: #1a472a;">
                        <i class="ri-refresh-line me-2"></i> Clear All Filters
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
        function toggleFilter(filterName, value) {
            const input = document.getElementById(filterName + 'Input');
            if (input.value === value) {
                // Toggle off if clicking same filter
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

        // Auto-submit on sort change
        document.querySelector('select[name="sort"]').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Maintain scroll position after filter
        $(document).ready(function() {
            if (localStorage.getItem('scrollPosition')) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
                localStorage.removeItem('scrollPosition');
            }
        });

        $('#filterForm').on('submit', function() {
            localStorage.setItem('scrollPosition', window.pageYOffset);
        });
    </script>
@endsection