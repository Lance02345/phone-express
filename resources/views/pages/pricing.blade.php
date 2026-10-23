@php
    $isLipa = ($filters['payment_method'] ?? 'full') === 'lipa';
    $categoryMeta = [
        'Smartphones' => ['Phones', 'ri-smartphone-line'],
        'Tablets' => ['Tablets', 'ri-tablet-line'],
        'Laptops' => ['MacBooks', 'ri-macbook-line'],
        'Desktops' => ['Mac mini', 'ri-computer-line'],
        'Watches' => ['Watches', 'ri-time-line'],
        'Audio' => ['Audio', 'ri-headphone-line'],
        'Accessories' => ['Accessories', 'ri-keyboard-line'],
    ];
    $priceRanges = [
        '0-20000' => 'Under KES 20K',
        '20000-50000' => 'KES 20K – 50K',
        '50000-100000' => 'KES 50K – 100K',
        '100000-200000' => 'KES 100K – 200K',
        '200000+' => 'KES 200K+',
    ];
    $storageOptions = ['64' => '64GB', '128' => '128GB', '256' => '256GB', '512' => '512GB', '1024' => '1TB', '2048' => '2TB'];
    $activeFilters = collect([
        'search' => filled($filters['search'] ?? null) ? '“' . $filters['search'] . '”' : null,
        'category' => filled($filters['category'] ?? null) ? ($categoryMeta[$filters['category']][0] ?? $filters['category']) : null,
        'brand' => $filters['brand'] ?? null,
        'price_range' => $priceRanges[$filters['price_range'] ?? ''] ?? null,
        'storage' => $storageOptions[$filters['storage'] ?? ''] ?? null,
    ])->filter();
    $hasActiveFilters = $activeFilters->isNotEmpty();
    $allCount = $categoryCounts->sum();
@endphp

@extends('layouts.landing-master')

