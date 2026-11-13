<footer class="landing-main-footer py-4">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <span class="text-white-50 fs-13">© <span id="year"></span> Digital District Kenya. All rights reserved.</span>
        <nav class="d-flex flex-wrap justify-content-center gap-3" aria-label="Footer navigation">
            <a href="{{ route('pricing') }}" class="text-white-50 fs-13">Shop phones</a>
            <a href="{{ route('policies.show', 'delivery') }}" class="text-white-50 fs-13">Delivery</a>
            <a href="{{ route('policies.show', 'warranty') }}" class="text-white-50 fs-13">Warranty</a>
            <a href="{{ route('policies.show', 'returns') }}" class="text-white-50 fs-13">Returns</a>
            <a href="{{ route('policies.show', 'payment-plans') }}" class="text-white-50 fs-13">Payment plans</a>
            <a href="{{ auth()->check() ? route('staff.dashboard') : route('login') }}" class="text-white-50 fs-13"><i class="ri-lock-2-line me-1"></i>{{ auth()->check() ? 'Staff dashboard' : 'Admin login' }}</a>
        </nav>
    </div>
    <div class="container mt-3 pt-3 developer-credit text-center text-md-start" style="border-top:1px solid rgba(255,255,255,.08)">
        <span class="text-white-50 fs-12">Designed &amp; built by
            <a href="https://x.com/levis_lance" target="_blank" rel="noopener" class="text-white fw-semibold" data-analytics-event="outbound_click" data-analytics-label="developer x">@levis_lance</a>
            · Need a website? <a href="mailto:lancelevis19@gmail.com?subject=Website%20project%20enquiry" class="text-white fw-semibold" data-analytics-event="outbound_click" data-analytics-label="developer email">lancelevis19@gmail.com</a>
        </span>
    </div>
</footer>
