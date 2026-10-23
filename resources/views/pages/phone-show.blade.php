@extends('layouts.landing-master')

@section('title', $phone->name . ' | Digital District Kenya')
@section('meta_description', 'View the current price and payment options for ' . $phone->name . ' at Digital District Kenya.')

@section('styles')
<style>
    .product-page { padding: 9rem 0 6rem; background: #fafafa; }
    .product-breadcrumb { margin-bottom: 1.5rem; color: #737373; font-size: .8rem; }
    .product-breadcrumb a { color: #0a0a0a; font-weight: 700; }
    .product-detail { padding: 1rem; background: #fff; border: 1px solid #e8e8e8; border-radius: 24px; box-shadow: 0 24px 65px rgba(0,0,0,.07); }
    .product-detail__media { display: grid; min-height: 540px; place-items: center; overflow: hidden; background: #f4f4f4; border-radius: 18px; }
    .product-detail__media img { width: 100%; height: 520px; padding: 2rem; object-fit: contain; }
    .detail-placeholder { color: #8a8a8a; text-align: center; }
    .detail-placeholder i { display: block; margin-bottom: .7rem; color: #b0b0b0; font-size: 4rem; }
    .product-detail__content { padding: clamp(1.5rem, 4vw, 3.5rem); }
    .detail-brand { display: inline-flex; padding: .4rem .65rem; color: #fff; background: #0a0a0a; border-radius: 999px; font-size: .7rem; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
    .detail-title { margin: 1rem 0; color: #0a0a0a; font-size: clamp(2rem, 4vw, 3.4rem); font-weight: 800; line-height: 1.08; letter-spacing: -.05em; }
    .detail-price { margin-bottom: 1.5rem; color: #0a0a0a; font-family: 'Manrope', sans-serif; font-size: 1.75rem; font-weight: 800; }
    .detail-options { margin: 0 0 1.5rem; }
    .detail-options__label { margin-bottom: .55rem; color: #7a7a7a; font-size: .68rem; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; }
    .detail-options__list { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: .5rem; }
    .detail-option { display: block; padding: .7rem .8rem; color: #262626; background: #fff; border: 1px solid #e5e5e5; border-radius: 12px; transition: .2s ease; }
    .detail-option:hover { color: #0a0a0a; border-color: #a3a3a3; }
    .detail-option.active { color: #fff; background: #0a0a0a; border-color: #0a0a0a; }
    .detail-option strong { display: block; font-size: .82rem; line-height: 1.3; }
    .detail-option span { display: block; margin-top: .2rem; color: #737373; font-size: .74rem; font-weight: 700; }
    .detail-option.active span { color: rgba(255,255,255,.65); }
    .detail-facts { display: grid; grid-template-columns: repeat(2, 1fr); gap: .7rem; margin: 1.5rem 0; }
    .detail-fact { padding: .9rem; background: #fafafa; border: 1px solid #ebebeb; border-radius: 12px; }
    .detail-fact small { display: block; margin-bottom: .2rem; color: #7a7a7a; font-size: .68rem; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; }
    .detail-fact strong { color: #1a1a1a; font-size: .9rem; }
    .availability-note { display: flex; gap: .65rem; margin-bottom: 1.3rem; padding: .85rem; color: #525252; background: #f4f4f4; border: 1px solid #e5e5e5; border-radius: 11px; font-size: .8rem; }
    .detail-actions { display: grid; grid-template-columns: 1fr auto; gap: .7rem; }
    .detail-whatsapp, .detail-back { display: inline-flex; min-height: 52px; align-items: center; justify-content: center; border-radius: 12px; font-weight: 800; }
    .detail-whatsapp { gap: .5rem; color: #fff; background: #0a0a0a; }
    .detail-whatsapp:hover { color: #fff; background: #262626; }
    .detail-back { padding-inline: 1rem; color: #0a0a0a; background: #f0f0f0; }
    .payment-card { margin-top: 1rem; padding: 1rem; color: #4d4d4d; background: #fafafa; border: 1px solid #e8e8e8; border-radius: 12px; font-size: .8rem; }
    .payment-card strong { color: #0a0a0a; }
    .related-section { padding-top: 5rem; }
    .pairing-section { margin-top: 1.25rem; padding: 1.5rem; background: #fff; border: 1px solid #e8e8e8; border-radius: 24px; }
    .pairing-head { display: flex; flex-wrap: wrap; align-items: baseline; justify-content: space-between; gap: .5rem; margin-bottom: 1rem; }
    .pairing-head h2 { margin: 0; color: #0a0a0a; font-size: 1.35rem; font-weight: 800; }
    .pairing-head a { color: #0a0a0a; font-size: .82rem; font-weight: 800; text-decoration: underline; }
    .pairing-card { display: flex; height: 100%; align-items: center; gap: .85rem; padding: .6rem; color: #0a0a0a; background: #fafafa; border: 1px solid #ededed; border-radius: 14px; transition: .2s ease; }
    .pairing-card:hover { color: #0a0a0a; background: #fff; border-color: #cfcfcf; box-shadow: 0 12px 28px rgba(0,0,0,.07); }
    .pairing-card__media { display: grid; flex: 0 0 72px; height: 72px; place-items: center; background: #fff; border-radius: 10px; }
    .pairing-card__media img { width: 100%; height: 100%; padding: .4rem; object-fit: contain; }
    .pairing-card__media i { color: #b0b0b0; font-size: 1.6rem; }
    .pairing-card strong { display: block; font-size: .85rem; line-height: 1.3; }
    .pairing-card span { display: block; margin-top: .2rem; color: #525252; font-size: .78rem; font-weight: 700; }
    .related-heading { margin-bottom: 1.5rem; color: #0a0a0a; font-size: 1.8rem; font-weight: 800; }
    .related-card { display: block; height: 100%; padding: .7rem; color: #0a0a0a; background: #fff; border: 1px solid #e8e8e8; border-radius: 16px; transition: .2s ease; }
    .related-card:hover { color: #0a0a0a; transform: translateY(-4px); box-shadow: 0 16px 36px rgba(0,0,0,.08); }
    .related-card img, .related-placeholder { width: 100%; height: 190px; object-fit: contain; background: #f4f4f4; border-radius: 11px; }
    .related-placeholder { display: grid; place-items: center; color: #a3a3a3; font-size: 2rem; }
    .related-card h3 { margin: .85rem .35rem .35rem; font-size: .9rem; font-weight: 800; line-height: 1.35; }
    .related-card p { margin: 0 .35rem .45rem; color: #0a0a0a; font-weight: 800; }
    @media (max-width: 767.98px) {
        .product-page { padding-top: 7rem; }
        .product-detail__media { min-height: 360px; }
        .product-detail__media img { height: 350px; }
        .detail-actions { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<main class="product-page">
    <div class="container">
        <nav class="product-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('pricing') }}">Shop</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('pricing', ['category' => $phone->product->category->name]) }}">{{ $phone->product->category->name }}</a> <i class="ri-arrow-right-s-line"></i>
            <span>{{ $phone->name }}</span>
        </nav>

        <article class="product-detail">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6">
                    <div class="product-detail__media">
                        @if($imageAvailable)
                            <img src="{{ asset($phone->image_path) }}" alt="{{ $phone->name }}">
                        @else
                            <div class="detail-placeholder"><i class="ri-image-line"></i><strong>Image coming soon</strong></div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-detail__content">
                        <span class="detail-brand">{{ $brand }}</span>
                        <h1 class="detail-title">{{ $phone->name }}</h1>
                        <p class="detail-price">{{ $phone->price > 0 ? 'KES ' . number_format($phone->price) : 'Price on request' }}</p>

                        @if($options->count() > 1)
                            <div class="detail-options">
                                <p class="detail-options__label">{{ $options->count() }} options available</p>
                                <div class="detail-options__list">
                                    @foreach($options as $option)
                                        @php
                                            $optionLabel = collect([
                                                $option->storage_gb ? ($option->storage_gb >= 1024 ? ($option->storage_gb / 1024).'TB' : $option->storage_gb.'GB') : null,
                                                $option->ram_gb ? $option->ram_gb.'GB RAM' : null,
                                                $option->colour,
                                                in_array($option->connectivity, ['E-SIM', 'WiFi', 'Cellular'], true) ? $option->connectivity : null,
                                            ])->filter()->implode(' · ') ?: $option->label;
                                        @endphp
                                        <a href="{{ route('phones.show', $option) }}" class="detail-option {{ $option->is($phone) ? 'active' : '' }}" @if($option->is($phone)) aria-current="page" @endif>
                                            <strong>{{ $optionLabel }}</strong>
                                            <span>{{ $option->price > 0 ? 'KES ' . number_format($option->price) : 'Price on request' }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="detail-facts">
                            <div class="detail-fact"><small>Brand</small><strong>{{ $brand }}</strong></div>
                            @if($storage)<div class="detail-fact"><small>Storage</small><strong>{{ $storage }}</strong></div>@endif
                            @if($phone->ram_gb)<div class="detail-fact"><small>RAM</small><strong>{{ $phone->ram_gb }}GB</strong></div>@endif
                            @if($phone->colour)<div class="detail-fact"><small>Colour</small><strong>{{ $phone->colour }}</strong></div>@endif
                            @if($phone->connectivity)<div class="detail-fact"><small>Connectivity</small><strong>{{ $phone->connectivity }}</strong></div>@endif
                            <div class="detail-fact"><small>Availability</small><strong>{{ $availability['label'] }}</strong></div>
                            <div class="detail-fact"><small>Delivery</small><strong>Confirm destination and fee</strong></div>
                        </div>

                        <div class="availability-note"><i class="ri-information-line"></i><span>{{ $availability['message'] }} Price and product details are read directly from our catalogue; confirm warranty details before payment.</span></div>

                        <p class="mb-3"><a href="{{ route('policies.index') }}" class="fw-semibold text-dark text-decoration-underline">Review delivery, warranty, returns and payment guidance <i class="ri-arrow-right-line"></i></a></p>

                        <div class="detail-actions">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="detail-whatsapp"><i class="ri-whatsapp-line"></i> Ask about this product</a>
                            <a href="{{ route('pricing') }}" class="detail-back" aria-label="Back to all products"><i class="ri-arrow-left-line"></i></a>
                        </div>

                        @if($upfront)
                            <div class="payment-card"><strong>Lipa Mdogo Mdogo estimate:</strong> KES {{ number_format($upfront) }} upfront, then KES {{ number_format($weekly) }} weekly for {{ $weeks }} weeks. Approval requirements apply.</div>
                        @endif
                    </div>
                </div>
            </div>
        </article>

        @if($pairings->isNotEmpty())
            <section class="pairing-section" aria-label="Accessories to pair with this device">
                <div class="pairing-head">
                    <h2>Pair it with</h2>
                    <a href="{{ route('home') }}#accessories">All accessories</a>
                </div>
                <div class="row g-2">
                    @foreach($pairings as $pairing)
                        @php($pairingImage = filled($pairing->image_path) && is_file(public_path($pairing->image_path)))
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('phones.show', $pairing) }}" class="pairing-card">
                                <div class="pairing-card__media">
                                    @if($pairingImage)<img src="{{ asset($pairing->image_path) }}" alt="{{ $pairing->product->name }}" loading="lazy">@else<i class="{{ ['Audio' => 'ri-headphone-line', 'Watches' => 'ri-time-line'][$pairing->product->category->name] ?? 'ri-keyboard-line' }}"></i>@endif
                                </div>
                                <div>
                                    <strong>{{ $pairing->product->name }}</strong>
                                    <span>KES {{ number_format($pairing->price) }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($relatedPhones->isNotEmpty())
            <section class="related-section">
                <h2 class="related-heading">You may also like</h2>
                <div class="row g-3">
                    @foreach($relatedPhones as $related)
                        @php($relatedImage = filled($related->image_path) && is_file(public_path($related->image_path)))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('phones.show', $related) }}" class="related-card">
                                @if($relatedImage)<img src="{{ asset($related->image_path) }}" alt="{{ $related->name }}" loading="lazy">@else<div class="related-placeholder"><i class="ri-image-line"></i></div>@endif
                                <h3>{{ $related->name }}</h3>
                                <p>KES {{ number_format($related->price) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</main>
@endsection