@section('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@1&display=swap">
<style>
    .catalogue-page { background: #fafafa; }
    .catalogue-hero {
        position: relative;
        overflow: hidden;
        padding: 8.5rem 0 6.5rem !important;
        background:
            radial-gradient(ellipse 50% 70% at 80% 20%, rgba(255, 255, 255, .14), transparent 70%),
            #000000 !important;
    }
    .catalogue-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        width: auto;
        height: auto;
        background-color: transparent !important;
background-image:
            linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
        background-size: 64px 64px;
        -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, #000 30%, transparent 80%);
        mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, #000 30%, transparent 80%);
        opacity: 1;
    }
    .catalogue-hero__content { position: relative; z-index: 1; max-width: 760px; }
    .catalogue-eyebrow { display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1rem; color: #bdbdbd; font-size: .75rem; font-weight: 800; letter-spacing: .13em; }
    .catalogue-eyebrow::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #ffffff; }
    .catalogue-title { margin-bottom: 1rem; color: #fff; font-size: clamp(2.7rem, 5vw, 4.4rem); font-weight: 800; line-height: 1.04; letter-spacing: -.05em; text-shadow: none; }
    .catalogue-title span { color: #ffffff; font-family: 'Instrument Serif', serif; font-style: italic; font-weight: 400; letter-spacing: -.01em; }
    .catalogue-subtitle { max-width: 620px; margin: 0; color: rgba(255,255,255,.7); font-size: 1.05rem; line-height: 1.7; }

    .catalogue-shell { position: relative; z-index: 5; margin-top: -3.4rem; padding-bottom: 6rem; }
    .filter-panel { padding: 1.25rem; background: #fff; border: 1px solid #e8e8e8; border-radius: 20px; box-shadow: 0 20px 55px rgba(0,0,0,.08); }
    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; top: 50%; left: 1rem; color: #737373; font-size: 1.15rem; transform: translateY(-50%); }
    .catalogue-search { min-height: 54px; padding: .8rem 1rem .8rem 3rem; border: 1px solid #e5e5e5; border-radius: 13px; background: #fafafa; font-size: .95rem; }
    .catalogue-search:focus { border-color: #0a0a0a; background: #fff; box-shadow: 0 0 0 4px rgba(0,0,0,.06); }
    .search-button { min-height: 54px; padding-inline: 1.35rem; border: 0; border-radius: 13px; background: #0a0a0a; color: #fff; font-weight: 800; }
    .search-button:hover { background: #262626; color: #fff; }
    .filter-label { margin: 1.15rem 0 .55rem; color: #737373; font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .filter-chip { display: inline-flex; flex: 0 0 auto; align-items: center; gap: .4rem; padding: .55rem .8rem; border: 1px solid #e5e5e5; border-radius: 999px; background: #fff; color: #404040; font-size: .8rem; font-weight: 700; white-space: nowrap; transition: .2s ease; }
    .filter-chip small { color: #a3a3a3; font-size: .7rem; font-weight: 700; }
    .filter-chip:hover { border-color: #a3a3a3; color: #0a0a0a; background: #f5f5f5; }
    .filter-chip.active { border-color: #0a0a0a; background: #0a0a0a; color: #fff; box-shadow: 0 8px 20px rgba(0,0,0,.15); }
    .filter-chip.active small { color: rgba(255,255,255,.6); }

    /* Horizontal rows scroll sideways instead of wrapping into a wall of chips */
    .scroll-row { display: flex; gap: .5rem; margin: 0 -1.25rem; padding: .15rem 1.25rem .35rem; overflow-x: auto; scrollbar-width: none; -webkit-mask-image: linear-gradient(90deg, transparent, #000 1.25rem, #000 calc(100% - 2.5rem), transparent); mask-image: linear-gradient(90deg, transparent, #000 1.25rem, #000 calc(100% - 2.5rem), transparent); }
    .scroll-row::-webkit-scrollbar { display: none; }

    .category-tabs { margin-top: 1.1rem; }
    .category-tab { display: flex; flex: 0 0 auto; min-width: 104px; flex-direction: column; align-items: flex-start; gap: .55rem; padding: .8rem .9rem; border: 1px solid #e8e8e8; border-radius: 14px; background: #fafafa; color: #404040; text-align: left; transition: .2s ease; }
    .category-tab i { font-size: 1.35rem; line-height: 1; color: #0a0a0a; }
    .category-tab span { font-size: .82rem; font-weight: 800; line-height: 1.1; }
    .category-tab small { display: block; margin-top: .15rem; color: #8a8a8a; font-size: .7rem; font-weight: 600; }
    .category-tab:hover { border-color: #bdbdbd; background: #fff; }
    .category-tab.active { border-color: #0a0a0a; background: #0a0a0a; color: #fff; box-shadow: 0 10px 24px rgba(0,0,0,.16); }
    .category-tab.active i { color: #fff; }
    .category-tab.active small { color: rgba(255,255,255,.6); }

    .refine-row { display: flex; flex-wrap: wrap; align-items: center; gap: .6rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0; }
    .refine-row .filter-label { margin: 0 .25rem 0 0; }
    .refine-select { width: auto; min-width: 170px; min-height: 40px; padding-block: .4rem; border-color: #e5e5e5; border-radius: 10px; color: #404040; font-size: .8rem; font-weight: 700; }
    .refine-select.is-set { border-color: #0a0a0a; color: #0a0a0a; }

    .catalogue-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin: 1.75rem 0 1rem; padding: 1rem 1.1rem; background: #fff; border: 1px solid #e8e8e8; border-radius: 16px; }
    .result-count { color: #0a0a0a; font-size: .96rem; font-weight: 800; }
    .result-count small { display: block; margin-top: .15rem; color: #737373; font-size: .75rem; font-weight: 500; }
    .toolbar-actions { display: flex; align-items: center; gap: .65rem; }
    .payment-switch { display: inline-flex; padding: .3rem; background: #f0f0f0; border-radius: 11px; }
    .payment-option { padding: .6rem .78rem; border: 0; border-radius: 8px; background: transparent; color: #5c5c5c; font-size: .79rem; font-weight: 800; white-space: nowrap; }
    .payment-option.active { background: #fff; color: #0a0a0a; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
    .sort-select { width: 190px; min-height: 42px; border-color: #e5e5e5; border-radius: 10px; color: #404040; font-size: .8rem; font-weight: 700; }

    .active-filters { display: flex; flex-wrap: wrap; align-items: center; gap: .45rem; margin-bottom: 1.25rem; }
    .active-filter { display: inline-flex; align-items: center; gap: .3rem; padding: .38rem .45rem .38rem .7rem; border-radius: 999px; background: #ececec; color: #262626; font-size: .76rem; font-weight: 700; }
    .active-filter:hover { background: #0a0a0a; color: #fff; }
    .active-filter i { font-size: .95rem; }
    .clear-filters { margin-left: .25rem; color: #6b6b6b; font-size: .76rem; font-weight: 700; text-decoration: underline; }

    .lipa-notice { display: flex; gap: .8rem; margin-bottom: 1.25rem; padding: 1rem 1.1rem; background: #f4f4f4; border: 1px solid #e5e5e5; border-radius: 14px; color: #404040; }
    .lipa-notice i { color: #0a0a0a; font-size: 1.2rem; }
    .lipa-notice strong { display: block; margin-bottom: .15rem; color: #0a0a0a; }

    .catalogue-grid { --bs-gutter-x: 1.25rem; --bs-gutter-y: 1.25rem; }
    .catalogue-card { position: relative; display: flex; height: 100%; flex-direction: column; padding: .7rem; overflow: hidden; background: #fff; border: 1px solid #e8e8e8; border-radius: 18px; box-shadow: 0 10px 32px rgba(0,0,0,.045); transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .catalogue-card:hover { transform: translateY(-4px); border-color: #cfcfcf; box-shadow: 0 22px 48px rgba(0,0,0,.1); }
    .product-media { position: relative; display: grid; aspect-ratio: 1 / 1; place-items: center; overflow: hidden; background: #f4f4f4; border-radius: 13px; }
    .product-media img { width: 100%; height: 100%; padding: 1.1rem; object-fit: contain; mix-blend-mode: multiply; transition: transform .3s ease; }
    .catalogue-card:hover .product-media img { transform: scale(1.04); }
    .image-placeholder { display: grid; width: 100%; height: 100%; place-items: center; color: #8a8a8a; text-align: center; }
    .image-placeholder i { display: block; margin-bottom: .4rem; font-size: 2.4rem; color: #b0b0b0; }
    .image-placeholder span { font-size: .72rem; font-weight: 700; }
    .media-badges { position: absolute; z-index: 2; top: .65rem; left: .65rem; right: .65rem; display: flex; justify-content: space-between; gap: .35rem; pointer-events: none; }
    .media-badge { padding: .32rem .55rem; border-radius: 999px; background: rgba(255,255,255,.92); color: #262626; font-size: .64rem; font-weight: 800; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .media-badge--dark { margin-left: auto; background: #0a0a0a; color: #fff; }
    .product-content { display: flex; flex: 1; flex-direction: column; padding: .95rem .4rem .35rem; }
    .product-kicker { color: #6b6b6b; font-size: .64rem; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
    .product-name { margin: .35rem 0 .6rem; color: #0a0a0a; font-size: .98rem; font-weight: 800; line-height: 1.35; letter-spacing: -.02em; }
    .product-name a { color: inherit; }
    .product-name a::after { content: ''; position: absolute; inset: 0; z-index: 1; }
    .option-pills { display: flex; flex-wrap: wrap; gap: .3rem; margin-bottom: .75rem; }
    .option-pill { padding: .2rem .45rem; border: 1px solid #e5e5e5; border-radius: 6px; color: #525252; font-size: .68rem; font-weight: 700; }
    .product-pricing { margin-top: auto; }
    .product-price { margin: 0; color: #0a0a0a; font-family: 'Manrope', sans-serif; font-size: 1.2rem; font-weight: 800; letter-spacing: -.03em; }
    .product-price small { margin-right: .2rem; color: #737373; font-family: inherit; font-size: .72rem; font-weight: 700; letter-spacing: 0; }
    .product-price--request { color: #404040; font-size: 1.02rem; }
    .payment-detail { display: block; margin-top: .2rem; color: #737373; font-size: .72rem; }
    .stock-detail { display: inline-flex; align-items: center; gap: .35rem; width: fit-content; margin-top: .5rem; color: #5c5c5c; font-size: .7rem; font-weight: 700; }
    .stock-detail::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #a3a3a3; }
    .stock-detail--available::before { background: #0a0a0a; }
    .stock-detail--limited::before { background: #8f8f8f; }
    .stock-detail--out_of_stock::before { background: transparent; box-shadow: inset 0 0 0 1.5px #8f8f8f; }
    .product-actions { position: relative; z-index: 2; display: grid; grid-template-columns: 1fr auto; gap: .45rem; margin-top: .9rem; }
    .product-action { display: flex; align-items: center; justify-content: space-between; padding: .72rem .85rem; border-radius: 10px; background: #f2f2f2; color: #0a0a0a; font-size: .8rem; font-weight: 800; }
    .product-action:hover { background: #0a0a0a; color: #fff; }
    .product-whatsapp { display: grid; width: 42px; place-items: center; border: 1px solid #e5e5e5; border-radius: 10px; color: #0a0a0a; font-size: 1.15rem; }
    .product-whatsapp:hover { border-color: #0a0a0a; background: #0a0a0a; color: #fff; }

    .pagination { gap: .3rem; }
    .page-link { min-width: 40px; border-color: #e5e5e5; border-radius: 9px !important; color: #404040; text-align: center; }
    .page-item.active .page-link { border-color: #0a0a0a; background: #0a0a0a; }
    .empty-results { padding: 5rem 1rem; text-align: center; background: #fff; border: 1px solid #e8e8e8; border-radius: 18px; }
    .empty-results i { color: #a3a3a3; font-size: 3rem; }

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
        .scroll-row { margin: 0 -.85rem; padding-inline: .85rem; }
        .category-tab { min-width: 92px; padding: .7rem .75rem; }
        .search-button { width: 100%; }
        .refine-select { flex: 1; min-width: 0; }
        .refine-row .filter-label { width: 100%; }
        .toolbar-actions, .payment-switch { width: 100%; }
        .payment-option { flex: 1; }
        .sort-select { width: 100%; }
        /* Two compact cards per row on phones */
        .catalogue-grid { --bs-gutter-x: .65rem; --bs-gutter-y: .65rem; }
        .catalogue-card { padding: .45rem; border-radius: 14px; }
        .product-media { border-radius: 10px; }
        .product-media img { padding: .6rem; }
        .media-badges { top: .4rem; left: .4rem; right: .4rem; }
        .media-badge { padding: .25rem .42rem; font-size: .58rem; }
        .product-content { padding: .7rem .25rem .2rem; }
        .product-name { font-size: .84rem; }
        .option-pills { display: none; }
        .product-price { font-size: 1rem; }
        .payment-detail { font-size: .66rem; }
        .product-actions { grid-template-columns: 1fr; }
        .product-action { padding: .6rem .65rem; font-size: .74rem; }
        .product-whatsapp { display: none; }
    }
</style>
@endsection

@section('content')
<main class="catalogue-page">
    <header class="catalogue-hero">
        <div class="container catalogue-hero__content">
            <span class="catalogue-eyebrow">DIGITAL DISTRICT KENYA COLLECTION</span>
            <h1 class="catalogue-title">Find a device that <span>fits your life.</span></h1>
            <p class="catalogue-subtitle">Phones, tablets, MacBooks, watches, audio and accessories. Filter by what matters, then talk to our team when you are ready.</p>
        </div>
    </header>

    <div class="container catalogue-shell">
        <form method="GET" action="{{ route('pricing') }}" id="filterForm" class="filter-panel">
            <input type="hidden" name="payment_method" id="paymentMethodInput" value="{{ $filters['payment_method'] ?? 'full' }}">
            <input type="hidden" name="brand" id="brandInput" value="{{ $filters['brand'] ?? '' }}">
            <input type="hidden" name="category" id="categoryInput" value="{{ $filters['category'] ?? '' }}">

            <div class="row g-2">
                <div class="col-sm">
                    <div class="search-wrap">
                        <i class="ri-search-line"></i>
                        <input class="form-control catalogue-search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search iPhone 17, Galaxy S26, AirPods…" aria-label="Search products">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn search-button" type="submit">Search</button></div>
            </div>

            <div class="scroll-row category-tabs" role="group" aria-label="Category">
                <button type="button" class="category-tab {{ blank($filters['category'] ?? null) ? 'active' : '' }}" onclick="setFilter('category', '')">
                    <i class="ri-apps-2-line"></i>
                    <div><span>All</span><small>{{ $allCount }} {{ Str::plural('item', $allCount) }}</small></div>
                </button>
                @foreach($categoryMeta as $category => [$label, $icon])
                    @continue(! $categoryCounts->has($category) && ($filters['category'] ?? '') !== $category)
                    <button type="button" class="category-tab {{ ($filters['category'] ?? '') === $category ? 'active' : '' }}" onclick="toggleFilter('category', '{{ $category }}')">
                        <i class="{{ $icon }}"></i>
                        <div><span>{{ $label }}</span><small>{{ $categoryCounts->get($category, 0) }} {{ Str::plural('item', $categoryCounts->get($category, 0)) }}</small></div>
                    </button>
                @endforeach
            </div>

            <p class="filter-label">Brand</p>
            <div class="scroll-row" role="group" aria-label="Brand">
                @foreach($brandCounts as $brand => $count)
                    <button type="button" class="filter-chip {{ ($filters['brand'] ?? '') === $brand ? 'active' : '' }}" data-value="{{ $brand }}" onclick="toggleFilter('brand', this.dataset.value)">
                        @if($brand === 'Apple')<i class="ri-apple-fill"></i>@endif
                        {{ $brand }} <small>{{ $count }}</small>
                    </button>
                @endforeach
            </div>

            <div class="refine-row">
                <p class="filter-label">Refine</p>
                <select name="price_range" class="form-select refine-select {{ isset($priceRanges[$filters['price_range'] ?? '']) ? 'is-set' : '' }}" aria-label="Price range" onchange="filterForm.submit()">
                    <option value="">Any price</option>
                    @foreach($priceRanges as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['price_range'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @if($showStorage)
                    <select name="storage" class="form-select refine-select {{ isset($storageOptions[$filters['storage'] ?? '']) ? 'is-set' : '' }}" aria-label="Storage" onchange="filterForm.submit()">
                        <option value="">Any storage</option>
                        @foreach($storageOptions as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['storage'] ?? '') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </form>

        <div class="catalogue-toolbar">
            <div class="result-count">
                {{ number_format($products->total()) }} {{ Str::plural('product', $products->total()) }}
                <small>{{ $hasActiveFilters ? 'Matching your selected filters' : 'Explore the complete collection' }}</small>
            </div>
            <div class="toolbar-actions">
                <div class="payment-switch" aria-label="Payment method">
                    <button type="button" class="payment-option {{ !$isLipa ? 'active' : '' }}" onclick="switchPaymentMethod('full')">Pay in full</button>
                    <button type="button" class="payment-option {{ $isLipa ? 'active' : '' }}" onclick="switchPaymentMethod('lipa')">Lipa Mdogo Mdogo</button>
                </div>
                <select class="form-select sort-select" name="sort" form="filterForm" aria-label="Sort products">
                    <option value="featured" @selected(($filters['sort'] ?? '') === 'featured')>Featured</option>
                    <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest first</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: low to high</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: high to low</option>
                    <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Name: A–Z</option>
                </select>
            </div>
        </div>

        @if($hasActiveFilters)
            <div class="active-filters" aria-label="Active filters">
                @foreach($activeFilters as $key => $label)
                    <a href="{{ route('pricing', request()->except([$key, 'page'])) }}" class="active-filter" aria-label="Remove filter {{ $label }}">{{ $label }} <i class="ri-close-line"></i></a>
                @endforeach
                <a href="{{ route('pricing', ['payment_method' => $filters['payment_method'] ?? 'full']) }}" class="clear-filters">Clear all</a>
            </div>
        @endif

        @if($isLipa)
            <div class="lipa-notice">
                <i class="ri-information-line"></i>
                <div><strong>Lipa Mdogo Mdogo estimate for iPhones</strong><span>40% upfront, followed by 12 weekly payments. Eligibility and final terms must be confirmed. <a href="{{ route('policies.show', 'payment-plans') }}" class="fw-semibold">Read guidance</a></span></div>
            </div>
        @endif

        @if($products->isNotEmpty())
            <div class="row catalogue-grid">
                @foreach($products as $product)
                    @php
                        $lead = $product->lead_variant;
                        $optionCount = $product->variants->count();
                        $pills = $product->option_labels->take(4);
                        $morePills = $product->option_labels->count() - $pills->count();
                        $whatsappUrl = 'https://wa.me/254721920545?text=' . urlencode("Hello, I am interested in {$product->name}");
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-6">
                        <article class="catalogue-card">
                            <div class="product-media">
                                <div class="media-badges">
                                    @if($optionCount > 1)<span class="media-badge">{{ $optionCount }} options</span>@endif
                                    @if($product->lipa)<span class="media-badge media-badge--dark">Lipa Mdogo Mdogo</span>@endif
                                </div>
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="image-placeholder"><div><i class="{{ $categoryMeta[$product->category->name][1] ?? 'ri-image-line' }}"></i><span>Image coming soon</span></div></div>
                                @endif
                            </div>
                            <div class="product-content">
                                <span class="product-kicker">{{ $product->brand->name }} · {{ $categoryMeta[$product->category->name][0] ?? $product->category->name }}</span>
                                <h2 class="product-name"><a href="{{ route('phones.show', $lead) }}">{{ $product->name }}</a></h2>
                                @if($pills->isNotEmpty())
                                    <div class="option-pills">
                                        @foreach($pills as $pill)<span class="option-pill">{{ $pill }}</span>@endforeach
                                        @if($morePills > 0)<span class="option-pill">+{{ $morePills }}</span>@endif
                                    </div>
                                @endif
                                <div class="product-pricing">
                                    @if($product->lipa)
                                        <p class="product-price">KES {{ number_format($product->lipa['upfront']) }} <small>upfront</small></p>
                                        <span class="payment-detail">Then KES {{ number_format($product->lipa['weekly']) }} weekly for {{ $product->lipa['weeks'] }} weeks</span>
                                    @elseif($product->from_price)
                                        <p class="product-price">@if($product->has_price_spread)<small>From</small>@endif KES {{ number_format($product->from_price) }}</p>
                                    @else
                                        <p class="product-price product-price--request">Price on request</p>
                                        <span class="payment-detail">Ask our team for today’s price</span>
                                    @endif
                                    <span class="stock-detail stock-detail--{{ $product->availability['status'] }}">{{ $product->availability['label'] }}</span>
                                </div>
                                <div class="product-actions">
                                    <a href="{{ route('phones.show', $lead) }}" class="product-action"><span>{{ $optionCount > 1 ? 'Choose options' : 'View details' }}</span><i class="ri-arrow-right-line"></i></a>
                                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="product-whatsapp" aria-label="Enquire about {{ $product->name }} on WhatsApp"><i class="ri-whatsapp-line"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">{{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
        @else
            <div class="empty-results">
                <i class="ri-search-line"></i>
                <h2 class="mt-3">No products matched those filters</h2>
                <p class="text-muted">Try another search or clear your filters to see the full collection.</p>
                <a href="{{ route('pricing') }}" class="btn btn-primary mt-2">View all products</a>
            </div>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    const filterForm = document.getElementById('filterForm');

    function setFilter(filterName, value) {
        document.getElementById(`${filterName}Input`).value = value;
        filterForm.submit();
    }

    function toggleFilter(filterName, value) {
        const input = document.getElementById(`${filterName}Input`);
        setFilter(filterName, input.value === value ? '' : value);
    }

    // Keep the selected category or brand in view when its row scrolls sideways.
    document.querySelectorAll('.scroll-row .active').forEach((chip) => {
        const row = chip.parentElement;
        row.scrollLeft = chip.offsetLeft - (row.clientWidth - chip.offsetWidth) / 2;
    });

    function switchPaymentMethod(method) {
        document.getElementById('paymentMethodInput').value = method;
        filterForm.submit();
    }

    document.querySelector('.sort-select').addEventListener('change', () => filterForm.submit());
</script>
@endsection
