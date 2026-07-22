@extends('layouts.landing-master')

@section('title', ($selectedPolicy?->title ?? 'Shopping help') . ' | Phone Express Kenya')
@section('meta_description', $selectedPolicy?->summary ?? 'Important delivery, warranty, returns and payment-plan guidance for Phone Express Kenya customers.')

@section('styles')
<style>
    .trust-page { min-height: 100vh; padding: 9rem 0 6rem; background: #f6f8f6; }
    .trust-hero { position: relative; overflow: hidden; padding: 3.5rem; color: #fff; background: linear-gradient(125deg, #082a1c, #145338); border-radius: 28px; box-shadow: 0 24px 60px rgba(9,42,28,.16); }
    .trust-hero::after { content: ''; position: absolute; width: 320px; height: 320px; right: -90px; top: -140px; border: 1px solid rgba(255,255,255,.14); border-radius: 50%; box-shadow: 0 0 0 55px rgba(255,255,255,.035), 0 0 0 110px rgba(255,255,255,.025); }
    .trust-eyebrow { display: inline-flex; align-items: center; gap: .45rem; margin-bottom: 1rem; color: #b5dec3; font-size: .72rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
    .trust-title { position: relative; z-index: 1; max-width: 720px; margin-bottom: 1rem; color: #fff !important; font-size: clamp(2.5rem, 5vw, 4.4rem); font-weight: 800; line-height: 1.04; letter-spacing: -.055em; text-shadow: none !important; }
    .trust-copy { position: relative; z-index: 1; max-width: 650px; margin: 0; color: rgba(255,255,255,.72); font-size: 1rem; line-height: 1.75; }
    .trust-grid { margin-top: 1.5rem; }
    .policy-nav { display: grid; gap: .75rem; position: sticky; top: 100px; }
    .policy-nav__item { display: flex; align-items: center; gap: .85rem; padding: 1rem; color: #304139; background: #fff; border: 1px solid #e0e7e2; border-radius: 14px; transition: .2s ease; }
    .policy-nav__item:hover, .policy-nav__item.active { color: #123f2b; border-color: #9fbeaa; transform: translateY(-2px); box-shadow: 0 12px 30px rgba(20,34,27,.07); }
    .policy-nav__icon { display: grid; width: 42px; height: 42px; flex: 0 0 42px; place-items: center; color: #216b46; background: #eaf4ed; border-radius: 11px; font-size: 1.2rem; }
    .policy-nav__item strong { display: block; font-size: .86rem; }
    .policy-nav__item small { color: #7b8780; font-size: .68rem; }
    .policy-panel { padding: clamp(1.35rem, 4vw, 2.5rem); background: #fff; border: 1px solid #e0e7e2; border-radius: 22px; box-shadow: 0 18px 50px rgba(20,34,27,.065); }
    .policy-status { display: inline-flex; align-items: center; gap: .4rem; padding: .42rem .65rem; color: #73520c; background: #fff5d9; border-radius: 999px; font-size: .68rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; }
    .policy-status.approved { color: #1c6541; background: #e8f5ed; }
    .policy-panel h1 { margin: 1rem 0 .75rem; color: #17251d; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -.045em; }
    .policy-summary { max-width: 720px; color: #647168; font-size: .98rem; line-height: 1.7; }
    .policy-section { padding: 1.15rem 0; border-top: 1px solid #e8ede9; }
    .policy-section:first-of-type { margin-top: 1.5rem; }
    .policy-section h2 { margin-bottom: .4rem; color: #24362c; font-size: 1rem; font-weight: 800; }
    .policy-section p { margin: 0; color: #68756d; line-height: 1.75; }
    .confirmation-box { display: flex; gap: .8rem; margin-top: 1.5rem; padding: 1rem; color: #4f5e55; background: #f4f7f5; border-radius: 13px; }
    .confirmation-box i { color: #227149; font-size: 1.25rem; }
    .trust-actions { display: flex; flex-wrap: wrap; gap: .7rem; margin-top: 1.25rem; }
    .trust-action { display: inline-flex; min-height: 48px; align-items: center; gap: .45rem; padding: .75rem 1rem; border-radius: 11px; font-weight: 800; }
    .trust-action--primary { color: #fff; background: #1c9251; }
    .trust-action--primary:hover { color: #fff; background: #157841; }
    .trust-action--secondary { color: #123f2b; background: #eaf4ed; }
    @media (max-width: 991.98px) { .trust-page { padding-top: 7rem; } .policy-nav { position: static; grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575.98px) { .trust-hero { padding: 2rem 1.25rem; border-radius: 20px; } .policy-nav { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
@php
    $icons = ['delivery' => 'ri-truck-line', 'warranty' => 'ri-shield-check-line', 'returns' => 'ri-arrow-go-back-line', 'payment-plans' => 'ri-bank-card-line'];
    $activePolicy = $selectedPolicy ?? $policies->first();
@endphp
<main class="trust-page">
    <div class="container">
        <header class="trust-hero">
            <span class="trust-eyebrow"><i class="ri-shield-check-line"></i> SHOP WITH CLARITY</span>
            <h1 class="trust-title">Important details, before you decide.</h1>
            <p class="trust-copy">Review the guidance below, then confirm the exact terms for your chosen phone and location with our team before making payment.</p>
        </header>

        <div class="row g-4 trust-grid">
            <div class="col-lg-4">
                <nav class="policy-nav" aria-label="Shopping guidance">
                    @foreach($policies as $policy)
                        <a href="{{ route('policies.show', $policy) }}" class="policy-nav__item {{ $activePolicy?->is($policy) ? 'active' : '' }}">
                            <span class="policy-nav__icon"><i class="{{ $icons[$policy->key] ?? 'ri-information-line' }}"></i></span>
                            <span><strong>{{ $policy->title }}</strong><small>Version {{ $policy->version }}</small></span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="col-lg-8">
                @if($activePolicy)
                    <article class="policy-panel">
                        <span class="policy-status {{ $activePolicy->isApproved() ? 'approved' : '' }}">
                            <i class="{{ $activePolicy->isApproved() ? 'ri-checkbox-circle-line' : 'ri-information-line' }}"></i>
                            {{ $activePolicy->isApproved() ? 'Approved policy' : 'Confirm before purchase' }}
                        </span>
                        <h1>{{ $activePolicy->title }}</h1>
                        <p class="policy-summary">{{ $activePolicy->summary }}</p>

                        @foreach($activePolicy->content as $section)
                            <section class="policy-section">
                                <h2>{{ $section['heading'] }}</h2>
                                <p>{{ $section['body'] }}</p>
                            </section>
                        @endforeach

                        <div class="confirmation-box"><i class="ri-customer-service-2-line"></i><span>This guidance avoids making assumptions. Our team will confirm the final terms for your specific phone, order and location.</span></div>
                        <div class="trust-actions">
                            <a href="https://wa.me/254721920545?text={{ urlencode('Hello Phone Express, I would like to confirm your '.$activePolicy->title.'.') }}" target="_blank" rel="noopener" class="trust-action trust-action--primary"><i class="ri-whatsapp-line"></i> Confirm with our team</a>
                            <a href="{{ route('pricing') }}" class="trust-action trust-action--secondary"><i class="ri-smartphone-line"></i> Browse phones</a>
                        </div>
                    </article>
                @else
                    <div class="policy-panel"><h1>Guidance is being prepared</h1><p class="policy-summary">Please contact our team before placing an order.</p></div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
