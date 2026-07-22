<footer class="landing-main-footer py-4">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <span class="text-white-50 fs-13">© <span id="year"></span> Phone Express Kenya. All rights reserved.</span>
        <nav class="d-flex flex-wrap justify-content-center gap-3" aria-label="Footer navigation">
            <a href="{{ route('pricing') }}" class="text-white-50 fs-13">Shop phones</a>
            <a href="{{ route('policies.show', 'delivery') }}" class="text-white-50 fs-13">Delivery</a>
            <a href="{{ route('policies.show', 'warranty') }}" class="text-white-50 fs-13">Warranty</a>
            <a href="{{ route('policies.show', 'returns') }}" class="text-white-50 fs-13">Returns</a>
            <a href="{{ route('policies.show', 'payment-plans') }}" class="text-white-50 fs-13">Payment plans</a>
        </nav>
    </div>
</footer>
