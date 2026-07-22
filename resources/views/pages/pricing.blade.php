@php
    $isLipa = ($filters['payment_method'] ?? 'full') === 'lipa';
    $hasActiveFilters = filled($filters['search'] ?? null)
        || filled($filters['brand'] ?? null)
        || filled($filters['price_range'] ?? null)
        || filled($filters['storage'] ?? null);

@endphp

@extends('layouts.landing-master')

@section('styles')
<style>
    .catalogue-page { background: #f7f9f7; }
    .catalogue-hero {
        position: relative;
        overflow: hidden;
        padding: 8.5rem 0 6.5rem !important;
        background:
            radial-gradient(circle at 82% 10%, rgba(77, 153, 108, .22), transparent 26%),
            linear-gradient(125deg, #082a1c, #10432d) !important;
    }
    .catalogue-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        width: auto;
        height: auto;
        background-color: transparent !important;
        background-image: radial-gradient(rgba(255,255,255,.11) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: .16;
    }
    .catalogue-hero__content { position: relative; z-index: 1; max-width: 760px; }
    .catalogue-eyebrow { display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1rem; color: #a8d7b8; font-size: .75rem; font-weight: 800; letter-spacing: .13em; }
    .catalogue-eyebrow::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #f3b33d; }
    .catalogue-title { margin-bottom: 1rem; color: #fff; font-size: clamp(2.7rem, 5vw, 4.4rem); font-weight: 800; line-height: 1.04; letter-spacing: -.05em; text-shadow: none; }
    .catalogue-title span { color: #f7c965; }
    .catalogue-subtitle { max-width: 620px; margin: 0; color: rgba(255,255,255,.7); font-size: 1.05rem; line-height: 1.7; }

    .catalogue-shell { position: relative; z-index: 5; margin-top: -3.4rem; padding-bottom: 6rem; }
    .filter-panel { padding: 1.25rem; background: #fff; border: 1px solid #e3e9e5; border-radius: 20px; box-shadow: 0 20px 55px rgba(15,49,32,.1); }
    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; top: 50%; left: 1rem; color: #718078; font-size: 1.15rem; transform: translateY(-50%); }
    .catalogue-search { min-height: 54px; padding: .8rem 1rem .8rem 3rem; border: 1px solid #dfe6e1; border-radius: 13px; background: #fafcfb; font-size: .95rem; }
    .catalogue-search:focus { border-color: #77a98a; background: #fff; box-shadow: 0 0 0 4px rgba(39,114,75,.1); }
    .search-button { min-height: 54px; padding-inline: 1.35rem; border: 0; border-radius: 13px; background: #123f2b; color: #fff; font-weight: 800; }
    .search-button:hover { background: #092a1c; color: #fff; }
    .filter-label { margin: 1.15rem 0 .55rem; color: #748078; font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .filter-chips { display: flex; flex-wrap: wrap; gap: .5rem; }
    .filter-chip { display: inline-flex; align-items: center; gap: .4rem; padding: .62rem .82rem; border: 1px solid #dfe6e1; border-radius: 999px; background: #fff; color: #48564e; font-size: .82rem; font-weight: 700; transition: .2s ease; }
    .filter-chip:hover { border-color: #84ae93; color: #123f2b; background: #f1f7f3; }
    .filter-chip.active { border-color: #123f2b; background: #123f2b; color: #fff; box-shadow: 0 8px 20px rgba(18,63,43,.15); }

    .catalogue-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin: 1.75rem 0 1.25rem; padding: 1rem 1.1rem; background: #fff; border: 1px solid #e3e9e5; border-radius: 16px; }
    .result-count { color: #17251d; font-size: .96rem; font-weight: 800; }
    .result-count small { display: block; margin-top: .15rem; color: #758179; font-size: .75rem; font-weight: 500; }
    .toolbar-actions { display: flex; align-items: center; gap: .65rem; }
    .payment-switch { display: inline-flex; padding: .3rem; background: #eef3ef; border-radius: 11px; }
    .payment-option { padding: .6rem .78rem; border: 0; border-radius: 8px; background: transparent; color: #5e6d64; font-size: .79rem; font-weight: 800; }
    .payment-option.active { background: #fff; color: #123f2b; box-shadow: 0 4px 12px rgba(20,34,27,.08); }
    .sort-select { width: 190px; min-height: 42px; border-color: #dfe6e1; border-radius: 10px; color: #455249; font-size: .8rem; font-weight: 700; }
    .clear-filters { display: inline-flex; align-items: center; gap: .35rem; color: #6a776f; font-size: .78rem; font-weight: 700; }

    .lipa-notice { display: flex; gap: .8rem; margin-bottom: 1.25rem; padding: 1rem 1.1rem; background: #fff8e8; border: 1px solid #f2ddb0; border-radius: 14px; color: #66501f; }
    .lipa-notice i { color: #b67a08; font-size: 1.2rem; }
    .lipa-notice strong { display: block; margin-bottom: .15rem; color: #493812; }

    .catalogue-grid { --bs-gutter-x: 1.25rem; --bs-gutter-y: 1.25rem; }
    .catalogue-card { display: flex; height: 100%; flex-direction: column; padding: .75rem; overflow: hidden; background: #fff; border: 1px solid #e3e9e5; border-radius: 18px; box-shadow: 0 10px 32px rgba(20,34,27,.055); transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .catalogue-card:hover { transform: translateY(-5px); border-color: #c9d9ce; box-shadow: 0 22px 48px rgba(20,34,27,.11); }
    .product-media { position: relative; display: grid; height: 255px; place-items: center; overflow: hidden; background: #f3f6f4; border-radius: 13px; }
    .product-media img { width: 100%; height: 100%; padding: 1.1rem; object-fit: contain; transition: transform .3s ease; }
    .catalogue-card:hover .product-media img { transform: scale(1.035); }
    .image-placeholder { display: grid; width: 100%; height: 100%; place-items: center; color: #8b9890; text-align: center; }
    .image-placeholder i { display: block; margin-bottom: .4rem; font-size: 2.4rem; color: #aab5ae; }
    .image-placeholder span { font-size: .75rem; font-weight: 700; }
    .plan-badge { position: absolute; z-index: 2; top: .75rem; right: .75rem; padding: .38rem .58rem; border-radius: 999px; background: #fff1cf; color: #8a5a00; font-size: .65rem; font-weight: 800; }
    .product-content { display: flex; flex: 1; flex-direction: column; padding: 1rem .5rem .5rem; }
    .product-kicker { color: #27724b; font-size: .65rem; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
    .product-name { min-height: 2.8rem; margin: .45rem 0 .85rem; color: #17251d; font-size: .98rem; font-weight: 800; line-height: 1.4; letter-spacing: -.02em; }
    .product-name a { color: inherit; }
    .product-name a:hover { color: #27724b; }
    .product-price { margin: 0; color: #17251d; font-family: 'Manrope', sans-serif; font-size: 1.25rem; font-weight: 800; letter-spacing: -.03em; }
    .product-price--request { color: #27724b; font-size: 1.05rem; }
    .payment-detail { margin-top: .28rem; color: #748078; font-size: .74rem; }
    .product-action { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding: .78rem .85rem; border-radius: 10px; background: #eaf4ed; color: #123f2b; font-size: .82rem; font-weight: 800; }
    .product-action:hover { background: #123f2b; color: #fff; }

    .pagination { gap: .3rem; }
    .page-link { min-width: 40px; border-color: #e0e7e2; border-radius: 9px !important; color: #365342; text-align: center; }
    .page-item.active .page-link { border-color: #123f2b; background: #123f2b; }
    .empty-results { padding: 5rem 1rem; text-align: center; background: #fff; border: 1px solid #e3e9e5; border-radius: 18px; }
    .empty-results i { color: #9ba79f; font-size: 3rem; }

    @media (max-width: 991.98px) {
        .catalogue-hero { padding: 7.5rem 0 5.5rem !important; }
        .catalogue-toolbar { align-items: flex-start; flex-direction: column; }
        .toolbar-actions { width: 100%; flex-wrap: wrap; }
    }
    @media (max-width: 575.98px) {
        .catalogue-hero { padding: 6.8rem 0 5rem !important; }
        .catalogue-title { font-size: 2.65rem; }
        .catalogue-shell { margin-top: -2.25rem; }
        .filter-panel { padding: .85rem; border-radius: 16px; }
        .search-button { width: 100%; }
        .toolbar-actions, .payment-switch { width: 100%; }
        .payment-option { flex: 1; }
        .sort-select { width: 100%; }
        .product-media { height: 230px; }
    }
</style>
@endsection

@section('content')
<main class="catalogue-page">
    <header class="catalogue-hero">
        <div class="container catalogue-hero__content">
            <span class="catalogue-eyebrow">PHONE EXPRESS COLLECTION</span>
            <h1 class="catalogue-title">Find a phone that <span>fits your life.</span></h1>
            <p class="catalogue-subtitle">Compare smartphones, filter by what matters, and talk to our team when you are ready.</p>
        </div>
    </header>

    <div class="container catalogue-shell">
        <form method="GET" action="{{ route('pricing') }}" id="filterForm" class="filter-panel">
            <input type="hidden" name="payment_method" id="paymentMethodInput" value="{{ $filters['payment_method'] ?? 'full' }}">
            <input type="hidden" name="brand" id="brandInput" value="{{ $filters['brand'] ?? '' }}">
            <input type="hidden" name="price_range" id="priceRangeInput" value="{{ $filters['price_range'] ?? '' }}">
            <input type="hidden" name="storage" id="storageInput" value="{{ $filters['storage'] ?? '' }}">

            <div class="row g-2">
                <div class="col-sm">
                    <div class="search-wrap">
                        <i class="ri-search-line"></i>
                        <input class="form-control catalogue-search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search iPhone, Samsung, Pixel…" aria-label="Search phones">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn search-button" type="submit">Search phones</button></div>
            </div>

            <p class="filter-label">Popular filters</p>
            <div class="filter-chips">
                @foreach($brands as $brand)
                    <button type="button" class="filter-chip {{ ($filters['brand'] ?? '') === $brand->name ? 'active' : '' }}" data-value="{{ $brand->name }}" onclick="toggleFilter('brand', this.dataset.value)">
                        @if($brand->name === 'Apple')<i class="ri-apple-fill"></i>@elseif($brand->name === 'Samsung')<i class="ri-android-fill"></i>@endif
                        {{ $brand->name === 'Apple' ? 'iPhone' : $brand->name }}
                    </button>
                @endforeach
                <button type="button" class="filter-chip {{ ($filters['price_range'] ?? '') === '0-50000' ? 'active' : '' }}" onclick="toggleFilter('price_range', '0-50000')">Under KES 50K</button>
                <button type="button" class="filter-chip {{ ($filters['price_range'] ?? '') === '50000-80000' ? 'active' : '' }}" onclick="toggleFilter('price_range', '50000-80000')">KES 50K–80K</button>
                <button type="button" class="filter-chip {{ ($filters['price_range'] ?? '') === '80000+' ? 'active' : '' }}" onclick="toggleFilter('price_range', '80000+')">KES 80K+</button>
                @foreach(['128', '256', '512'] as $storage)
                    <button type="button" class="filter-chip {{ ($filters['storage'] ?? '') === $storage ? 'active' : '' }}" onclick="toggleFilter('storage', '{{ $storage }}')">{{ $storage }}GB</button>
                @endforeach
            </div>
        </form>

        <div class="catalogue-toolbar">
            <div class="result-count">
                {{ number_format($phones->total()) }} {{ Str::plural('phone', $phones->total()) }}
                <small>{{ $hasActiveFilters ? 'Matching your selected filters' : 'Explore the complete collection' }}</small>
            </div>
            <div class="toolbar-actions">
                <div class="payment-switch" aria-label="Payment method">
                    <button type="button" class="payment-option {{ !$isLipa ? 'active' : '' }}" onclick="switchPaymentMethod('full')">Pay in full</button>
                    <button type="button" class="payment-option {{ $isLipa ? 'active' : '' }}" onclick="switchPaymentMethod('lipa')">Lipa Mdogo Mdogo</button>
                </div>
                <select class="form-select sort-select" name="sort" form="filterForm" aria-label="Sort phones">
                    <option value="random" @selected(($filters['sort'] ?? '') === 'random')>Featured</option>
                    <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest first</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: low to high</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: high to low</option>
                    <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Name: A–Z</option>
                </select>
                @if($hasActiveFilters)
                    <a href="{{ route('pricing', ['payment_method' => $filters['payment_method'] ?? 'full']) }}" class="clear-filters"><i class="ri-close-line"></i> Clear</a>
                @endif
            </div>
        </div>

        @if($isLipa)
            <div class="lipa-notice">
                <i class="ri-information-line"></i>
                <div><strong>Lipa Mdogo Mdogo for iPhones</strong><span>40% upfront, followed by 12 weekly payments. Approval requirements apply.</span></div>
            </div>
        @endif

        @if($phones->isNotEmpty())
            <div class="row catalogue-grid">
                @foreach($phones as $phone)
                    @php
                        $hasLipa = $isLipa && $phone->payment_plan_eligible && filled($phone->lipa_upfront);
                        $hasImage = filled($phone->image_path) && is_file(public_path($phone->image_path));
                        $whatsappUrl = 'https://wa.me/254721920545?text=' . urlencode("Hello, I am interested in {$phone->name}");
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <article class="catalogue-card">
                            <div class="product-media">
                                @if($hasLipa)<span class="plan-badge">Lipa Mdogo Mdogo</span>@endif
                                @if($hasImage)
                                    <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}" loading="lazy">
                                @else
                                    <div class="image-placeholder"><div><i class="ri-image-line"></i><span>Image coming soon</span></div></div>
                                @endif
                            </div>
                            <div class="product-content">
                                <span class="product-kicker">{{ $hasLipa ? 'Flexible payment' : 'Pay in full' }}</span>
                                <h2 class="product-name"><a href="{{ route('phones.show', $phone) }}">{{ $phone->name }}</a></h2>
                                @if($hasLipa)
                                    <p class="product-price">KES {{ number_format($phone->lipa_upfront) }} upfront</p>
                                    <span class="payment-detail">Then KES {{ number_format($phone->lipa_installment) }} weekly for {{ $phone->lipa_weeks }} weeks</span>
                                @elseif($phone->price > 0)
                                    <p class="product-price">KES {{ number_format($phone->price) }}</p>
                                    <span class="payment-detail">Current listed price</span>
                                @else
                                    <p class="product-price product-price--request">Price on request</p>
                                    <span class="payment-detail">Ask our team for today’s price</span>
                                @endif
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="product-action"><span>Enquire on WhatsApp</span><i class="ri-arrow-right-line"></i></a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">{{ $phones->links('pagination::bootstrap-5') }}</div>
        @else
            <div class="empty-results">
                <i class="ri-search-line"></i>
                <h2 class="mt-3">No phones matched those filters</h2>
                <p class="text-muted">Try another search or clear your filters to see the full collection.</p>
                <a href="{{ route('pricing') }}" class="btn btn-primary mt-2">View all phones</a>
            </div>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    const filterForm = document.getElementById('filterForm');

    function toggleFilter(filterName, value) {
        const input = document.getElementById(`${filterName}Input`);
        input.value = input.value === value ? '' : value;
        filterForm.submit();
    }

    function switchPaymentMethod(method) {
        document.getElementById('paymentMethodInput').value = method;
        filterForm.submit();
    }

    document.querySelector('.sort-select').addEventListener('change', () => filterForm.submit());
</script>
@endsection
