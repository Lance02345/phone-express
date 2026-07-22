@extends('layouts.landing-master')

@section('title', $phone->name . ' | Phone Express Kenya')
@section('meta_description', 'View the current price and payment options for ' . $phone->name . ' at Phone Express Kenya.')

@section('styles')
<style>
    .product-page { padding: 9rem 0 6rem; background: #f7f9f7; }
    .product-breadcrumb { margin-bottom: 1.5rem; color: #748078; font-size: .8rem; }
    .product-breadcrumb a { color: #27724b; font-weight: 700; }
    .product-detail { padding: 1rem; background: #fff; border: 1px solid #e2e9e4; border-radius: 24px; box-shadow: 0 24px 65px rgba(20,34,27,.08); }
    .product-detail__media { display: grid; min-height: 540px; place-items: center; overflow: hidden; background: #f1f5f2; border-radius: 18px; }
    .product-detail__media img { width: 100%; height: 520px; padding: 2rem; object-fit: contain; }
    .detail-placeholder { color: #8b9890; text-align: center; }
    .detail-placeholder i { display: block; margin-bottom: .7rem; color: #abb6af; font-size: 4rem; }
    .product-detail__content { padding: clamp(1.5rem, 4vw, 3.5rem); }
    .detail-brand { display: inline-flex; padding: .4rem .65rem; color: #27724b; background: #eaf4ed; border-radius: 999px; font-size: .7rem; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
    .detail-title { margin: 1rem 0; color: #17251d; font-size: clamp(2rem, 4vw, 3.4rem); font-weight: 800; line-height: 1.08; letter-spacing: -.05em; }
    .detail-price { margin-bottom: 1.5rem; color: #17251d; font-family: 'Manrope', sans-serif; font-size: 1.75rem; font-weight: 800; }
    .detail-facts { display: grid; grid-template-columns: repeat(2, 1fr); gap: .7rem; margin: 1.5rem 0; }
    .detail-fact { padding: .9rem; background: #f7f9f7; border: 1px solid #e5ebe7; border-radius: 12px; }
    .detail-fact small { display: block; margin-bottom: .2rem; color: #7b877f; font-size: .68rem; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; }
    .detail-fact strong { color: #26362c; font-size: .9rem; }
    .availability-note { display: flex; gap: .65rem; margin-bottom: 1.3rem; padding: .85rem; color: #526158; background: #fff8e8; border: 1px solid #f0dfb7; border-radius: 11px; font-size: .8rem; }
    .detail-actions { display: grid; grid-template-columns: 1fr auto; gap: .7rem; }
    .detail-whatsapp, .detail-back { display: inline-flex; min-height: 52px; align-items: center; justify-content: center; border-radius: 12px; font-weight: 800; }
    .detail-whatsapp { gap: .5rem; color: #fff; background: #1f9d55; }
    .detail-whatsapp:hover { color: #fff; background: #168447; }
    .detail-back { padding-inline: 1rem; color: #123f2b; background: #eaf4ed; }
    .payment-card { margin-top: 1rem; padding: 1rem; color: #4d5b52; background: #f7f9f7; border: 1px solid #e3e9e5; border-radius: 12px; font-size: .8rem; }
    .payment-card strong { color: #17251d; }
    .related-section { padding-top: 5rem; }
    .related-heading { margin-bottom: 1.5rem; color: #17251d; font-size: 1.8rem; font-weight: 800; }
    .related-card { display: block; height: 100%; padding: .7rem; color: #17251d; background: #fff; border: 1px solid #e3e9e5; border-radius: 16px; transition: .2s ease; }
    .related-card:hover { color: #17251d; transform: translateY(-4px); box-shadow: 0 16px 36px rgba(20,34,27,.09); }
    .related-card img, .related-placeholder { width: 100%; height: 190px; object-fit: contain; background: #f2f5f3; border-radius: 11px; }
    .related-placeholder { display: grid; place-items: center; color: #9aa69e; font-size: 2rem; }
    .related-card h3 { margin: .85rem .35rem .35rem; font-size: .9rem; font-weight: 800; line-height: 1.35; }
    .related-card p { margin: 0 .35rem .45rem; color: #27724b; font-weight: 800; }
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
            <a href="{{ url('index') }}">Home</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('pricing') }}">Phones</a> <i class="ri-arrow-right-s-line"></i>
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

                        <div class="detail-facts">
                            <div class="detail-fact"><small>Brand</small><strong>{{ $brand }}</strong></div>
                            @if($storage)<div class="detail-fact"><small>Storage</small><strong>{{ $storage }}</strong></div>@endif
                            @if($phone->ram_gb)<div class="detail-fact"><small>RAM</small><strong>{{ $phone->ram_gb }}GB</strong></div>@endif
                            @if($phone->colour)<div class="detail-fact"><small>Colour</small><strong>{{ $phone->colour }}</strong></div>@endif
                            @if($phone->connectivity)<div class="detail-fact"><small>Connectivity</small><strong>{{ $phone->connectivity }}</strong></div>@endif
                            <div class="detail-fact"><small>Availability</small><strong>Confirm with our team</strong></div>
                            <div class="detail-fact"><small>Delivery</small><strong>Available across Kenya</strong></div>
                        </div>

                        <div class="availability-note"><i class="ri-information-line"></i><span>Price is read directly from our catalogue. Please confirm current stock, colour and warranty details before payment.</span></div>

                        <div class="detail-actions">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="detail-whatsapp"><i class="ri-whatsapp-line"></i> Ask about this phone</a>
                            <a href="{{ route('pricing') }}" class="detail-back" aria-label="Back to all phones"><i class="ri-arrow-left-line"></i></a>
                        </div>

                        @if($upfront)
                            <div class="payment-card"><strong>Lipa Mdogo Mdogo estimate:</strong> KES {{ number_format($upfront) }} upfront, then KES {{ number_format($weekly) }} weekly for {{ $weeks }} weeks. Approval requirements apply.</div>
                        @endif
                    </div>
                </div>
            </div>
        </article>

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
